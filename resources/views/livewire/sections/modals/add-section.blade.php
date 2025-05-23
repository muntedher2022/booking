<!-- Add section Modal -->
<div wire:ignore.self class="modal fade" id="addsectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="mb-4 text-center mt-n4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-2">
                            <span class="text-primary">اضافة</span> قسم جديد
                        </h3>
                        <p class="text-muted">
                            <i class="mdi mdi-office-building-outline me-1"></i>
                            قم بإدخال تفاصيل القسم في النموذج أدناه
                        </p>
                    </div>
                </div>
                <hr class="mt-n2">
                <div wire:loading.remove wire:target="store, GetSection">
                    <form id="addsectionModalForm" autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col">
                                <div class="form-floating form-floating-outline">
                                    <input wire:model.defer='section_name' type="text" id="modalsectionsection_name"
                                        placeholder="اسم القسم"
                                        class="form-control @error('section_name') is-invalid is-filled @enderror"
                                        onkeypress="return onlyArabicKey(event)"/>
                                    <label for="modalsectionsection_name">اسم القسم</label>
                                </div>
                                @error('section_name')
                                    <small class='text-danger inputerror'> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="text-center col-12 demo-vertical-spacing mb-n4">
                            <button wire:click='store' wire:loading.attr="disabled" type="button"
                                class="btn btn-primary me-sm-3 me-1">اضافة</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">تجاهل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Add section Modal -->
