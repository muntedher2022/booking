<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <title>{{ $bookData['subject'] }} - {{ $bookData['book_number'] }}</title>
</head>

<body style="font-family: Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        @if ($bookData['book_type'] === 'صادر')
            <p style="margin-bottom: 20px;">تحية طيبة،</p>

            <p style="margin-bottom: 20px;">نرافق لكم ربطاً صورة من الكتاب وتفاصيله كما يلي:</p>

            <div style="background-color: #f5f5f5; padding: 15px; margin: 15px 0; border-radius: 5px;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 8px;">رقم الكتاب: {{ $bookData['book_number'] }}</li>
                    <li style="margin-bottom: 8px;">تاريخ الكتاب: {{ $bookData['book_date'] }}</li>
                    <li style="margin-bottom: 8px;">الموضوع: {{ $bookData['subject'] }}</li>
                    <li style="margin-bottom: 8px;">نوع الكتاب: {{ $bookData['book_type'] }}</li>
                    <li style="margin-bottom: 8px;">درجة الأهمية: {{ $bookData['importance'] }}</li>
                </ul>
            </div>

            <p>نرجو تأكيد الاستلام.</p>
        @else
            <p style="margin-bottom: 20px;">تحية طيبة،</p>
            <p style="margin-bottom: 20px;">نؤيد استلام كتابكم</p>
        @endif

        <p style="margin-top: 20px;">مع التقدير،</p>
    </div>
</body>

</html>
