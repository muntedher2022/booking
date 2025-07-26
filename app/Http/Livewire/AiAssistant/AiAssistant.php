<?php

namespace App\Http\Livewire\AiAssistant;

use App\Models\AiConversation;
use App\Models\AiMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAssistant extends Component
{
    public $conversations = [];
    public $currentConversation = null;
    public $messages = [];
    public $newMessage = '';
    public $newConversationTitle = '';

    protected $listeners = [
        'refreshConversations' => 'loadConversations',
    ];

    protected $rules = [
        'newMessage' => 'required|string',
    ];

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations = AiConversation::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function createNewConversation()
    {
        $conversation = AiConversation::create([
            'user_id' => Auth::id(),
            'title' => $this->newConversationTitle ?: 'محادثة جديدة',
        ]);

        $this->newConversationTitle = '';
        $this->loadConversations();
        $this->selectConversation($conversation->id);
    }

    public function selectConversation($conversationId)
    {
        $this->currentConversation = AiConversation::findOrFail($conversationId);
        $this->messages = $this->currentConversation->messages()->orderBy('created_at', 'asc')->get();
    }

    public function sendMessage()
    {
        $messages = [
            'newMessage.required' => 'الرجاء إدخال رسالة',
            'newMessage.string' => 'يجب أن تكون الرسالة نصية'
        ];

        $this->validate($this->rules, $messages);

        if (!$this->currentConversation) {
            $this->createNewConversation();
        }

        // حفظ رسالة المستخدم
        AiMessage::create([
            'conversation_id' => $this->currentConversation->id,
            'type' => 'user',
            'content' => $this->newMessage,
        ]);

        // الحصول على رد من Gemini API
        $aiResponse = $this->getGeminiResponse($this->newMessage);

        // حفظ رد المساعد الذكي
        AiMessage::create([
            'conversation_id' => $this->currentConversation->id,
            'type' => 'assistant',
            'content' => $aiResponse,
        ]);

        // تحديث عنوان المحادثة إذا كانت جديدة
        if ($this->currentConversation->title === 'محادثة جديدة') {
            $this->currentConversation->update([
                'title' => substr($this->newMessage, 0, 30) . (strlen($this->newMessage) > 30 ? '...' : ''),
            ]);
        }

        $this->newMessage = '';
        $this->selectConversation($this->currentConversation->id);
    }

    public function deleteConversation($conversationId)
    {
        AiConversation::findOrFail($conversationId)->delete();
        $this->currentConversation = null;
        $this->messages = [];
        $this->loadConversations();
    }

    private function getGeminiResponse($message)
    {
        $specialResponses = [
            // ردود الشكر
            'شكرا' => "العفو! 😊 لا تتردد في سؤالي إذا كان لديك أي استفسارات أخرى.",
            'شكراً' => "على الرحب والسعة! 🙏 نحن هنا لمساعدتك دائماً.",
            'thanks' => "You're welcome! 😊 Let me know if you need any further assistance.",
            'thank you' => "My pleasure! 🤗 How else can I assist you today?",
            'merci' => "De rien! 😊 N'hésitez pas à me poser d'autres questions.",

            // ردود التحية
            'مرحبا' => "مرحباً بك! 🌟 كيف يمكنني مساعدتك اليوم؟",
            'السلام عليكم' => "وعليكم السلام ورحمة الله 🌹 كيف أساعدك؟",
            'اهلا' => "أهلاً وسهلاً! 😊 ما الذي تحتاج مساعدتي فيه؟",
            'hello' => "Hello there! 👋 How can I help you today?",
            'hi' => "Hi! 😊 What can I do for you?",
            'bonjour' => "Bonjour! 😊 Comment puis-je vous aider?",

            // ردود أخرى
            'صباح الخير' => "صباح النور! 🌞 كيف يمكنني خدمتك هذا الصباح؟",
            'مساء الخير' => "مساء النور! 🌙 كيف أساعدك هذا المساء؟",
            'كيف حالك' => "أنا بخير، شكراً لسؤالك! 😊 كيف يمكنني مساعدتك اليوم؟",

            'ما اسمك' => "أنا المساعد الذكي لنظام إدارة المراسلات الرسمية. يمكنك مناداتي بـ 'المساعد'! 🤖",
            'من صنعك' => "تم تطويري لمساعدة موظفي المؤسسة في إدارة المراسلات الرسمية بشكل أكثر كفاءة. 💼",
            'مساعدة' => "يمكنني مساعدتك في:\n- إرسال الكتب الرسمية\n- استعراض التقارير\n- شرح استخدام النظام\nما الذي تريد معرفته؟",
        ];

        // تنظيف الرسالة والتحقق من الردود المخصصة
        $lowerMessage = mb_strtolower(trim($message));
        $normalizedMessage = preg_replace('/[^\p{L}\p{N}\s]/u', '', $lowerMessage); // إزالة علامات الترقيم

        foreach ($specialResponses as $keyword => $response) {
            $normalizedKeyword = mb_strtolower(preg_replace('/[^\p{L}\p{N}\s]/u', '', $keyword));

            // التحقق من وجود الكلمة المفتاحية في الرسالة
            if (str_contains($normalizedMessage, $normalizedKeyword)) {
                return $response;
            }
        }

        $faqs = [
            // معلومات عامة عن النظام
            'هذا النظام' => "أنا مساعد ذكي مدمج في نظام إدارة البيانات الرسمية للمؤسسة. هذا النظام يتيح:\n\n"
                . "• إدارة المخاطبات الرسمية الداخلية والخارجية\n"
                . "• أرشفة المستندات الصادرة والواردة\n"
                . "• إمكانية التصدير والطباعة\n"
                . "• إعداد التقارير الإدارية\n"
                . "• النسخ الاحتياطي للمستندات\n"
                . "• إدارة الكتب الرسمية ونسخها ضوئياً\n\n"
                . "أنا هنا لمساعدتك في استخدام هذا النظام والإجابة على استفساراتك.",

            'مميزات النظام' => "أهم مميزات النظام:\n\n"
                . "📌 إدارة المخاطبات الرسمية (صادر/وارد)\n"
                . "📊 إعداد التقارير الإحصائية\n"
                . "🗄️ أرشفة المستندات بشكل منظم\n"
                . "📧 إدارة البريد الإلكتروني\n"
                . "🔐 نظام صلاحيات متكامل\n"
                . "💾 نسخ احتياطي تلقائي",

            // وحدات النظام كما تظهر في القائمة الجانبية
            'المخاطبات' => "وحدة إدارة المخاطبات تتيح:\n\n"
                . "1. إدارة الكتب الصادرة والواردة\n"
                . "2. تتبع سير المعاملات\n"
                . "3. إعداد تقارير عن حركة المراسلات\n"
                . "للوصول: قائمة 'إدارة المخاطبات' → 'الصادر والوارد'",

            'التقارير' => "وحدة التقارير توفر:\n\n"
                . "• تقارير إحصائية عن حركة المراسلات\n"
                . "• تقارير عن أداء الأقسام\n"
                . "• إمكانية تصدير التقارير بصيغة PDF أو Excel\n"
                . "للوصول: قائمة 'إدارة المخاطبات' → 'التقارير'",

            'الاعدادات' => "إعدادات النظام تشمل:\n\n"
                . "⚙️ إدارة الأقسام والدوائر\n"
                . "📧 تكوين قوائم البريد الإلكتروني\n"
                . "🔍 إعدادات التتبع\n"
                . "💾 إدارة النسخ الاحتياطي\n"
                . "🛠️ إعدادات النظام العامة\n"
                . "للوصول: قائمة 'الاعدادات'",

            // إجراءات محددة
            'كيفية إرسال كتاب' => "لإرسال كتاب رسمي:\n\n"
                . "1. انتقل إلى 'إدارة المخاطبات' → 'الصادر والوارد'\n"
                . "2. اختر 'إرسال كتاب جديد'\n"
                . "3. املأ الحقول المطلوبة (الجهة المرسلة، الموضوع، المحتوى)\n"
                . "4. أرفق المستندات إذا لزم الأمر\n"
                . "5. اضغط على زر 'إرسال'",

            'كيفية أرشفة مستند' => "لأرشفة مستند:\n\n"
                . "1. انتقل إلى 'إدارة المخاطبات' → 'الصادر والوارد'\n"
                . "2. اختر المستند المطلوب\n"
                . "3. اضغط على خيار 'أرشفة'\n"
                . "4. حدد التصنيف المناسب\n"
                . "5. اضغط 'حفظ'",

            'إعداد تقرير' => "لإنشاء تقرير:\n\n"
                . "1. انتقل إلى 'إدارة المخاطبات' → 'التقارير'\n"
                . "2. اختر نوع التقرير المطلوب\n"
                . "3. حدد الفترة الزمنية\n"
                . "4. اضغط على 'إنشاء تقرير'\n"
                . "5. يمكنك تصدير التقرير أو طباعته",

            'النسخ الاحتياطي' => "لإدارة النسخ الاحتياطي:\n\n"
                . "1. انتقل إلى 'الاعدادات' → 'النسخ الاحتياطي'\n"
                . "2. اختر 'إنشاء نسخة احتياطية'\n"
                . "3. حدد البيانات المطلوب نسخها\n"
                . "4. اضغط على 'بدء النسخ'",

            'الدعم الفني' => "للاتصال بالدعم الفني:\n\n"
                . "📞 هاتف: 07719193554\n"
                . "✉️ إيميل: muntedher@gmail.com\n"
                . "🕒 ساعات العمل: من الأحد إلى الخميس، 8 صباحاً - 4 مساءً",

            'صلاحيات المستخدمين' => "نظام الصلاحيات يتيح:\n\n"
                . "• تقسيم المستخدمين إلى مجموعات (مسؤولين، مشرفين، مستخدمين عاديين)\n"
                . "• تحديد صلاحيات الوصول لكل مجموعة\n"
                . "• إدارة الأدوار والصلاحيات من قسم 'التصاريح والأدوار'",
        ];

        // التحقق من الأسئلة المخصصة
        $lowerMessage = mb_strtolower($message);
        foreach ($faqs as $question => $answer) {
            if (str_contains($lowerMessage, mb_strtolower($question))) {
                return $answer;
            }
        }

        $logFile = storage_path('app/debug_log.txt');
        file_put_contents($logFile, "\n" . date('Y-m-d H:i:s') . " - بدء طلب جديد إلى Gemini API\n", FILE_APPEND);

        try {
            $apiKey = 'AIzaSyCJS6-mdv5CC_mIly6sD7vcK5r7XOdFu2c';
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

            // إضافة وصف النظام إلى السياق
            $systemContext = "أنت مساعد ذكي في نظام إدارة المراسلات الرسمية لمؤسسة حكومية. "
                . "هذا النظام يتيح إدارة المخاطبات الرسمية، أرشفة المستندات، التصدير، الطباعة، "
                . "إعداد التقارير، النسخ الاحتياطي، وإدارة الكتب الرسمية. "
                . "أجب بطريقة رسمية ومهذبة باللغة العربية الفصحى.";

            $requestData = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemContext],
                            ['text' => $message]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1000,
                ]
            ];

            file_put_contents($logFile, date('Y-m-d H:i:s') . " - بيانات الطلب: " . json_encode($requestData, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);

            $response = Http::timeout(30) // زيادة وقت الانتظار إلى 30 ثانية
                ->retry(3, 500) // إعادة المحاولة 3 مرات مع تأخير 500 مللي ثانية
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $apiKey
                ])->post($url, $requestData);

            $responseBody = $response->json();
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - الاستجابة الكاملة: " . json_encode($responseBody, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);

            // استخراج النص من الاستجابة بناءً على الهيكل الذي رأيناه في الاختبار
            if (isset($responseBody['candidates'][0]['content']['parts'][0]['text'])) {
                return $responseBody['candidates'][0]['content']['parts'][0]['text'];
            } elseif (isset($responseBody['error']['message'])) {
                throw new \Exception($responseBody['error']['message']);
            } else {
                throw new \Exception('هيكل استجابة غير متوقع من Gemini API');
            }
        } catch (\Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - الخطأ: " . $e->getMessage() . "\n", FILE_APPEND);

            // رسائل خطأ مخصصة
            if (str_contains($e->getMessage(), 'overloaded')) {
                return "عذراً، الخدمة مشغولة حالياً. الرجاء المحاولة مرة أخرى خلال بضع دقائق.\n\n"
                    . "يمكنك في هذه الأثناء:\n"
                    . "• تصفح الأسئلة الشائعة\n"
                    . "• تجربة سؤال آخر\n"
                    . "• الاتصال بالدعم الفني إذا استمرت المشكلة";
            }

            return 'عذراً، حدث خطأ في خدمة المساعد الذكي. الرجاء المحاولة لاحقاً.';
        }
    }

    public function render()
    {
        return view('livewire.ai-assistant.ai-assistant');
    }
}
