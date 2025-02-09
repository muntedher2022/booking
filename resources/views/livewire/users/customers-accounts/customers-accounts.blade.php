<div class="mt-n4">
    <div class="mb-4 row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="rounded avatar-initial bg-label-primary">
                                <div class="mdi mdi-account-outline mdi-24px"></div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">{{ $Users->count() }}</h5>
                            </div>
                            <small class="text-muted">العملاء</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="rounded avatar-initial bg-label-warning">
                                <div class="mdi mdi-poll mdi-24px"></div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">$28.5K</h5>
                            </div>
                            <small class="text-muted">اجمالي المدفوعات</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="rounded avatar-initial bg-label-info">
                                <div class="mdi mdi-trending-up mdi-24px"></div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">2,450K</h5>
                            </div>
                            <small class="text-muted">معاملة جديدة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="rounded avatar-initial bg-label-success">
                                <div class="mdi mdi-currency-usd mdi-24px"></div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">$48.2K</h5>
                            </div>
                            <small class="text-muted">إجمالي الإيرادات</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">العملاء</h5>
            <div>
               @can('customer-create')
                    <button wire:click='UsersAccountAdd' class="mb-3 add-new btn btn-primary mb-md-0"
                        data-bs-toggle="modal" data-bs-target="#addCustomerModal">اضافة مستخدم</button>

                        @include('livewire.users.customers-accounts.modals.add-customer')
                @endcan
            </div>
            {{-- <div class="gap-3 py-3 d-flex justify-content-between align-items-center row gap-md-0">
                <div class="col-md-4 user_role"></div>
                <div class="col-md-4 user_plan"></div>
                <div class="col-md-4 user_status"></div>
            </div> --}}
        </div>

        <div class="card-header mt-n4">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-2 g-2">
                <div class="col">
                    <input wire:model='SearchName' type="text" class="form-control" id="SearchName" placeholder="الأسم">
                </div>
                <div class="col">
                    <input wire:model='SearchEmail' type="text" class="form-control" id="SearchEmail" placeholder="البريد الالكتروني">
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <table class="{{-- datatables-users  --}}table border">
                <thead class="table-light">
                    <tr>
                        <th>الاسم / البريد الألكتروني</th>
                        <th>الدور</th>
                        <th>تاريخ التسجيل</th>
                        <th>حلة الحساب</th>
                        <th class="text-center">الاجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Users as $User)
                        <tr>
                            <td>
                                {{ $User->name }}
                                <div>
                                    <small>{{ $User->email }}</small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $roles_count = count($User->getRoleNames());
                                    $i = 0;
                                    $disease = '';
                                @endphp
                                @foreach($User->getRoleNames() as $roles)
                                    <?php $coma = ''; $i++; if($i < $roles_count) { $coma = ' , '; } ?>
                                    {{$roles .$coma }}
                                @endforeach<br>
                            </td>
                            <td>
                                {{ $User->created_at }}
                                <div dir="ltr">
                                    {{ Carbon\Carbon::parse($User->created_at)->diffForHumans() }}
                                </div>
                            </td>
                            <td>
                                @php $Status = 'text-dark'; @endphp
                                @if ($User->status)
                                    @php $Status = 'text-success'; @endphp
                                @else
                                    @php $Status = 'text-danger'; @endphp
                                @endif
                                <small class="{{ $Status }}">{{ $User->status ? 'مفعل':'غير مفعل' }}</small>

                                @if (Cache::has('user-online' . $User->id))
                                    <small class="text-success">متصل</small>
                                @else
                                    <small class="text-danger">غير متصل</small>
                                @endif
                                <div>
                                    @if ($User->last_seen != null)
                                        <span class="" dir="ltr">{{ Carbon\Carbon::parse($User->last_seen)->diffForHumans() }}</span>
                                    @else
                                        <small>لم يظهر ابداً</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                @if (Auth::User()->hasRole('OWNER') OR !in_array('OWNER', $User->getRoleNames()->toArray()) )
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button wire:click='GetUsersAccount({{ $User->id }})' type="button" class="p-0 px-1 btn btn-outline-primary waves-effect rounded-circle" data-bs-toggle="modal" data-bs-target="#ShowCustomerModal">
                                            <i class="tf-icons mdi mdi-account-eye-outline fs-3"></i>
                                        </button>
                                        <button wire:click='GetUsersAccount({{ $User->id }})' type="button" class="p-0 px-1 btn btn-outline-success waves-effect rounded-circle" data-bs-toggle="modal" data-bs-target="#EditCustomerModal">
                                            <i class="tf-icons mdi mdi-account-edit-outline fs-3"></i>
                                        </button>
                                        @if (Auth::User()->hasRole('OWNER') AND !in_array('OWNER', $User->getRoleNames()->toArray()))
                                            <button wire:click='GetUsersAccount({{ $User->id }})' type="button" class="p-0 px-1 btn btn-outline-danger waves-effect rounded-circle" data-bs-toggle="modal" data-bs-target="#RmoveCustomerModal">
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
        @include('livewire.users.customers-accounts.modals.show-customer')
        @include('livewire.users.customers-accounts.modals.edit-customer')
        @include('livewire.users.customers-accounts.modals.remove-customer')
        <!-- / Administrators Modal -->

    </div>
</div>
