<!-- Edit Permission Modal -->
<div wire:ignore.self class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="p-3 modal-content p-md-5">
			<button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-md-0">
				<div class="mb-4 text-center">
					<h3 class="pb-1 mb-2">تحرير التصريح</h3>
					<p>تعديل التصريح وفقا لمتطلباتك.</p>
				</div>
				<div class="alert alert-warning" role="alert">
					<h6 class="mb-2 alert-heading">تحذير</h6>
					<p class="mb-0">من خلال تحرير اسم التصريح ، قد تكسر وظائف تصاريح النظام. يرجى التأكد من أنك متأكد تمامًا قبل المتابعة.</p>
				</div>
				<form id="editPermissionForm" class="pt-2 row" onsubmit="return false">
					{{-- <h6 wire:loading class="text-center">جار معالجة البيانات...</h6>
                    <div wire:loading.remove>
                        <div type="text" class="text-center form-control fw-bolder h6">{{ $name }}</div>
                    </div> --}}
					<div class="mb-3 col-sm-9">
						<div class="form-floating form-floating-outline">
							<input wire:model='name' type="text" id="editPermissionName" name="editPermissionName" class="form-control @if(strlen($name) > 0) is-filled @endif @error('name') is-invalid is-filled @enderror""
								placeholder="اسم التصريح" tabindex="-1" />
							<label for="editPermissionName">اسم التصريح</label>
						</div>
						@error('name')
                            <small class='text-danger inputerror'> {{ $message }} </small>
                        @enderror
					</div>
					<div class="mt-1 mb-3 col-sm-3">
						<button wire:click='update' type="submit" class="mt-1 btn btn-primary mt-sm-0">تعديل</button>
					</div>
					{{-- <div class="col-12">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="editCorePermission" />
							<label class="form-check-label" for="editCorePermission">
								Set as core permission
							</label>
						</div>
					</div> --}}
				</form>
			</div>
		</div>
	</div>
</div>
<!--/ Edit Permission Modal -->