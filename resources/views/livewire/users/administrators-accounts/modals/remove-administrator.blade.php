<!-- Remove Administrator Modal -->
<div wire:ignore.self class="modal fade" id="RmoveAdministrator" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="p-3 modal-content p-md-5">
			<button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-md-0 mt-n4">
				<div class="mb-4 text-center">
					<h3 class="pb-1 mb-2 text-danger">حذف بيانات المشرف</h3>
					<p>خذف بيانات المستخدم بصفة مشرف .</p>
				</div>
                <hr class="text-danger mt-n2">

                <h5 wire:loading wire:target="GetAdministratorsAccount" wire:loading.class="d-flex justify-content-center text-danger">جار معالجة البيانات...</h5>

                <div wire:loading.remove>
                    <div class="alert alert-danger {{ $status ? '':'hidden' }} {{--alert-dismissible--}}" role="alert">
                        <h4 class="alert-heading d-flex align-items-center">
                            <i class="mdi mdi-alert-circle-outline mdi-24px me-2"></i>حساب المشرف!!
                        </h4>
                        <hr>
                        <p class="mb-0">
                            يجب ان يكون حساب المشرف غير مغعل لاتمام عملية الحذف.
                        </p>
                    </div>

				    <form id="removeAdministratorForm" class="pt-2 row" onsubmit="return false">
					    <div class="row">
                            <div class="mb-3 col-6">
                                <div class="text-danger">
                                    <label for="AdministratorName">أسم المشرف</label>
                                    <div class="form-control-plaintext mt-n2">{{ $name }}</div>
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <div class="text-danger">
                                    <label for="AdministratorEmail">البريد الالكتروني</label>
                                    <div class="form-control-plaintext mt-n2">{{ $email }}</div>
                                </div>
                            </div>
                        </div>

					    <div class="row">
                            <div class="mb-3 col-6">
                                <label for="AdministratorRole" class="text-danger mb-n5">الدور</label>
                                @if($AdministratorAccount)
                                    @foreach($AdministratorAccount->getRoleNames() as $RolesName)
                                        <div class="form-control-plaintext py-0">{{ $RolesName }}</div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mb-3 col-6">
                                <div class="text-danger">
                                    <label for="AdministratorPlan">خطة العمل</label>
                                    <div class="form-control-plaintext mt-n2">{{ $plan }}</div>
                                </div>
                                <div class="text-danger">
                                    <label for="AdministratorStatus">حالة المستخدم</label>
                                    <div class="form-control-plaintext mt-n2">{{ $status ? 'مفعل':'غير مفعل' }}</div>
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
