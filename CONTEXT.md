# 📋 وثيقة سياق المشروع (CONTEXT.md)

## 📌 نبذة عن المشروع
* **الاسم:** نظام الحجوزات والمساعد الذكي والكتب الواردة (Ports Booking & AI System).
* **الهدف:** جدولة المواعيد والحجوزات، أرشفة وتتبع مسار الكتب الواردة، ومساعد محادثة تفاعلي مدعوم بالذكاء الاصطناعي.

## ✅ ما تم إنجازه حتى الآن
* **إدارة وتتبع الكتب الواردة:** تسجيل الكتب الرسمية (Incoming Books)، تتبع مراحل إنجازها (Tracking)، وحفظ أرقامها وتواريخها.
* **الهيكل الإداري:** أرشفة بيانات الأقسام (Departments)، الشعب (Sections)، والقوائم البريدية (Emaillists).
* **المساعد الذكي (AI Assistant):** إدارة جلسات المحادثة الذكية (AiConversation) والرسائل التفاعلية (AiMessage).
* **إدارة الجلسات والأمان:** مراقبة المستخدمين المتصلين لحظياً (Online Sessions)، ونظام الصلاحيات والأدوار، والمصادقة المزدوجة (TOTP/OTP).
* **التقارير والنسخ الاحتياطي:** تصدير السجلات إلى تقارير PDF وإكسل، ونظام نسخ احتياطي للبيانات.

## 🛠️ التقنيات المستخدمة
* **Backend:** Laravel 10 (PHP 8.1+)
* **Frontend:** Blade, Materialize CSS/JS, Livewire 2
* **Database:** MySQL
* **Tools:** DomPDF, PhpSpreadsheet, Google API Client, Spatie Permission

## 📂 هيكل الملفات الأساسية
* `app/Models/`: (IncomingBooks, Tracking, Departments, Sections, AiConversation, AiMessage, OnlineSession, User).
* `app/Http/Controllers/`: وحدات التحكم (IncomingbooksController, TrackingController, DashboardController, ReportController, BackupController, إلخ).
* `resources/views/`: واجهات وقوالب العرض المبنية على Materialize وLivewire.
* `database/migrations/`: جداول الكتب الواردة، التتبع، محادثات الذكاء الاصطناعي، والصلاحيات.
