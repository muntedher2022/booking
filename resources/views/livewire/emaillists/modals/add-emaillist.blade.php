<!-- Add emaillist Modal -->
<div wire:ignore.self class="modal fade" id="addemaillistModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="mb-4 text-center mt-n4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-2">
                            <span class="text-primary">اضافة</span> بريد الكتروني جديد
                        </h3>
                        <p class="text-muted">
                            <i class="mdi mdi-email-outline me-1"></i>
                            قم بإدخال تفاصيل البريد الالكتروني في النموذج أدناه
                        </p>
                    </div>
                </div>
                <hr class="mt-n2">
                <form id="addemaillistModalForm" autocomplete="off">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="d-flex justify-content-center gap-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="type" id="sectionType" value="section">
                                    <label class="form-check-label" for="sectionType">
                                        <i class="mdi mdi-office-building-outline me-1"></i>قسم
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" wire:model="type" id="departmentType" value="department">
                                    <label class="form-check-label" for="departmentType">
                                        <i class="mdi mdi-domain me-1"></i>دائرة
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <div class="form-floating form-floating-outline">
                                <select wire:model.defer='department' id="addEmaillistdepartment"
                                    class="form-select @error('department') is-invalid is-filled @enderror">
                                    <option value=""></option>
                                    @if($type == 'section')
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                        @endforeach
                                    @elseif($type == 'department')
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="modalEmaillistdepartment">{{ $type == 'section' ? 'القسم' : 'الدائرة' }}</label>
                            </div>
                            @error('department')
                                <small class='text-danger inputerror'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <div class="form-floating form-floating-outline">
                                <input wire:model.defer='email' type="email" id="modalemaillistemail"
                                    placeholder="البريد الإلكتروني"
                                    class="form-control @error('email') is-invalid is-filled @enderror" />
                                <label for="modalemaillistemail">البريد الإلكتروني</label>
                            </div>
                            @error('email')
                                <small class='text-danger inputerror'> {{ $message }} </small>
                            @enderror
                        </div>

                        <div class="mb-3 col">
                            <div class="form-floating form-floating-outline">
                                <input wire:model.defer='notes' type="text" id="modalemaillistnotes"
                                    placeholder="ملاحظات"
                                    class="form-control @error('notes') is-invalid is-filled @enderror"
                                    onkeypress="return onlyArabicKey(event)" />
                                <label for="modalemaillistnotes">ملاحظات</label>
                            </div>
                            @error('notes')
                                <small class='text-danger inputerror'> {{ $message }} </small>
                            @enderror
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="text-center col-12 demo-vertical-spacing mb-n4">
                        <button wire:click='store' wire:loading.attr="disabled" type="button"
                            class="btn btn-primary me-sm-3 me-1">اضافة فئة</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">تجاهل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add emaillist Modal -->
