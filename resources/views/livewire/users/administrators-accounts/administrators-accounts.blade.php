<div class="mt-n4">
    @can('user-view')
        <div class="mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card bg-primary-subtle mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px">
                                            <i class="mdi mdi-shield-account mdi-24px text-white"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-0">{{ $Administrators->count() }}</h4>
                                        <small class="text-muted">إجمالي المشرفين</small>
                                    </div>
                                </div>
                                <div class="vr d-none d-sm-block" style="height: 40px"></div>
                                <div class="d-flex flex-wrap gap-3 ms-auto">
                                    @if (Auth::User()->hasRole('OWNER'))
                                        <div class="text-center">
                                            <h5 class="mb-1">
                                                {{ App\Models\User::whereIn('plan', ['Supervisor', 'Employee'])->with('roles')->get()->filter(fn($user) => $user->roles->where('name', 'OWNER')->toArray())->count() }}
                                            </h5>
                                            <span class="badge bg-primary">OWNER</span>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <h5 class="mb-1">{{ count(App\Models\User::role('Administrator')->get()) }}</h5>
                                        <span class="badge bg-info">Administrator</span>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="mb-1">
                                            {{ count(App\Models\User::role('Supervisor')->get()->pluck('name')) }}</h5>
                                        <span class="badge bg-warning">Supervisor</span>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="mb-1">
                                            {{ count(App\Models\User::role('Employee')->get()->pluck('name')) }}</h5>
                                        <span class="badge bg-success">Employee</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary-subtle mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar">
                                        <div class="rounded-circle bg-warning-subtle p-2">
                                            <i class="mdi mdi-account-lock mdi-24px text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="mb-1">{{ $Administrators->where('plan', 'Supervisor')->count() }}</h5>
                                        <span class="badge bg-warning">Supervisor</span>
                                    </div>
                                </div>
                                <div class="vr mx-3" style="height: 48px"></div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar">
                                        <div class="rounded-circle bg-success-subtle p-2">
                                            <i class="mdi mdi-account-tie mdi-24px text-success"></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="mb-1">{{ $Administrators->where('plan', 'Employee')->count() }}</h5>
                                        <span class="badge bg-success">Employee</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Users List Table -->

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="d-flex align-items-center gap-2">
                        <span class="text-muted d-flex align-items-center">
                            <i class="mdi mdi-cog-outline fs-4"></i>
                            <span class="ms-1">حسابات المشرفين</span>
                        </span>
                        <i class="mdi mdi-chevron-left text-primary"></i>
                        <span class="fw-bold text-primary d-flex align-items-center">
                            <i class="mdi mdi-shield-account me-1 fs-4"></i>
                            <span class="ms-1">مشرفي النظام</span>
                        </span>
                    </h4>
                </div>
                <div>
                    @can('user-create')
                        <button wire:click='AdministratorsAccountAdd' class="mb-3 add-new btn btn-primary mb-md-0"
                            data-bs-toggle="modal" data-bs-target="#addAdministratorModal">أضف مشرفاً</button>

                        @include('livewire.users.administrators-accounts.modals.add-administrator')
                    @endcan
                </div>
            </div>

            <div class="card-header d-flex align-items-center mt-n4">
                <div class="col">
                    <input wire:model='SearchName' type="text" class="form-control" id="SearchName"
                        placeholder="أسم المشرف">
                </div>
                <div class="col">
                    <input wire:model='SearchEmail' type="text" class="form-control" id="SearchEmail"
                        placeholder="البريد الالكتروني">
                </div>
                <div class="col">
                    <select class="form-select" id="SearchRole">
                        <option value="0" {{ 0 == $RoleSelect ? 'selected' : '' }}>Any</option>
                        @foreach ($Roles as $Role)
                            <option value="{{ $Role->id }}" {{ $Role->id == $RoleSelect ? 'selected' : '' }}>
                                {{ $Role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select class="form-select" id="SearchStatus">
                        <option value="0" {{ 0 == $StatusSelect ? 'selected' : '' }}>Any</option>
                        <option value="مفعل" {{ 'مفعل' == $StatusSelect ? 'selected' : '' }}>مفعل </option>
                        <option value="غير مفعل" {{ 'غير مفعل' == $StatusSelect ? 'selected' : '' }}>غير مفعل</option>
                        {{-- <option value="متصل" {{ 'متصل' == $StatusSelect?"selected":'' }}>متصل </option>
                    <option value="غير متصل" {{ 'غير متصل' == $StatusSelect?"selected":'' }}>غير متصل</option>
                    <option value="مفعل - متصل" {{ 'مفعل - متصل' == $StatusSelect?"selected":'' }}>مفعل - متصل</option>
                    <option value="مفعل - غير متصل" {{ 'مفعل - غير متصل' == $StatusSelect?"selected":'' }}>مفعل - غير متصل</option> --}}
                    </select>
                </div>
            </div>


            @can('user-list')
                <div class="card-datatable table-responsive">
                    <table class="{{-- datatables-users --}} table border">
                        <thead class="table-light">
                            <tr>
                                <th>الاسم</th>
                                <th>الدور / خطة العمل</th>
                                <th>تاريخ التسجيل</th>
                                <th>حلة الحساب</th>
                                <th class="text-center">الاجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Administrators as $Administrator)
                                <tr>
                                    <td>
                                        {{ $Administrator->name }}
                                        <div>
                                            <small>{{ $Administrator->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $roles_count = count($Administrator->getRoleNames());
                                            $i = 0;
                                            $disease = '';
                                        @endphp
                                        @foreach ($Administrator->getRoleNames() as $roles)
                                            <?php $coma = '';
                                            $i++;
                                            if ($i < $roles_count) {
                                                $coma = ' , ';
                                            } ?>
                                            {{ $roles . $coma }}
                                        @endforeach
                                        <div>{{ $Administrator->plan }}</div>
                                    </td>
                                    <td>
                                        {{ $Administrator->created_at }}
                                        <div dir="ltr">
                                            {{ Carbon\Carbon::parse($Administrator->created_at)->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td>
                                        @php $Status = 'text-dark'; @endphp
                                        @if ($Administrator->status)
                                            @php $Status = 'text-success'; @endphp
                                        @else
                                            @php $Status = 'text-danger'; @endphp
                                        @endif
                                        <small
                                            class="{{ $Status }}">{{ $Administrator->status ? 'مفعل' : 'غير مفعل' }}</small>

                                        @if (Cache::has('user-online' . $Administrator->id))
                                            <small class="text-success">متصل</small>
                                        @else
                                            <small class="text-danger">غير متصل</small>
                                        @endif
                                        <div>
                                            @if ($Administrator->last_seen != null)
                                                <span class=""
                                                    dir="ltr">{{ Carbon\Carbon::parse($Administrator->last_seen)->diffForHumans() }}</span>
                                            @else
                                                <small>لم يظهر ابداً</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if (Auth::User()->hasRole('OWNER') or !in_array('OWNER', $Administrator->getRoleNames()->toArray()))
                                            <div class="btn-group" role="group" aria-label="First group">
                                                @can('user-show')
                                                    <button wire:click='GetAdministratorsAccount({{ $Administrator->id }})'
                                                        type="button"
                                                        class="p-0 px-1 btn btn-outline-primary waves-effect rounded-circle"
                                                        data-bs-toggle="modal" data-bs-target="#ShowAdministrators">
                                                        <i class="tf-icons mdi mdi-account-eye-outline fs-3"></i>
                                                    </button>
                                                @endcan
                                                @if (Auth::User()->id == $Administrator->id or !in_array('OWNER', $Administrator->getRoleNames()->toArray()))
                                                    @can('user-edit')
                                                        <button wire:click='GetAdministratorsAccount({{ $Administrator->id }})'
                                                            type="button"
                                                            class="p-0 px-1 btn btn-outline-success waves-effect rounded-circle"
                                                            data-bs-toggle="modal" data-bs-target="#EditAdministrator">
                                                            <i class="tf-icons mdi mdi-account-edit-outline fs-3"></i>
                                                        </button>
                                                    @endcan
                                                @endif
                                                @if (Auth::User()->hasRole('OWNER') and !in_array('OWNER', $Administrator->getRoleNames()->toArray()))
                                                    @can('user-delete')
                                                        <button wire:click='GetAdministratorsAccount({{ $Administrator->id }})'
                                                            type="button"
                                                            class="p-0 px-1 btn btn-outline-danger waves-effect rounded-circle"
                                                            data-bs-toggle="modal" data-bs-target="#RmoveAdministrator">
                                                            <i class="tf-icons mdi mdi-account-remove-outline fs-3"></i>
                                                        </button>
                                                    @endcan
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-2 d-flex justify-content-center">
                    {{ $links->links() }}
                </div>

                <!-- Administrators Modal -->
                @include('livewire.users.administrators-accounts.modals.show-administrator')
                @include('livewire.users.administrators-accounts.modals.edit-administrator')
                @include('livewire.users.administrators-accounts.modals.remove-administrator')
                <!-- / Administrators Modal -->
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
