<div class="mt-n4">
    <div class="mb-4 row g-4">
        <div class="col-sm-6 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="rounded avatar-initial bg-label-primary">
                                <div class="mdi mdi-shield-account mdi-24px"></div>
                            </div>
                        </div>

                        @if(!Auth::User()->hasRole('OWNER'))
                            @php
                                $Role = Spatie\Permission\Models\Role::whereNot('name', 'OWNER')->pluck('name');
                                $Administrators = App\Models\User::whereIn('plan', ['Supervisor', 'Employee'])->with('roles')->get()
                                    ->filter(fn ($user) => $user->roles->whereIn('name', $Role)->toArray());

                                /*$admins = App\Models\User::whereHas('roles', function ($q) {
                                    $adminRole = Spatie\Permission\Models\Role::whereNot('name', 'OWNER')->pluck('name');
                                    $q->whereIn('roles.name', $adminRole); // or whatever constraint you need here
                                })->get();*/
                            @endphp
                        @endif

                        <div class="ms-3">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ $Administrators->count() }}</h5>
                            </div>
                            <small class="text-muted">المشرفين</small>
                        </div>

                        <div class="ms-auto {{ Auth::User()->hasRole('OWNER') ? '':'hidden' }}">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ App\Models\User::whereIn('plan', ['Supervisor', 'Employee'])->with('roles')->get()->filter(fn ($user) => $user->roles->where('name', 'OWNER')->toArray())->count() }}</h5>
                            </div>
                            <small class="text-muted">OWNER</small>
                        </div>

                        <div class="ms-auto">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ count(App\Models\User::role('Administrator')->get()) }}</h5>
                            </div>
                            <small class="text-muted">Administrator</small>
                        </div>
                        <div class="ms-auto">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ count(App\Models\User::role('Supervisor')->get()->pluck('name')) }}</h5>
                            </div>
                            <small class="text-muted">Supervisor</small>
                        </div>
                        <div class="ms-auto">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ count(App\Models\User::role('Employee')->get()->pluck('name')) }}</h5>
                            </div>
                            <small class="text-muted">Employee</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="rounded avatar-initial bg-label-warning">
                                <div class="mdi mdi-account-lock mdi-24px"></div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ $Administrators->where('plan', 'Supervisor')->count() }}</h5>
                            </div>
                            <small class="text-muted">اSupervisor</small>
                        </div>

                        <div class="ms-auto">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ $Administrators->where('plan', 'Employee')->count() }}</h5>
                            </div>
                            <small class="text-muted">Employee</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Users List Table -->

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">مشرفي النظام</h5>
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
                <input wire:model='SearchName' type="text" class="form-control" id="SearchName" placeholder="أسم المشرف">
            </div>
            <div class="col">
                <input wire:model='SearchEmail' type="text" class="form-control" id="SearchEmail" placeholder="البريد الالكتروني">
            </div>
            <div class="col">
                <select class="form-select" id="SearchRole">
                    <option value="0" {{ 0 == $RoleSelect?"selected":'' }}>Any</option>
                    @foreach ($Roles as $Role)
                        <option value="{{ $Role->id }}" {{ $Role->id == $RoleSelect?"selected":'' }}>{{ $Role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select class="form-select" id="SearchStatus">
                    <option value="0" {{ 0 == $StatusSelect?"selected":'' }}>Any</option>
                    <option value="مفعل" {{ 'مفعل' == $StatusSelect?"selected":'' }}>مفعل </option>
                    <option value="غير مفعل" {{ 'غير مفعل' == $StatusSelect?"selected":'' }}>غير مفعل</option>
                    {{-- <option value="متصل" {{ 'متصل' == $StatusSelect?"selected":'' }}>متصل </option>
                    <option value="غير متصل" {{ 'غير متصل' == $StatusSelect?"selected":'' }}>غير متصل</option>
                    <option value="مفعل - متصل" {{ 'مفعل - متصل' == $StatusSelect?"selected":'' }}>مفعل - متصل</option>
                    <option value="مفعل - غير متصل" {{ 'مفعل - غير متصل' == $StatusSelect?"selected":'' }}>مفعل - غير متصل</option> --}}
                </select>
            </div>
        </div>



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
                                @foreach($Administrator->getRoleNames() as $roles)
                                    <?php $coma = ''; $i++; if($i < $roles_count) { $coma = ' , '; } ?>
                                    {{$roles .$coma }}
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
                                <small class="{{ $Status }}">{{ $Administrator->status ? 'مفعل':'غير مفعل' }}</small>

                                @if (Cache::has('user-online' . $Administrator->id))
                                    <small class="text-success">متصل</small>
                                @else
                                    <small class="text-danger">غير متصل</small>
                                @endif
                                <div>
                                    @if ($Administrator->last_seen != null)
                                        <span class="" dir="ltr">{{ Carbon\Carbon::parse($Administrator->last_seen)->diffForHumans() }}</span>
                                    @else
                                        <small>لم يظهر ابداً</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                @if (Auth::User()->hasRole('OWNER') OR !in_array('OWNER', $Administrator->getRoleNames()->toArray()) )
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button wire:click='GetAdministratorsAccount({{ $Administrator->id }})' type="button" class="p-0 px-1 btn btn-outline-primary waves-effect rounded-circle" data-bs-toggle="modal" data-bs-target="#ShowAdministrators">
                                            <i class="tf-icons mdi mdi-account-eye-outline fs-3"></i>
                                        </button>
                                        @if (Auth::User()->id == $Administrator->id OR !in_array('OWNER', $Administrator->getRoleNames()->toArray()))
                                            <button wire:click='GetAdministratorsAccount({{ $Administrator->id }})' type="button" class="p-0 px-1 btn btn-outline-success waves-effect rounded-circle" data-bs-toggle="modal" data-bs-target="#EditAdministrator">
                                                <i class="tf-icons mdi mdi-account-edit-outline fs-3"></i>
                                            </button>
                                        @endif
                                        @if (Auth::User()->hasRole('OWNER') AND !in_array('OWNER', $Administrator->getRoleNames()->toArray()))
                                            <button wire:click='GetAdministratorsAccount({{ $Administrator->id }})' type="button" class="p-0 px-1 btn btn-outline-danger waves-effect rounded-circle" data-bs-toggle="modal" data-bs-target="#RmoveAdministrator">
                                                <i class="tf-icons mdi mdi-account-remove-outline fs-3"></i>
                                            </button>
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

    </div>
</div>
