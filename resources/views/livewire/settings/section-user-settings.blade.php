<div class="mt-n4">
    @can('section-user-view')
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="d-flex align-items-center gap-2">
                            <span class="text-muted d-flex align-items-center">
                                <i class="mdi mdi-cog-outline fs-4"></i>
                                <span class="ms-1">الإعدادات</span>
                            </span>
                            <i class="mdi mdi-chevron-left text-primary"></i>
                            <span class="fw-bold text-primary d-flex align-items-center">
                                <i class="mdi mdi-account-cog-outline me-1 fs-4"></i>
                                <span class="ms-1">ربط المستخدمين بالأقسام</span>
                            </span>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- اختيار القسم --}}
                <div class="mb-4">
                    <label for="sectionSelect" class="form-label fw-semibold">اختر القسم:</label>
                    <select id="sectionSelect" wire:model="selectedSection" class="form-select">
                        <option value="">-- اختر القسم --</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- المستخدمون المرتبطون --}}
                @if ($selectedSection)
                    <div class="mb-4">
                        <label class="form-label fw-semibold">اختر المستخدمين المرتبطين:</label>
                        <div class="row">
                            @foreach ($users as $user)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <label class="switch switch-square d-flex align-items-center gap-2">
                                        <input type="checkbox" class="switch-input" id="user_{{ $user->id }}"
                                            value="{{ $user->id }}" wire:model="selectedUsers">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="icon-base ri ri-check-line"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="icon-base ri ri-close-line"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label">{{ $user->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- زر الحفظ --}}
                    <div class="text-end mt-4">
                        <button class="btn btn-primary rounded-pill px-4" wire:click="store" wire:loading.attr="disabled"
                            type="button">
                            <span wire:loading.remove>حفظ الربط</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                جاري التاشير...
                            </span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @else
        {{-- عرض رسالة عدم الصلاحية --}}
        <div class="container-xxl">
            <div class="misc-wrapper">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="mdi mdi-shield-lock-outline text-primary fs-1" style="opacity: 0.9;"></i>
                        </div>
                        <h2 class="mb-3 fw-semibold">عذراً! ليس لديك صلاحيات الوصول</h2>
                        <p class="mb-4 mx-auto text-muted" style="max-width: 500px;">
                            لا تملك الصلاحيات الكافية للوصول إلى هذه الصفحة. يرجى التواصل مع مدير النظام للحصول على
                            المساعدة.
                        </p>
                        <a href="{{ route('Dashboard') }}"
                            class="btn btn-primary btn-lg rounded-pill px-5 waves-effect waves-light">
                            <i class="mdi mdi-home-outline me-1"></i>
                            العودة إلى الرئيسية
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
