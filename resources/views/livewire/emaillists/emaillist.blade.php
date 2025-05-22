<div class="mt-n4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="mb-2">
                    <span class="text-muted fw-light">الاعدادات<span class="mdi mdi-chevron-left mdi-24px"></span></span>
                    البريد الالكتروني
                </h4>
                <div>
                    @can('emaillist-create')
                        <button wire:click='AddemaillistModalShow' class="mb-3 add-new btn btn-primary mb-md-0"
                            data-bs-toggle="modal" data-bs-target="#addemaillistModal">أضــافــة</button>
                        @include('livewire.emaillists.modals.add-emaillist')
                    @endcan
                </div>
            </div>
        </div>
        @can('emaillist-list')
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th> </th>
                            <th>ت</th>
                            <th class="text-center">القسم</th>
                            <th class="text-center">البريد الإلكتروني</th>
                            <th class="text-center">ملاحظات</th>
                            <th class="text-center">العملية</th>
                        </tr>
                        <tr>
                            <th> </th>
                            <th>#</th>
                            <th class="text-center">
                                <input type="text" wire:model.debounce.300ms="search.department"
                                    class="form-control text-center" placeholder="بحث بالقسم">
                            </th>
                            <th class="text-center">
                                <input type="text" wire:model.debounce.300ms="search.email"
                                    class="form-control text-center" placeholder="بحث بالبريد الإلكتروني">
                            </th>
                            <th class="text-center">
                                <input type="text" wire:model.debounce.300ms="search.notes"
                                    class="form-control text-center" placeholder="بحث بالملاحظات">
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = $links->perPage() * ($links->currentPage() - 1) + 1;
                        @endphp
                        @foreach ($Emaillists as $emaillist)
                            <tr>
                                <td>
                                    <input type="checkbox" value="{{ $emaillist->id }}">
                                </td>
                                <td>{{ $i++ }}</td>
                                <td class="text-center">
                                    @if($emaillist->type == 'section')
                                        {{ $emaillist->Getsection ? $emaillist->Getsection->section_name : '' }}
                                    @elseif($emaillist->type == 'department')
                                        {{ $emaillist->Getdepartment ? $emaillist->Getdepartment->department_name : '' }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $emaillist->email }}</td>
                                <td class="text-center">{{ $emaillist->notes }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        @can('emaillist-edit')
                                            <button wire:click="Getemaillist({{ $emaillist->id }})"
                                                class="p-0 px-1 btn btn-text-primary waves-effect" data-bs-toggle="modal"
                                                data-bs-target="#editemaillistModal">
                                                <i class="mdi mdi-text-box-edit-outline fs-3"></i>
                                            </button>
                                        @endcan

                                        @can('emaillist-delete')
                                            <strong style="margin: 0 10px;">|</strong>
                                            <button wire:click="Getemaillist({{ $emaillist->id }})"
                                                class="p-0 px-1 btn btn-text-danger waves-effect {{ $emaillist->active ? 'disabled' : '' }}"
                                                data-bs-toggle = "modal" data-bs-target="#removeemaillistModal">
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
            @include('livewire.emaillists.modals.edit-emaillist')
            @include('livewire.emaillists.modals.remove-emaillist')
            <!-- Modal -->
        @endcan
    </div>

    <script>
        function exportSelectedRows() {
            // جمع معرّفات الصفوف المحددة
            const selectedIds = [];
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                selectedIds.push(checkbox.value);
            });

            // إذا لم يتم تحديد أي صفوف
            if (selectedIds.length === 0) {
                alert('يرجى تحديد صفوف لتصديرها.');
                return;
            }

            // إرسال معرّفات الصفوف إلى الرابط
            window.location.href = "{{ url('/export-emails') }}?selected_ids=" + selectedIds.join(',');
        }
    </script>


</div>
