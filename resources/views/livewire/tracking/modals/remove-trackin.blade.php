<!-- Remove Trackin Modal -->
<div wire:ignore.self class="modal fade" id="removetrackinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2">
                        <span class="text-danger">حذف</span> التتبع
                    </h3>
                    <p class="text-muted">
                        <i class="mdi mdi-delete-outline me-1"></i>
                        هل أنت متأكد من حذف هذا التتبع؟
                    </p>
                </div>
                <hr class="mt-n2">

                <div wire:loading.remove wire:target="GetTrackin, destroy">

                    <form id="removeTrackinModalForm" onsubmit="return false" autocomplete="off">
                        <div class="row">
                            <div class="col text-center">
                                <div class="text-danger">
                                    <label for="modalTrackinpage_name">اسم النافذة</label>
                                    <div class="form-control-plaintext mt-n2">{{ $page_name }}</div>
                                </div>
                            </div>
                            <div class="col text-center">
                                <div class="text-danger">
                                    <label for="modalTrackinoperation_type">نوع العملية</label>
                                    <div class="form-control-plaintext mt-n2">{{ $operation_type }}</div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="d-flex justify-content-center col-12 demo-vertical-spacing mb-n4">
                            <button wire:click='destroy' type="submit"class="flex-fill btn btn-danger me-sm-3 me-1">حذف
                            </button>
                            <button type="reset" class="flex-fill btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">تجاهل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Delete Trackin Modal -->
