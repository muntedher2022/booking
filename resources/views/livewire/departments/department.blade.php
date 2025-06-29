<div class="mt-n4">
    @can('department-view')
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="d-flex align-items-center gap-2">
                            <span class="text-muted d-flex align-items-center">
                                <i class="mdi mdi-cog-outline fs-4"></i>
                                <span class="ms-1">الاعدادات</span>
                            </span>
                            <i class="mdi mdi-chevron-left text-primary"></i>
                            <span class="fw-bold text-primary d-flex align-items-center">
                                <i class="mdi mdi-office-building-outline me-1"></i>
                                <span class="ms-1">الدوائر</span>
                            </span>
                        </h4>
                    </div>
                    <div>
                        @can('department-create')
                            <button wire:click='AddDepartmentModalShow' class="mb-3 add-new btn btn-primary mb-md-0"
                                data-bs-toggle="modal" data-bs-target="#adddepartmentModal">أضــافــة</button>
                            @include('livewire.departments.modals.add-department')
                        @endcan
                    </div>
                </div>
            </div>
            @can('department-list')
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th class="text-center">اسم الدائرة</th>
                                <th class="text-center">العملية</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="text-center">
                                    <input type="text" wire:model.debounce.300ms="search.department_name"
                                        class="form-control text-center" placeholder="الدائرة"
                                        wire:key="search_department_name">
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = $links->perPage() * ($links->currentPage() - 1) + 1;
                            @endphp
                            @foreach ($Departments as $Department)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="text-center">{{ $Department->department_name }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="First group">
                                            @can('department-edit')
                                                <button wire:click="GetDepartment({{ $Department->id }})"
                                                    class="p-0 px-1 btn btn-text-primary waves-effect" data-bs-toggle="modal"
                                                    data-bs-target="#editdepartmentModal">
                                                    <i class="mdi mdi-text-box-edit-outline fs-3"></i>
                                                </button>
                                            @endcan
                                            @can('department-delete')
                                                <strong style="margin: 0 10px;">|</strong>
                                                <button wire:click="GetDepartment({{ $Department->id }})"
                                                    class="p-0 px-1 btn btn-text-danger waves-effect {{ $Department->active ? 'disabled' : '' }}"
                                                    data-bs-toggle = "modal" data-bs-target="#removedepartmentModal">
                                                    <i class="tf-icons mdi mdi-delete-outline fs-3"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $links->onEachSide(0)->links() }}
                    </div>
                </div>
                <!-- Modal -->
                @include('livewire.departments.modals.edit-department')
                @include('livewire.departments.modals.remove-department')
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
