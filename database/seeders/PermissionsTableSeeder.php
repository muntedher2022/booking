<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database            // الأقسام
            [
                'name' => 'sections',
                'explain_name' => 'إدارة الأقسام',
                   // التتبع
            [
                'name' => 'trackings',
                'explain_name' => 'التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-view',
                'explain_name' => 'عرض صفحة التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-create',
                'explain_name' => 'إنشاء تتبع جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-list',
                'explain_name' => 'عرض قائمة التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-edit',
                'explain_name' => 'تعديل التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-delete',
                'explain_name' => 'حذف التتبع',
                'guard_name' => 'web'
            ],   'guard_name' => 'web'
            ],
            [
                'name' => 'section-view',
                'explain_name' => 'عرض صفحة الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-create',
                'explain_name' => 'إنشاء قسم جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-user-view',
                'explain_name' => 'عرض صفحة إعدادات مستخدمي الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-list',
                'explain_name' => 'عرض قائمة الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-edit',
                'explain_name' => 'تعديل الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-delete',
                'explain_name' => 'حذف الأقسام',
                'guard_name' => 'web'
            ],.
     */
    public function run(): void
    {
        $permissions = [
            // إدارة المستخدمين
            [
                'name' => 'users',
                'explain_name' => 'إدارة المستخدمين',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user-view',
                'explain_name' => 'عرض صفحة المستخدمين',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user-list',
                'explain_name' => 'عرض قائمة المستخدمين',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user-show',
                'explain_name' => 'عرض تفاصيل المستخدم',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user-create',
                'explain_name' => 'إضافة مستخدم جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user-edit',
                'explain_name' => 'تعديل بيانات المستخدم',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user-delete',
                'explain_name' => 'حذف مستخدم',
                'guard_name' => 'web'
            ],

            // إدارة الأدوار
            [
                'name' => 'roles',
                'explain_name' => 'إدارة الأدوار',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role-list',
                'explain_name' => 'عرض قائمة الأدوار',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role-create',
                'explain_name' => 'إضافة دور جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role-edit',
                'explain_name' => 'تعديل الدور',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role-delete',
                'explain_name' => 'حذف الدور',
                'guard_name' => 'web'
            ],

            // إدارة الصلاحيات
            [
                'name' => 'permissions',
                'explain_name' => 'إدارة الصلاحيات',
                'guard_name' => 'web'
            ],
            [
                'name' => 'permission-list',
                'explain_name' => 'عرض قائمة الصلاحيات',
                'guard_name' => 'web'
            ],
            [
                'name' => 'permission-create',
                'explain_name' => 'إضافة صلاحية جديدة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'permission-edit',
                'explain_name' => 'تعديل الصلاحية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'permission-delete',
                'explain_name' => 'حذف الصلاحية',
                'guard_name' => 'web'
            ],

            // المراسلات الواردة
            [
                'name' => 'incomingbooks',
                'explain_name' => 'المراسلات الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-view',
                'explain_name' => 'عرض صفحة المراسلات الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-create',
                'explain_name' => 'إنشاء مراسلة واردة جديدة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-list',
                'explain_name' => 'عرض قائمة المراسلات الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-edit',
                'explain_name' => 'تعديل المراسلات الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-delete',
                'explain_name' => 'حذف المراسلات الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-print',
                'explain_name' => 'طباعة المراسلات الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-Email',
                'explain_name' => 'إرسال المراسلات الواردة بالبريد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-Scanner',
                'explain_name' => 'مسح المراسلات الواردة ضوئياً',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incomingbook-export',
                'explain_name' => 'تصدير المراسلات الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incoming-book-list',
                'explain_name' => 'عرض قائمة الكتب الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incoming-book-create',
                'explain_name' => 'إضافة كتاب وارد جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incoming-book-edit',
                'explain_name' => 'تعديل الكتاب الوارد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'incoming-book-delete',
                'explain_name' => 'حذف الكتاب الوارد',
                'guard_name' => 'web'
            ],

            // إدارة التقارير
            // التقارير
            [
                'name' => 'reports',
                'explain_name' => 'التقارير',
                'guard_name' => 'web'
            ],
            [
                'name' => 'reports-view',
                'explain_name' => 'عرض صفحة التقارير',
                'guard_name' => 'web'
            ],
            [
                'name' => 'reports-create',
                'explain_name' => 'إنشاء تقرير جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'report-list',
                'explain_name' => 'عرض قائمة التقارير',
                'guard_name' => 'web'
            ],
            [
                'name' => 'report-create',
                'explain_name' => 'إنشاء تقرير جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'report-edit',
                'explain_name' => 'تعديل التقرير',
                'guard_name' => 'web'
            ],
            [
                'name' => 'report-delete',
                'explain_name' => 'حذف التقرير',
                'guard_name' => 'web'
            ],
            [
                'name' => 'report-export',
                'explain_name' => 'تصدير التقرير',
                'guard_name' => 'web'
            ],
            [
                'name' => 'report-print',
                'explain_name' => 'طباعة التقرير',
                'guard_name' => 'web'
            ],

            // إدارة الدوائر
            [
                'name' => 'departments',
                'explain_name' => 'إدارة الدوائر',
                'guard_name' => 'web'
            ],
            [
                'name' => 'department-list',
                'explain_name' => 'عرض قائمة الدوائر',
                'guard_name' => 'web'
            ],
            [
                'name' => 'department-create',
                'explain_name' => 'إضافة دائرة جديدة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'department-edit',
                'explain_name' => 'تعديل الدائرة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'department-delete',
                'explain_name' => 'حذف الدائرة',
                'guard_name' => 'web'
            ],

            // إدارة الأقسام
            [
                'name' => 'sections',
                'explain_name' => 'إدارة الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-list',
                'explain_name' => 'عرض قائمة الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-create',
                'explain_name' => 'إضافة قسم جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-edit',
                'explain_name' => 'تعديل القسم',
                'guard_name' => 'web'
            ],
            [
                'name' => 'section-delete',
                'explain_name' => 'حذف القسم',
                'guard_name' => 'web'
            ],

            // إدارة النسخ الاحتياطية
            [
                'name' => 'backups',
                'explain_name' => 'إدارة النسخ الاحتياطية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'backup-view',
                'explain_name' => 'عرض صفحة النسخ الاحتياطية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'backup-create',
                'explain_name' => 'إنشاء نسخة احتياطية جديدة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'backup-list',
                'explain_name' => 'عرض قائمة النسخ الاحتياطية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'backup-download',
                'explain_name' => 'تحميل النسخ الاحتياطية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'backup-delete',
                'explain_name' => 'حذف النسخ الاحتياطية',
                'guard_name' => 'web'
            ],


            // إدارة قائمة البريد الإلكتروني
            // القوائم البريدية
            [
                'name' => 'emaillists',
                'explain_name' => 'القوائم البريدية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'emaillist-view',
                'explain_name' => 'عرض صفحة القوائم البريدية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'emaillist-create',
                'explain_name' => 'إنشاء قائمة بريدية جديدة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'emaillist-list',
                'explain_name' => 'عرض قائمة القوائم البريدية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'emaillist-edit',
                'explain_name' => 'تعديل القوائم البريدية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'emaillist-delete',
                'explain_name' => 'حذف البريد الإلكتروني',
                'guard_name' => 'web'
            ],

            // لوحة التحكم والإحصائيات
            [
                'name' => 'dashboard',
                'explain_name' => 'الوصول للوحة التحكم والإحصائيات',
                'guard_name' => 'web'
            ],

            // سجل التتبع
            [
                'name' => 'tracking',
                'explain_name' => 'عرض سجل التتبع',
                'guard_name' => 'web'
            ],

            // الإعدادات
            [
                'name' => 'settings',
                'explain_name' => 'إدارة إعدادات النظام',
                'guard_name' => 'web'
            ],

            // إدارة العملاء
            [
                'name' => 'customer-view',
                'explain_name' => 'عرض تفاصيل العملاء',
                'guard_name' => 'web'
            ],
            [
                'name' => 'customer-list',
                'explain_name' => 'عرض قائمة العملاء',
                'guard_name' => 'web'
            ],
            [
                'name' => 'customer-create',
                'explain_name' => 'إضافة عميل جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'customer-edit',
                'explain_name' => 'تعديل بيانات العميل',
                'guard_name' => 'web'
            ],
            [
                'name' => 'customer-delete',
                'explain_name' => 'حذف العميل',
                'guard_name' => 'web'
            ],
            [
                'name' => 'customer-show',
                'explain_name' => 'عرض تفاصيل العميل',
                'guard_name' => 'web'
            ],

            // صلاحيات التتبع
            [
                'name' => 'tracking-view',
                'explain_name' => 'عرض تفاصيل التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-list',
                'explain_name' => 'عرض قائمة التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-create',
                'explain_name' => 'إضافة سجل تتبع جديد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-edit',
                'explain_name' => 'تعديل سجل التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'tracking-delete',
                'explain_name' => 'حذف سجل التتبع',
                'guard_name' => 'web'
            ],

            // صلاحيات لوحة التحكم
            [
                'name' => 'dashboard-view',
                'explain_name' => 'عرض لوحة التحكم',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Dashboards',
                'explain_name' => 'الوصول للوحة التحكم',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Correspondence Management',
                'explain_name' => 'إدارة المراسلات',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Incomingbooks',
                'explain_name' => 'إدارة الكتب الواردة',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Reports',
                'explain_name' => 'إدارة التقارير',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Settings',
                'explain_name' => 'الإعدادات',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Sections',
                'explain_name' => 'إدارة الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Departments',
                'explain_name' => 'إدارة الدوائر',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Emaillists',
                'explain_name' => 'إدارة قوائم البريد',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Trackings',
                'explain_name' => 'إدارة التتبع',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Backups',
                'explain_name' => 'إدارة النسخ الاحتياطية',
                'guard_name' => 'web'
            ],
            [
                'name' => 'SettingSectionUser',
                'explain_name' => 'إعدادات أقسام المستخدمين',
                'guard_name' => 'web'
            ],
            [
                'name' => 'AiAssistant',
                'explain_name' => 'المساعد الذكي',
                'guard_name' => 'web'
            ],
            [
                'name' => 'permissions-roles',
                'explain_name' => 'إدارة الصلاحيات والأدوار',
                'guard_name' => 'web'
            ]
        ];

        foreach ($permissions as $permission) {
            // التحقق من وجود الصلاحية قبل إنشائها
            Permission::updateOrCreate(
                [
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ],
                [
                    'explain_name' => $permission['explain_name']
                ]
            );
        }
    }
}
