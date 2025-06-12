<div class="mt-n4">
    @can('backup-view')
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="d-flex align-items-center gap-2">
                            <span class="text-muted d-flex align-items-center">
                                <i class="mdi mdi-cog-outline fs-4"></i>
                                <span class="ms-1">إدارة النظام</span>
                            </span>
                            <i class="mdi mdi-chevron-left text-primary"></i>
                            <span class="fw-bold text-primary d-flex align-items-center">
                                <i class="mdi mdi-backup-restore me-1 fs-4"></i>
                                <span class="ms-1">النسخ الاحتياطي</span>
                            </span>
                        </h4>
                    </div>
                    @can('backup-create')
                        <div class="d-flex">
                            <select wire:model="backup_type" class="form-select mx-2" style="width: 200px;">
                                <option value="full">نسخة كاملة</option>
                                <option value="database">قاعدة البيانات فقط</option>
                                <option value="files">الملفات فقط</option>
                            </select>
                            <button class="btn btn-primary" wire:click="createBackup" wire:loading.attr="disabled">
                                <span wire:loading wire:target="createBackup" class="spinner-border spinner-border-sm me-1"
                                    role="status"></span>
                                <span wire:loading.remove wire:target="createBackup">إنشاء نسخة احتياطية</span>
                                <span wire:loading wire:target="createBackup">جاري إنشاء النسخة...</span>
                            </button>
                        </div>
                    @endcan
                </div>
            </div>
            @can('backup-list')
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th class="text-center">اسم الملف</th>
                                <th class="text-center">النوع</th>
                                <th class="text-center">الحجم</th>
                                <th class="text-center">تاريخ الإنشاء</th>
                                <th class="text-center">المستخدم</th>
                                <th class="text-center">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($backups as $backup)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $backup->filename }}</td>
                                    <td class="text-center" style="padding: 10px; border-radius: 5px; font-size: 14px;">
                                        @switch($backup->type)
                                            @case('database')
                                                <i class="mdi mdi-database-outline" style="color: #007bff;"></i>
                                                <span style="color: #007bff;">قاعدة البيانات</span>
                                            @break

                                            @case('files')
                                                <i class="mdi mdi-folder-outline" style="color: #ffa500;"></i>
                                                <span style="color: #ffa500;">ملفات</span>
                                            @break

                                            @default
                                                <i class="mdi mdi-backup-restore" style="color: #28a745;"></i>
                                                <span style="color: #28a745;">نسخة كاملة</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">{{ $backup->size }}</td>
                                    <td class="text-center">{{ $backup->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="text-center">{{ $backup->user->name }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @can('backup-download')
                                                <button class="btn btn-text-info waves-effect p-0 px-1"
                                                    wire:click="download('{{ $backup->filename }}')" title="تحميل">
                                                    <i class="tf-icons mdi mdi-download-outline fs-3"></i>
                                                </button>
                                            @endcan
                                            @can('backup-delete')
                                                <strong style="margin: 0 10px;">|</strong>
                                                <button class="btn btn-text-danger waves-effect p-0 px-1"
                                                    wire:click="delete({{ $backup->id }})" title="حذف">
                                                    <i class="tf-icons mdi mdi-delete-outline fs-3"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد نسخ احتياطية</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2 d-flex justify-content-center">
                            {{ $backups->links() }}
                        </div>
                    </div>
                </div>
            @endcan
        @else
            <div class="container-xxl">
                <div class="misc-wrapper">
                    <div class="card shadow-lg border-0">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="mdi mdi-shield-lock-outline text-primary fs-1" style="opacity: 0.9;"></i>
                            </div>
                            <h2 class="mb-3 fw-semibold">عذراً! ليس لديك صلاحيات الوصول</h2>
                            <p class="mb-4 mx-auto text-muted" style="max-width: 500px;">
                                لا تملك الصلاحيات الكافية للوصول إلى هذه الصفحة. يرجى التواصل مع مدير النظام للحصول على
                                المساعدة.
                            </p>
                            <a href="{{ route('Dashboard') }}"
                                class="btn btn-primary btn-lg rounded-pill px-5 waves-effect waves-light">
                                <i class="mdi mdi-home-outline me-1"></i>
                                العودة إلى الرئيسية
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
