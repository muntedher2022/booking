<div class="mt-n4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-2">
                        <span class="text-muted fw-light">الاعدادات<span
                                class="mdi mdi-chevron-left mdi-24px"></span></span>
                        الاقسام
                    </h4>
                </div>
                <div>
                    @can('section-create')
                        <button wire:click='AddsectionModalShow' class="mb-3 add-new btn btn-primary mb-md-0"
                            data-bs-toggle="modal" data-bs-target="#addsectionModal">أضــافــة</button>
                        @include('livewire.sections.modals.add-section')
                    @endcan
                </div>
            </div>
        </div>
        @can('section-list')
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th class="text-center">اسم القسم</th>
                            <th class="text-center">العملية</th>

                        </tr>
                        <tr>
                            <th></th>
                            <th class="text-center">
                                <input type="text" wire:model.debounce.300ms="search.section_name"
                                    class="form-control text-center" placeholder="القسم" wire:key="search_section_name">
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = $links->perPage() * ($links->currentPage() - 1) + 1;
                        @endphp
                        @foreach ($Sections as $section)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="text-center">{{ $section->section_name }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        @can('section-edit')
                                            <button wire:click="GetSection({{ $section->id }})"
                                                class="p-0 px-1 btn btn-text-primary waves-effect" data-bs-toggle="modal"
                                                data-bs-target="#editsectionModal">
                                                <i class="mdi mdi-text-box-edit-outline fs-3"></i>
                                            </button>
                                        @endcan
                                        @can('section-delete')
                                            <strong style="margin: 0 10px;">|</strong>
                                            <button wire:click="GetSection({{ $section->id }})"
                                                class="p-0 px-1 btn btn-text-danger waves-effect {{ $section->active ? 'disabled' : '' }}"
                                                data-bs-toggle = "modal" data-bs-target="#removesectionModal">
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
            @include('livewire.sections.modals.edit-section')
            @include('livewire.sections.modals.remove-section')
            <!-- Modal -->
        @endcan
    </div>
</div>
