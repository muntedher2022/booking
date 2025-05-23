<div class="mt-n4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="d-flex align-items-center gap-2">
                        <span class="text-muted d-flex align-items-center">
                            <i class="mdi mdi-cog-outline fs-4"></i>
                            <span class="ms-1">ادارة المخاطبات</span>
                        </span>
                        <i class="mdi mdi-chevron-left text-primary"></i>
                        <span class="fw-bold text-primary d-flex align-items-center">
                            <i class="mdi mdi-file-document-multiple-outline me-1 fs-4"></i>
                            <span class="ms-1">الصادر والوارد</span>
                        </span>
                    </h4>
                </div>
                <div>
                    @can('incomingbook-create')
                        <button wire:click='AddIncomingbookModalShow' class="mb-3 add-new btn btn-primary mb-md-0"
                            data-bs-toggle="modal" data-bs-target="#addincomingbookModal">أضــافــة</button>
                        @include('livewire.incomingbooks.modals.add-incomingbook')
                    @endcan
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="mb-3 col">
                    <input type="text" wire:model.debounce.300ms="search.book_number"
                        class="form-control text-center" placeholder="رقم الكتاب" wire:key="search_book_number">
                </div>
                <div class="mb-3 col">
                    <div class="input-group">
                        <input type="date" wire:model.debounce.300ms="search.book_date"
                            class="form-control text-center" placeholder="تاريخ الكتاب.." id="showIncomingbookbook_date"
                            wire:key="search_book_date">
                        <button class="btn btn-outline-secondary" type="button"
                            id="showIncomingbookbook_date-clear">مسح</button>
                    </div>
                </div>
                <div class="mb-3 col">
                    <input type="text" wire:model.debounce.300ms="search.subject" class="form-control text-center"
                        placeholder="ابحث بموضوع الكتاب.." wire:key="search_subject">
                </div>
                <div class="mb-3 col">
                    <input type="text" wire:model.debounce.300ms="search.content" class="form-control text-center"
                        placeholder="ابحث بالمتن.." wire:key="search_content">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <select wire:model.debounce.300ms="search.book_type" class="form-select text-center"
                        wire:key="search_book_type">
                        <option value="">نوع الكتاب</option>
                        <option value="صادر">صادر</option>
                        <option value="وارد">وارد</option>
                    </select>
                </div>
                <div class="mb-3 col">
                    <select wire:model.debounce.300ms="search.sender_type" class="form-select"
                        wire:key="search_sender_type">
                        <option value="">نطاق الكتاب</option>
                        <option value="داخلي">داخلي</option>
                        <option value="خارجي">خارجي</option>
                    </select>
                </div>
                <div class="mb-3 col">
                    <select wire:model.debounce.300ms="search.importance" class="form-select text-center"
                        wire:key="search_importance">
                        <option value="">درجة الاهمية</option>
                        <option value="عادي">عادي</option>
                        <option value="عاجل">عاجل</option>
                        <option value="سري">سري</option>
                        <option value="سري للغاية">سري للغاية</option>
                    </select>
                </div>
                <div class="mb-3 col">
                    <input type="text" wire:model.debounce.300ms="search.related_book_id"
                        class="form-control text-center" placeholder=" ابحث عن الرقم الكتاب المرتبط.."
                        wire:key="search_related_book_id">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <input type="text" wire:model.debounce.300ms="search.sender_id" class="form-control text-center"
                        placeholder=" ابحث عن الجهة المرسل اليها الكتاب.." wire:key="search_sender_id">
                </div>
            </div>
        </div>
        @can('incomingbook-list')
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th class="text-center">رقم الكتاب</th>
                            <th class="text-center">تاريخ الكتاب</th>
                            <th class="text-center">موضوع الكتاب</th>
                            <th class="text-center">جزء من المتن</th>
                            <th class="text-center">رقم الكتاب المرتبط</th>
                            <th class="text-center">نوع الكتاب</th>
                            <th class="text-center">نطاق الكتاب</th>
                            <th class="text-center">درجة الاهمية</th>
                            <th class="text-center">الجهة</th>
                            <th class="text-center">العملية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = $links->perPage() * ($links->currentPage() - 1) + 1;
                        @endphp
                        @foreach ($Incomingbooks as $Incomingbook)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="text-center">{{ $Incomingbook->book_number }}</td>
                                <td class="text-center text-nowrap">{{ $Incomingbook->book_date }}</td>
                                <td class="text-center">{{ $Incomingbook->subject }}</td>
                                <td class="text-center">{{ $Incomingbook->content }}</td>
                                <td class="text-center">
                                    @if($Incomingbook->related_book_id)
                                        <button wire:click="GetIncomingbook({{ $Incomingbook->related_book_id }})"
                                            class="p-0 px-1 btn btn-text-primary waves-effect"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editincomingbookModal">
                                            {{ $Incomingbook->relatedBook->book_number ?? $Incomingbook->related_book_id }}
                                        </button>
                                    @else
                                        لا يوجد
                                    @endif
                                </td>
                                <td class="text-center">{{ $Incomingbook->book_type }}</td>
                                <td class="text-center">{{ $Incomingbook->sender_type }}</td>
                                <td class="text-center">
                                    @switch($Incomingbook->importance)
                                        @case('عادي')
                                            <span><i class="mdi mdi-circle-outline me-2"></i>{{ $Incomingbook->importance }}</span>
                                            @break
                                        @case('عاجل')
                                            <span><i class="mdi mdi-alert me-2 text-warning"></i>{{ $Incomingbook->importance }}</span>
                                            @break
                                        @case('سري')
                                            <span><i class="mdi mdi-lock me-2 text-danger"></i>{{ $Incomingbook->importance }}</span>
                                            @break
                                        @case('سري للغاية')
                                            <span><i class="mdi mdi-lock-alert me-2 text-danger"></i>{{ $Incomingbook->importance }}</span>
                                            @break
                                        @default
                                            {{ $Incomingbook->importance }}
                                    @endswitch
                                </td>
                                <td class="text-center position-relative" style="max-width: 200px; min-width: 150px;">
                                    @php
                                        $departmentNames = $Incomingbook->Getdepartment()->pluck('department_name');
                                        $sectionNames = $Incomingbook->Getsection()->pluck('section_name');
                                        $badgeClasses = [
                                            'bg-label-primary',
                                            'bg-label-danger',
                                            'bg-label-warning',
                                            'bg-label-info',
                                            'bg-label-success',
                                        ];
                                    @endphp
                                    <ul class="list-unstyled m-0 d-flex flex-wrap gap-1 justify-content-center">
                                        @forelse ($departmentNames as $name)
                                            <li class="badge rounded-pill {{ $badgeClasses[$loop->index % count($badgeClasses)] }}"
                                                style="white-space: normal; margin-bottom: 3px;">
                                                <i class="mdi mdi-office-building-outline me-1"></i>{{ $name }}
                                            </li>
                                        @empty
                                        @endforelse

                                        @forelse ($sectionNames as $name)
                                            <li class="badge rounded-pill {{ $badgeClasses[($loop->index + count($departmentNames)) % count($badgeClasses)] }}"
                                                style="white-space: normal; margin-bottom: 3px;">
                                                <i class="mdi mdi-domain me-1"></i>{{ $name }}
                                            </li>
                                        @empty
                                        @endforelse

                                        @if($departmentNames->isEmpty() && $sectionNames->isEmpty())
                                            <li class="badge rounded-pill bg-label-danger">لم يتم اختيار أي جهة.</li>
                                        @endif
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        @can('incomingbook-edit')
                                            <button wire:click="GetIncomingbook({{ $Incomingbook->id }})"
                                                class="p-0 px-1 btn btn-text-primary waves-effect" data-bs-toggle="modal"
                                                data-bs-target="#editincomingbookModal">
                                                <i class="mdi mdi-text-box-edit-outline fs-3"></i>
                                            </button>
                                        @endcan
                                        @can('incomingbook-delete')
                                            <strong style="margin: 0 10px;">|</strong>
                                            <button
                                                @if($Incomingbook->related_book_id)
                                                    wire:click="$emit('showError')"
                                                @else
                                                    wire:click="GetIncomingbook({{ $Incomingbook->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#removeincomingbookModal"
                                                @endif
                                                class="p-0 px-1 btn btn-text-danger waves-effect {{ $Incomingbook->active ? 'disabled' : '' }}"
                                            >
                                                <i class="tf-icons mdi mdi-delete-outline fs-3"></i>
                                            </button>
                                        @endcan
                                        @can('incomingbook-print')
                                            <strong style="margin: 0 10px;">|</strong>
                                            <button
                                                onclick="printFile('{{ Storage::url('Incomingbooks/' . date('Y', strtotime($Incomingbook->book_date)) . '/' . $Incomingbook->book_number . '/' . $Incomingbook->attachment) }}')"
                                                class="p-0 px-1 btn btn-text-secondary waves-effect">
                                                <span class="mdi mdi-printer-outline fs-3"></span>
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
            @include('livewire.incomingbooks.modals.edit-incomingbook')
            @include('livewire.incomingbooks.modals.remove-incomingbook')
            <!-- Modal -->
        @endcan
    </div>
</div>
