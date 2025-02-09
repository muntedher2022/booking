<!-- Remove Permission Modal -->
<div wire:ignore.self class="modal fade" id="removePermissionModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="p-3 modal-content p-md-5">
			<button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body p-md-0">
				<div class="mb-4 text-center">
					<h3 class="pb-1 mb-2"><span class="text-danger">حذف التصريح</span></h3>
					<p>حذف التصريح وفقا لمتطلباتك.</p>
				</div>
				<div class="alert alert-danger" role="alert">
					<h6 class="mb-2 alert-heading">تحذير</h6>
					<p class="mb-0">من خلال حذف التصريح ، قد تكسر وظائف تصاريح النظام. يرجى التأكد من أنك متأكد تمامًا قبل المتابعة.</p>
				</div>
				<form id="editPermissionForm" class="pt-2 row" onsubmit="return false">
					<div class="mb-3 col-sm-8">
						<label for="editPermissionName">اسم التصريح</label>
						<div class="text-danger">{{ $name }}</div>
						{{-- <div class="form-floating form-floating-outline">
							<input wire:model='name' type="text" id="editPermissionName" name="editPermissionName" class="form-control"
								placeholder="اسم التصريح" tabindex="-1" disabled/>
							<label for="editPermissionName">اسم التصريح</label>
						</div> --}}
					</div>
					<div class="mt-1 mb-3 col-sm-4">
						<button wire:click='destroy' type="submit" class="mt-1 btn btn-danger mt-sm-0">حذف التصريح</button>
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