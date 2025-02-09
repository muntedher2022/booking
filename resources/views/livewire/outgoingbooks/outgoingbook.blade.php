<div class="mt-n4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-2">
                        <span class="text-muted fw-light">الصادر والوارد<span
                                class="mdi mdi-chevron-left mdi-24px"></span></span>الصادرة
                    </h4>
                </div>
                <div>
                    @can('outgoingbook-create')
                        <button wire:click='AddOutgoingbookModalShow' class="mb-3 add-new btn btn-primary mb-md-0"
                            data-bs-toggle="modal" data-bs-target="#addoutgoingbookModal">أضــافــة</button>
                        @include('livewire.outgoingbooks.modals.add-outgoingbook')
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
                        <input type="text" wire:ignore wire:model.debounce.300ms="search.book_date" class="form-control text-center"
                            placeholder="تاريخ الكتاب.." id="showOutgoingbookbook_date" wire:key="search_book_date">
                        <button class="btn btn-outline-secondary" type="button" id="showOutgoingbookbook_date-clear">مسح</button>
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
                    <input type="text" wire:model.debounce.300ms="search.related_book_id"
                        class="form-control text-center" placeholder=" ابحث عن الرقم المرتبط.."
                        wire:key="search_related_book_id">
                </div>
                <div class="mb-3 col">
                    <select wire:model.debounce.300ms="search.recipient_type" class="form-select"
                        wire:key="search_recipient_type">
                        <option value="">اختر</option>
                        <option value="داخلي">داخلي</option>
                        <option value="خارجي">خارجي</option>
                    </select>
                </div> 
                <div class="mb-3 col">
                    <input type="text" wire:model.debounce.300ms="search.recipient_id"
                        class="form-control text-center" placeholder=" ابحث عن الجهة المرسل اليها الكتاب.." wire:key="search_recipient_id">
                </div>
            </div>
        </div>
        @can('outgoingbook-list')
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
                            <th class="text-center">الجهة</th>
                            <th class="text-center">العملية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = $links->perPage() * ($links->currentPage() - 1) + 1;
                        @endphp
                        @foreach ($Outgoingbooks as $Outgoingbook)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="text-center">{{ $Outgoingbook->book_number }}</td>
                                <td class="text-center text-nowrap">{{ $Outgoingbook->book_date }}</td>
                                <td class="text-center">{{ $Outgoingbook->subject }}</td>
                                <td class="text-center">{{ $Outgoingbook->content }}</td>
                                <td class="text-center">{{ $Outgoingbook->Getincomingbook->book_number ?? 'لا يوجد' }}</td>
                                <td class="text-center">{{ $Outgoingbook->recipient_type }}</td>
                                <td class="text-center">
                                    @php
                                        $departmentNames = $Outgoingbook->Getdepartment()->pluck('department_name');
                                        $badgeClasses = [
                                            'bg-label-primary',
                                            'bg-label-danger',
                                            'bg-label-warning',
                                            'bg-label-info',
                                            'bg-label-success',
                                        ];
                                    @endphp
                                    <ul>
                                        @forelse ($departmentNames as $name)
                                            <li class="badge rounded-pill {{ $badgeClasses[$loop->index % count($badgeClasses)] }} me-1">
                                                {{ $name }}
                                            </li>
                                        @empty
                                            <li class="badge rounded-pill bg-label-danger me-1">لم يتم اختيار أي جهة.</li>
                                        @endforelse
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        @can('outgoingbook-edit')
                                            <button wire:click="GetOutgoingbook({{ $Outgoingbook->id }})"
                                                class="p-0 px-1 btn btn-text-primary waves-effect" data-bs-toggle="modal"
                                                data-bs-target="#editoutgoingbookModal">
                                                <i class="mdi mdi-text-box-edit-outline fs-3"></i>
                                            </button>
                                        @endcan
                                        @can('outgoingbook-delete')
                                            <strong style="margin: 0 10px;">|</strong>
                                            <button wire:click="GetOutgoingbook({{ $Outgoingbook->id }})"
                                                class="p-0 px-1 btn btn-text-danger waves-effect {{ $Outgoingbook->active ? 'disabled' : '' }}"
                                                data-bs-toggle = "modal" data-bs-target="#removeoutgoingbookModal">
                                                <i class="tf-icons mdi mdi-delete-outline fs-3"></i>
                                            </button>
                                        @endcan
                                        @can('outgoingbook-print')
                                            <strong style="margin: 0 10px;">|</strong>
                                            <button
                                                onclick="printFile('{{ Storage::url('Outgoingbooks/' . date('Y', strtotime($Outgoingbook->book_date)) . '/' . $Outgoingbook->book_number . '/' . $Outgoingbook->attachment) }}')"
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
            @include('livewire.outgoingbooks.modals.edit-outgoingbook')
            @include('livewire.outgoingbooks.modals.remove-outgoingbook')
            <!-- Modal -->
        @endcan
    </div>
</div>
