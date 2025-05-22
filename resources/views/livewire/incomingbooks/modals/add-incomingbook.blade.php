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
                                <div Class="row">
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
                                <div Class="row">
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

                                <div Class="row">
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
                                            <select wire:model="sender_type" id="modalIncomingbooksender_type"
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
                                    <div class="mb-3 col" wire:key="select">
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
                                </div>

                                <div Class="row">
                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <select wire:model.defer='related_book_id'
                                                id="addIncomingbookrelated_book_id"
                                                class="form-select @error('related_book_id') is-invalid is-filled @enderror">
                                                <option value=""></option>
                                                @foreach ($incomingbooks as $incomingbook)
                                                    <option value="{{ $incomingbook->id }}">
                                                        رقم الكتاب: {{ $incomingbook->book_number }} - {{ $incomingbook->book_type }} - {{ $incomingbook->sender_type }}
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

                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <input wire:model.defer='keywords' type="text"
                                                id="modalIncomingbookkeywords" placeholder="كلمات مفتاحية"
                                                class="form-control @error('keywords') is-invalid is-filled @enderror" />
                                            <label for="modalIncomingbookkeywords">كلمات مفتاحية</label>
                                        </div>
                                        @error('keywords')
                                            <small class='text-danger inputerror'> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>
                                <div Class="row">
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
                            </div>

                            <div class="col-4 text-center">
                                <div class="col mb-3" style="height: 200px;">
                                    <div class="form-floating form-floating-outline">
                                        <input wire:model.defer='attachment' type="file" id="attachment"
                                            accept=".jpeg,.png,.jpg,.pdf"
                                            class="form-control @error('attachment') is-invalid is-filled @enderror" />
                                        <label for="addIncomingbooksender_id">
                                            {{ $book_type ? ($book_type == 'صادر' ? 'صورة الكتاب الصادر' : 'صورة الكتاب الوارد') : 'صورة الكتاب' }}
                                        </label>
                                    </div>
                                    @error('attachment')
                                        <small class='text-danger inputerror'> {{ $message }} </small>
                                    @enderror

                                    <div class="d-flex justify-content-center text-center">
                                        <div wire:loading wire:target='attachment' class="mt-3">
                                            <img src="{{ asset('assets/img/gif/Cube-Loading-Animated-3D.gif') }}"
                                                style="height: 150px" alt="">
                                        </div>
                                        <div wire:loading.remove wire:target='attachment' class="mt-3">
                                            @if ($attachment && $attachment->getMimeType() == 'application/pdf')
                                                <embed src="{{ $attachment->temporaryUrl() }}" type="application/pdf"
                                                    width="100%" height="200px" />
                                            @elseif ($attachment && Str::startsWith($attachment->getMimeType(), 'image/'))
                                                <img src="{{ $attachment->temporaryUrl() }}" alt="Selected Image"
                                                    class="img-fluid" width="100%" height="200px" />
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
