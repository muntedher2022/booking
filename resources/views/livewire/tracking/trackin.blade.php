<div class="mt-n4">
    @can('tracking-list')
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
            </div>
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

                                <td>{{ $i++ }}</td>
                                <td class="text-center">{{ $Trackin->Getuser ? $Trackin->Getuser->name : '' }}</td>
                                <td class="text-center">{{ $Trackin->page_name }}</td>

                                <td class="text-center" style="padding: 10px; border-radius: 5px; font-size: 14px;">
                                    @if ($Trackin->operation_type === 'اضافة')
                                        <i class="mdi mdi-shield-plus-outline" style="color: #28a745;"></i>
                                        <span style="color: #28a745;">{{ $Trackin->operation_type }}</span>
                                    @elseif($Trackin->operation_type === 'تعديل')
                                        <i class="mdi mdi-shield-refresh-outline" style="color: #007bff;"></i>
                                        <span style="color: #007bff;">{{ $Trackin->operation_type }}</span>
                                    @elseif($Trackin->operation_type === 'حذف')
                                        <i class="mdi mdi-shield-remove-outline" style="color: #dc3545;"></i>
                                        <span style="color: #dc3545;">{{ $Trackin->operation_type }}</span>
                                    @elseif($Trackin->operation_type === 'طباعة')
                                        <i class="mdi mdi-shield-crown-outline" style="color: #ffc107;"></i>
                                        <span style="color: #ffc107;">{{ $Trackin->operation_type }}</span>
                                    @endif
                                </td>

                                <td class="text-center">{{ $Trackin->operation_time }}</td>
                                <td class="text-center">{{ $Trackin->details }}</td>

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
