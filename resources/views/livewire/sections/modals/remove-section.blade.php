<!-- Remove section Modal -->
<div wire:ignore.self class="modal fade" id="removesectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2">
                        <span class="text-danger">حذف</span> القسم
                    </h3>
                    <p class="text-muted">
                        <i class="mdi mdi-delete-outline me-1"></i>
                        هل أنت متأكد من حذف هذا القسم؟
                    </p>
                </div>
                <hr class="mt-n2">
                <div wire:loading.remove wire:target="destroy, GetSection">
                    <form id="removesectionModalForm" onsubmit="return false" autocomplete="off">
                        <div class="row">
                            <div class="col text-center">
                                <div class="text-danger">
                                    <label for="modalUnitunits_name">القسم</label>
                                    <div class="form-control-plaintext mt-n2">{{ $section_name }}</div>
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
<!--/ Delete section Modal -->
