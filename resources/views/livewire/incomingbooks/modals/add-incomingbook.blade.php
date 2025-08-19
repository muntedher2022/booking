<div wire:ignore.self class="modal fade" id="addincomingbookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="mb-4 text-center mt-n4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-2">
                            <span class="text-primary">اضافة</span> كتاب جديد
                        </h3>
                        <p class="text-muted">
                            <i class="mdi mdi-file-document-outline me-1"></i>
                            قم بإدخال تفاصيل الكتاب في النموذج أدناه
                        </p>
                    </div>
                </div>
                <hr class="mt-n2">
                <div wire:loading.remove wire:target="store, GetIncomingbook">
                    <form id="addincomingbookModalForm" autocomplete="off">
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <input wire:model.defer='book_number' type="text"
                                                id="modalIncomingbookbook_number" placeholder="رقم الكتاب"
                                                class="form-control @error('book_number') is-invalid is-filled @enderror" />
                                            <label for="modalIncomingbookbook_number">رقم الكتاب</label>
                                        </div>
                                        @error('book_number')
                                            <small class='text-danger inputerror'> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <input wire:ignore wire:model.defer='book_date' type="text"
                                                id="addIncomingbookbook_date" placeholder="تاريخ الكتاب"
                                                class="form-control @error('book_date') is-invalid is-filled @enderror" />
                                            <label for="modalIncomingbookbook_date">تاريخ الكتاب</label>
                                        </div>
                                        @error('book_date')
                                            <small class='text-danger inputerror'> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <input wire:model.defer='subject' type="text"
                                                id="modalIncomingbooksubject" placeholder="موضوع الكتاب"
                                                class="form-control @error('subject') is-invalid is-filled @enderror" />
                                            <label for="modalIncomingbooksubject">موضوع الكتاب</label>
                                        </div>
                                        @error('subject')
                                            <small class='text-danger inputerror'> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <select wire:model="book_type" id="addIncomingbookbook_type"
                                                class="form-select @error('book_type') is-invalid is-filled @enderror">
                                                <option value="">اختر</option>
                                                <option value="صادر">صادر</option>
                                                <option value="وارد">وارد</option>
                                            </select>
                                            <label for="addIncomingbookbook_type">نوع الكتاب</label>
                                        </div>
                                        @error('book_type')
                                            <small class="text-danger inputerror">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <select wire:model.defer="sender_type" id="modalIncomingbooksender_type"
                                                class="form-select @error('sender_type') is-invalid is-filled @enderror">
                                                <option value="">اختر</option>
                                                <option value="داخلي">داخلي</option>
                                                <option value="خارجي">خارجي</option>
                                            </select>
                                            <label for="modalIncomingbooksender_type">نطاق الكتاب</label>
                                        </div>
                                        @error('sender_type')
                                            <small class="text-danger inputerror">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <button type="button" wire:model.defer="importance"
                                                id="addIncomingbookimportance"
                                                class="form-select text-start @error('importance') is-invalid is-filled @enderror"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $importance ?: 'اختر' }}
                                            </button>
                                            <ul class="dropdown-menu w-100" aria-labelledby="importanceDropdown">
                                                <li><a class="dropdown-item" wire:click="$set('importance', 'عادي')">
                                                        <i class="mdi mdi-circle-outline me-2"></i>عادي
                                                    </a></li>
                                                <li><a class="dropdown-item" wire:click="$set('importance', 'عاجل')">
                                                        <i class="mdi mdi-alert me-2 text-warning"></i>عاجل
                                                    </a></li>
                                                <li><a class="dropdown-item" wire:click="$set('importance', 'سري')">
                                                        <i class="mdi mdi-lock me-2 text-danger"></i>سري
                                                    </a></li>
                                                <li><a class="dropdown-item"
                                                        wire:click="$set('importance', 'سري للغاية')">
                                                        <i class="mdi mdi-lock-alert me-2 text-danger"></i>سري للغاية
                                                    </a></li>
                                            </ul>
                                            <label for="addIncomingbookimportance">درجة الأهمية</label>
                                        </div>
                                        @error('importance')
                                            <small class="text-danger inputerror">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-8">
                                        <div class="form-floating form-floating-outline">
                                            <select wire:model.defer='sender_id' id="addIncomingbooksender_id"
                                                class="form-select @error('sender_id') is-invalid is-filled @enderror"
                                                multiple wire:ignore>
                                                <option value=""></option>
                                                <optgroup label="الدوائر">
                                                    @foreach ($departments as $department)
                                                        <option value="dep_{{ $department->id }}">
                                                            {{ $department->department_name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="الأقسام">
                                                    @foreach ($sections as $section)
                                                        <option value="sec_{{ $section->id }}">
                                                            {{ $section->section_name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <label for="addIncomingbooksender_id">
                                                {{ $book_type ? ($book_type == 'صادر' ? 'الجهة الصادر اليها' : 'الجهة الوارد منها') : 'الجهة' }}
                                            </label>
                                        </div>
                                        @error('sender_id')
                                            <small class='text-danger inputerror'>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-4">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('Departments') }}"
                                                class="btn btn-primary position-relative"
                                                data-bs-custom-class="tooltip-white-grey" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-popper-placement="top"
                                                data-bs-title="في حالة عدم وجود الدائرة اضغط هنا لإضافتها"
                                                onclick="$('#addincomingbookModal').modal('hide')">
                                                <i class="mdi mdi-plus me-1"></i>دائرة
                                            </a>
                                            <a href="{{ route('Sections') }}"
                                                class="btn btn-primary position-relative"
                                                data-bs-custom-class="tooltip-white-grey" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-popper-placement="top"
                                                data-bs-title="في حالة عدم وجود القسم اضغط هنا لإضافته"
                                                onclick="$('#addincomingbookModal').modal('hide')">
                                                <i class="mdi mdi-plus me-1"></i>قسم
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <select wire:model.defer='related_book_id'
                                                id="addIncomingbookrelated_book_id"
                                                class="form-select @error('related_book_id') is-invalid is-filled @enderror">
                                                <option value=""></option>
                                                @foreach ($allIncomingbooks as $incomingbook)
                                                    <option value="{{ $incomingbook->id }}">
                                                        رقم الكتاب: {{ $incomingbook->book_number }} -
                                                        {{ $incomingbook->book_type }} -
                                                        {{ $incomingbook->sender_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="modalIncomingbookrelated_book_id">
                                                {{ $book_type ? ($book_type == 'صادر' ? 'رقم الكتاب المرتبط الصادر' : 'رقم الكتاب المرتبط الوارد') : 'رقم الكتاب المرتبط' }}
                                            </label>
                                        </div>
                                        @error('related_book_id')
                                            <small class='text-danger inputerror'>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline position-relative" wire:ignore>
                                            <input type="text" id="addIncomingbookkeywords" class="form-control"
                                                value="{{ old('keywords', $keywords ?? '') }}"
                                                placeholder="أدخل كلمات مفتاحية" autocomplete="off">
                                            <label for="modalIncomingbookkeywords">كلمات مفتاحية</label>
                                            <i class="mdi mdi-information-outline position-absolute top-50 end-0 translate-middle-y me-2"
                                                style="cursor: help;" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-custom-class="tooltip-white-grey"
                                                data-bs-title="اضغط Enter أو استخدم الفاصلة لإضافة كلمة مفتاحية (الحد الأقصى 6 كلمات)"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <input wire:model.defer='content' type="text"
                                                id="modalIncomingbookcontent" placeholder="جزء من المتن"
                                                class="form-control @error('content') is-invalid is-filled @enderror" />
                                            <label for="modalIncomingbookcontent">جزء من المتن</label>
                                        </div>
                                        @error('content')
                                            <small class='text-danger inputerror'> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                @can('incomingbook-Email')
                                    <div class="row">
                                        <div class="mb-3 col">
                                            <label class="switch switch-square">
                                                <input wire:model="needs_reply" type="checkbox" class="switch-input"
                                                    id="needs_reply">
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"></span>
                                                    <span class="switch-off"></span>
                                                </span>
                                                <span class="switch-label">الكتاب يحتاج لإجابة</span>
                                            </label>
                                        </div>
                                        <div class="mb-3 col">
                                            <div class="form-check">
                                                <input wire:model="sendEmail" class="form-check-input" type="checkbox"
                                                    id="sendEmailCheck">
                                                <label class="form-check-label" for="sendEmailCheck">
                                                    إرسال إشعار بالبريد الإلكتروني للجهات المحددة
                                                </label>
                                            </div>
                                            <div wire:loading wire:target="store" class="text-primary mb-2">
                                                جاري إرسال البريد الإلكتروني...
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>

                            <div class="col-4 text-center">
                                <div class="col mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <small for="attachment">
                                            {{ $book_type ? ($book_type == 'صادر' ? 'صورة الكتاب الصادر' : 'صورة الكتاب الوارد') : 'صورة الكتاب' }}
                                        </small>
                                        <div class="input-group">
                                            <input wire:model.defer='attachment' type="file" id="attachment"
                                                accept=".jpeg,.png,.jpg,.pdf"
                                                class="form-control @error('attachment') is-invalid is-filled @enderror" />
                                            @can('incomingbook-Scanner')
                                                <button type="button" class="btn btn-info"
                                                    onclick="initializeNaps2Scanner()">
                                                    <i class="mdi mdi-scanner"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                    @error('attachment')
                                        <small class='text-danger inputerror'> {{ $message }} </small>
                                    @enderror

                                    <!-- إضافة منطقة المعاينة مع تنسيقات محسّنة -->
                                    <div class="mt-3 preview-container" style="max-height: 150px; overflow: hidden;">
                                        <div id="dwtcontrolContainer"
                                            style="display: none; width: 100%; height: 200px;"></div>

                                        <div wire:loading wire:target='attachment' class="mt-3">
                                            <img src="{{ asset('assets/img/gif/Cube-Loading-Animated-3D.gif') }}"
                                                style="max-height: 150px; width: auto;" alt="Loading">
                                        </div>

                                        <div wire:loading.remove wire:target='attachment' class="mt-3">
                                            @if ($tempImageUrl)
                                                <div class="preview-wrapper"
                                                    style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                                                    @if ($attachment && strtolower($attachment->getClientOriginalExtension()) === 'pdf')
                                                        <embed src="{{ $tempImageUrl }}" type="application/pdf"
                                                            style="width: 100%; height: 200px; object-fit: contain;" />
                                                    @else
                                                        <img src="{{ $tempImageUrl }}" alt="Selected Image"
                                                            style="width: 100%; max-height: 200px; object-fit: contain;" />
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <small for="annotated_attachment">
                                            {{ $book_type ? ($book_type == 'صادر' ? 'نسخة مؤشر عليها للكتاب الصادر' : 'نسخة مؤشر عليها للكتاب الوارد') : 'نسخة مؤشر عليها للكتاب' }}
                                        </small>
                                        <div class="input-group">
                                            <input wire:model.defer='annotated_attachment' type="file"
                                                id="annotated_attachment" accept=".jpeg,.png,.jpg,.pdf"
                                                class="form-control @error('annotated_attachment') is-invalid is-filled @enderror" />
                                            @can('incomingbook-Scanner')
                                                <button type="button" class="btn btn-info"
                                                    onclick="initializeNaps2ScannerAnnotated()">
                                                    <i class="mdi mdi-scanner"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                    @error('annotated_attachment')
                                        <small class='text-danger inputerror'> {{ $message }} </small>
                                    @enderror

                                    <!-- إضافة منطقة المعاينة مع تنسيقات محسّنة -->
                                    <div class="mt-3 preview-container" style="max-height: 150px; overflow: hidden;">
                                        <div id="dwtcontrolContainerAnnotated"
                                            style="display: none; width: 100%; height: 200px;"></div>

                                        <div wire:loading wire:target='annotated_attachment' class="mt-3">
                                            <img src="{{ asset('assets/img/gif/Cube-Loading-Animated-3D.gif') }}"
                                                style="max-height: 150px; width: auto;" alt="Loading">
                                        </div>

                                        <div wire:loading.remove wire:target='annotated_attachment' class="mt-3">
                                            @if ($tempAnnotatedImageUrl)
                                                <div class="preview-wrapper"
                                                    style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                                                    @if ($annotated_attachment && strtolower($annotated_attachment->getClientOriginalExtension()) === 'pdf')
                                                        <embed src="{{ $tempAnnotatedImageUrl }}"
                                                            type="application/pdf"
                                                            style="width: 100%; height: 200px; object-fit: contain;" />
                                                    @else
                                                        <img src="{{ $tempAnnotatedImageUrl }}"
                                                            alt="Selected Annotated Image"
                                                            style="width: 100%; max-height: 200px; object-fit: contain;" />
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
