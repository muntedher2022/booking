<div class="mt-n4">
    @can('tracking-view')
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="d-flex align-items-center gap-2">
                            <span class="text-muted d-flex align-items-center">
                                <i class="mdi mdi-eye-outline fs-4"></i>
                                <span class="ms-1">التتبع</span>
                            </span>
                            <i class="mdi mdi-chevron-left text-primary"></i>
                            <span class="fw-bold text-primary d-flex align-items-center">
                                <i class="mdi mdi-history me-1 fs-4"></i>
                                <span class="ms-1">سجل العمليات</span>
                            </span>
                        </h4>
                    </div>
                    {{-- <div>
                        @can('tracking-create')
                            <button wire:click='AddTrackinModalShow' class="mb-3 add-new btn btn-primary mb-md-0"
                                data-bs-toggle="modal" data-bs-target="#addtrackinModal">أضــافــة</button>
                            @include('livewire.tracking.modals.add-trackin')
                        @endcan
                    </div> --}}
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div>
                        <h5 class="d-flex align-items-center gap-2">
                            <span class="text-dark d-flex align-items-center">
                                <i class="mdi mdi-account-eye fs-3"></i>
                                <span class="ms-1">التتبع اليومي للمستخدمين</span>
                            </span>
                        </h5>
                    </div>
                    @livewire('tracking.tracking-users-operations-counter')
                </div>
                <div class="row g-4 mt-4">
                    <!-- Daily Card -->
                    <div class="col-6 col-md-3">
                        <div class="stats-card bg-white rounded-4 position-relative overflow-hidden border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="mdi mdi-calendar-today fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 text-end">
                                        <h2 class="mb-0 fw-bold text-dark">{{ $totalDaily }}</h2>
                                        <span class="text-muted small">عمليات اليوم</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="wave-bg" style="background: rgba(33, 150, 243, 0.1);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Monthly Card -->
                    <div class="col-6 col-md-3">
                        <div class="stats-card bg-white rounded-4 position-relative overflow-hidden border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="mdi mdi-calendar-month fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 text-end">
                                        <h2 class="mb-0 fw-bold text-dark">{{ $totalMonthly }}</h2>
                                        <span class="text-muted small">عمليات الشهر</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="wave-bg" style="background: rgba(76, 175, 80, 0.1);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Yearly Card -->
                    <div class="col-6 col-md-3">
                        <div class="stats-card bg-white rounded-4 position-relative overflow-hidden border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="mdi mdi-calendar-range fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 text-end">
                                        <h2 class="mb-0 fw-bold text-dark">{{ $totalYearly }}</h2>
                                        <span class="text-muted small">عمليات السنة</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="wave-bg" style="background: rgba(255, 193, 7, 0.1);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Card -->
                    <div class="col-6 col-md-3">
                        <div class="stats-card bg-white rounded-4 position-relative overflow-hidden border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="mdi mdi-counter fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 text-end">
                                        <h2 class="mb-0 fw-bold text-dark">{{ $totalAll }}</h2>
                                        <span class="text-muted small">الإجمالي الكلي</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="wave-bg" style="background: rgba(103, 58, 183, 0.1);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @can('tracking-list')
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th class="text-center">اسم الموظف</th>
                                <th class="text-center">اسم النافذة</th>
                                <th class="text-center">نوع العملية</th>
                                <th class="text-center">وقت العملية</th>
                                <th class="text-center">تفاصيل العملية</th>
                                {{-- <th class="text-center">العمليات</th> --}}
                            </tr>

                            <tr>
                                <th></th>
                                <th class="text-center">
                                    <input type="text" wire:model.debounce.300ms="search.user_id"
                                        class="form-control text-center" placeholder="اسم الموظف" wire:key="search_user_id">
                                </th>
                                <th class="text-center">
                                    <input type="text" wire:model.debounce.300ms="search.page_name"
                                        class="form-control text-center" placeholder="اسم النافذة" wire:key="search_page_name">
                                </th>
                                <th class="text-center">
                                    <select wire:model.debounce.300ms="search.operation_type"
                                        class="form-select text-center w-auto mx-auto" wire:key="search_operation_type">
                                        <option value="">نوع العملية</option>
                                        <option value="اضافة">اضافة</option>
                                        <option value="تعديل">تعديل</option>
                                        <option value="حذف">حذف</option>
                                        <option value="طباعة">طباعة</option>
                                        <option value="تصدير Excel">تصدير Excel</option>
                                    </select>
                                </th>
                                <th class="text-center">
                                    <div class="input-group">
                                        <input type="date" wire:model.debounce.300ms="search.operation_time"
                                            class="form-control text-center" placeholder="وقت العملية"
                                            wire:key="search_operation_time">
                                    </div>
                                </th>
                                <th class="text-center">
                                    <input type="text" wire:model.debounce.300ms="search.details"
                                        class="form-control text-center" placeholder="تفاصيل العملية" wire:key="search_details">
                                </th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = $links->perPage() * ($links->currentPage() - 1) + 1;
                            @endphp
                            @foreach ($Tracking as $Trackin)
                                <tr>

                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-center">{{ $Trackin->Getuser ? $Trackin->Getuser->name : '' }}</td>
                                    <td class="text-center">{{ $Trackin->page_name }}</td>

                                    <td class="text-center" style="padding: 10px; border-radius: 5px; font-size: 14px;">
                                        @if ($Trackin->operation_type === 'اضافة')
                                            <i class="mdi mdi-shield-plus-outline" style="color: #007bff;"></i>
                                            <span style="color: #007bff;">{{ $Trackin->operation_type }}</span>
                                        @elseif($Trackin->operation_type === 'تعديل')
                                            <i class="mdi mdi-shield-refresh-outline" style="color: #ffa500;"></i>
                                            <span style="color: #ffa500;">{{ $Trackin->operation_type }}</span>
                                        @elseif($Trackin->operation_type === 'حذف')
                                            <i class="mdi mdi-shield-remove-outline" style="color: #dc3545;"></i>
                                            <span style="color: #dc3545;">{{ $Trackin->operation_type }}</span>
                                        @elseif($Trackin->operation_type === 'طباعة')
                                            <i class="mdi mdi-shield-crown-outline" style="color: #9C27B0;"></i>
                                            <span style="color: #9C27B0;">{{ $Trackin->operation_type }}</span>
                                        @elseif($Trackin->operation_type === 'تصدير Excel')
                                            <i class="mdi mdi-file-excel-outline" style="color: #28a745;"></i>
                                            <span style="color: #28a745;">{{ $Trackin->operation_type }}</span>
                                        @elseif($Trackin->operation_type === 'إنشاء نسخة احتياطية')
                                            <i class="mdi mdi-backup-restore" style="color: #00bcd4;"></i>
                                            <span style="color: #00bcd4;">{{ $Trackin->operation_type }}</span>
                                        @elseif($Trackin->operation_type === 'تحميل نسخة احتياطية')
                                            <i class="mdi mdi-download-outline" style="color: #3f51b5;"></i>
                                            <span style="color: #3f51b5;">{{ $Trackin->operation_type }}</span>
                                        @elseif($Trackin->operation_type === 'حذف نسخة احتياطية')
                                            <i class="mdi mdi-delete-restore" style="color: #e91e63;"></i>
                                            <span style="color: #e91e63;">{{ $Trackin->operation_type }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">{{ $Trackin->operation_time }}</td>
                                    <td class="text-center">
                                        <div
                                            style="white-space: pre-line; max-width: 500px; margin: 0 auto; text-align: right; max-height: 150px; overflow-y: auto; padding: 10px; background-color: #f8f9fa; border-radius: 6px;">
                                            @php
                                                $details = $Trackin->details;
                                                $lines = explode("\n", $details);
                                                $color = match ($Trackin->operation_type) {
                                                    'اضافة' => '#007bff',
                                                    'تعديل' => '#ffa500',
                                                    'حذف' => '#dc3545',
                                                    'طباعة' => '#9C27B0',
                                                    'تصدير Excel' => '#28a745',
                                                    'إنشاء نسخة احتياطية' => '#00bcd4',
                                                    'تحميل نسخة احتياطية' => '#3f51b5',
                                                    'حذف نسخة احتياطية' => '#e91e63',
                                                    default => '#000000',
                                                };

                                                // تحسين عرض عناصر التصدير
                                                if ($Trackin->operation_type === 'تصدير Excel') {
                                                    echo '<div style="border-bottom: 1px solid #dee2e6; margin-bottom: 5px; padding-bottom: 5px;">';
                                                    foreach ($lines as $line) {
                                                        if (str_contains($line, '=======================')) {
                                                            echo '</div><div style="border-bottom: 1px solid #dee2e6; margin-bottom: 5px; padding-bottom: 5px;">';
                                                            continue;
                                                        }
                                                        $parts = explode(':', $line, 2);
                                                        if (count($parts) == 2) {
                                                            echo '<div style="margin-bottom: 3px;"><span style="color: ' .
                                                                $color .
                                                                '; font-weight: 600;">' .
                                                                $parts[0] .
                                                                ':</span>' .
                                                                $parts[1] .
                                                                '</div>';
                                                        } else {
                                                            echo '<div style="margin-bottom: 3px;">' . $line . '</div>';
                                                        }
                                                    }
                                                    echo '</div>';
                                                } else {
                                                    // عرض عادي لباقي العمليات
                                                    foreach ($lines as $line) {
                                                        $parts = explode(':', $line, 2);
                                                        if (count($parts) == 2) {
                                                            echo '<div style="margin-bottom: 3px;"><span style="color: ' .
                                                                $color .
                                                                '; font-weight: 600;">' .
                                                                $parts[0] .
                                                                ':</span>' .
                                                                $parts[1] .
                                                                '</div>';
                                                        } else {
                                                            echo '<div style="margin-bottom: 3px;">' . $line . '</div>';
                                                        }
                                                    }
                                                }
                                            @endphp
                                        </div>
                                    </td>

                                    {{-- <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="First group">
                                            @can('tracking-edit')
                                                <button wire:click="GetTrackin({{ $Trackin->id }})"
                                                    class="p-0 px-1 btn btn-text-primary waves-effect" data-bs-toggle="modal"
                                                    data-bs-target="#edittrackinModal">
                                                    <i class="mdi mdi-text-box-edit-outline fs-3"></i>
                                                </button>
                                            @endcan
                                            @can('tracking-delete')
                                                <strong style="margin: 0 10px;">|</strong>
                                                <button wire:click="GetTrackin({{ $Trackin->id }})"
                                                    class="p-0 px-1 btn btn-text-danger waves-effect {{ $Trackin->active ? 'disabled' : '' }}"
                                                    data-bs-toggle = "modal" data-bs-target="#removetrackinModal">
                                                    <i class="tf-icons mdi mdi-delete-outline fs-3"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $links->onEachSide(0)->links() }}
                    </div>
                </div>
                <!-- Modal -->
                {{-- @include('livewire.tracking.modals.edit-trackin')
                @include('livewire.tracking.modals.remove-trackin') --}}
                <!-- Modal -->
            @endcan
        </div>
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
<style>
    .stats-card {
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .icon-wrapper {
        transition: all 0.3s ease;
    }

    .stats-card:hover .icon-wrapper {
        transform: scale(1.1);
    }

    .wave-bg {
        height: 4px;
        width: 100%;
        border-radius: 2px;
        position: relative;
        overflow: hidden;
    }

    .wave-bg::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.7), transparent);
        animation: wave 1.5s linear infinite;
    }

    @keyframes wave {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }
</style>
