<!-- Edite Department Modal -->
<div wire:ignore.self class="modal fade" id="editdepartmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="mb-4 text-center mt-n4">
                    <h3 class="pb-1 mb-2">تعديل اسم الدائرة</h3>
                    <p>نافذة التعديل</p>
                </div>
                <hr class="mt-n2">
                <div wire:loading.remove wire:target="update, GetDepartment">
                    <form id="editDepartmentModalForm" autocomplete="off">
                        <div Class="row">
                            <div class="mb-3 col">
                                <div class="form-floating form-floating-outline">
                                    <input wire:model.defer='department_name' type="text"
                                        id="modalDepartmentdepartment_name" placeholder="اسم الدائرة"
                                        class="form-control @error('department_name') is-invalid is-filled @enderror"
                                        onkeypress="return onlyArabicKey(event)" />
                                    <label for="modalDepartmentdepartment_name">اسم الدائرة</label>
                                </div>
                                @error('department_name')
                                    <small class='text-danger inputerror'> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="text-center col-12 demo-vertical-spacing mb-n4">
                            <button wire:click='update' wire:loading.attr="disabled" type="button"
                                class="btn btn-primary me-sm-3 me-1">تعديل</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">تجاهل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Edite Department Modal -->
