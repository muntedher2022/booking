<!-- Remove Administrator Modal -->
<div wire:ignore.self class="modal fade" id="RmoveCustomerModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="p-3 modal-content p-md-5">
			<button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-md-0 mt-n4">
				<div class="text-center">
					<h3 class="pb-1 mb-2 text-danger">خذف حساب عميل</h3>
                    <p>خذف بيانات المستخدم بصفة عميل .</p>
				</div>
                <hr class="text-danger mt-n2">

                <h5 wire:loading wire:target="GetUsersAccount" wire:loading.class="d-flex justify-content-center text-danger">جار معالجة البيانات...</h5>

                <div wire:loading.remove wire:target="GetUsersAccount">
                    <div class="alert alert-danger {{ $status ? '':'hidden' }} {{--alert-dismissible--}}" role="alert">
                        <h4 class="alert-heading d-flex align-items-center">
                            <i class="mdi mdi-alert-circle-outline mdi-24px me-2"></i>حساب العميل!!
                        </h4>
                        <hr>
                        <p class="mb-0">
                            يجب ان يكون حساب العميل غير مغعل لاتمام عملية الحذف.
                        </p>
                    </div>

                    <form id="removeUserForm" class="pt-2 row" onsubmit="return false">
                        <div class="row">
                            <div class="mb-3 col-6">
                                <div class="form-floating form-floating-outline text-danger">
                                    <input wire:model='name' type="text" readonly="" class="form-control-plaintext" id="UserName">
                                    <label for="UserName">أسم المستخدم</label>
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <div class="form-floating form-floating-outline text-danger">
                                    <input  wire:model='email' type="text" readonly="" class="form-control-plaintext" id="UserEmail">
                                    <label for="UserEmail">البريد الالكتروني</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-6">
                                <div class="form-floating form-floating-outline text-danger">
                                    <input  wire:model='UserRolesName' type="text" readonly="" class="form-control-plaintext" id="UserRolesName">
                                    <label for="UserRolesName">الدور</label>
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <div class="form-floating form-floating-outline text-danger">
                                    <input  wire:model='plan' type="text" readonly="" class="form-control-plaintext" id="UserPlan">
                                    <label for="UserPlan">خطة العمل</label>
                                </div>
                                <div class="form-floating form-floating-outline text-danger mt-3">
                                    <input value="{{ $status ? 'مفعل':'غير مفعل' }}" type="text" readonly="" class="form-control-plaintext" id="UserStatus">
                                    <label for="UserStatus">حالة المستخدم</label>
                                </div>
                            </div>
                        </div>

                        <hr class="text-danger mt-n2">

                        <div class="text-center col-12 mb-n4">
                            <button wire:click='destroy' {{ $status ? 'disabled':'' }} type="submit" class="btn btn-danger me-sm-3 me-1">حذف</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">تجاهل</button>
                        </div>
                    </form>
			    </div>
			</div>
		</div>
	</div>
</div>
<!--/ Remove Administrator Modal -->
