<!-- Edit Incomingbook Modal -->
<div wire:ignore.self class="modal fade" id="editincomingbookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="mb-4 text-center mt-n4">
                    <h3 class="pb-1 mb-2">تعديل الكتاب الوارد</h3>
                    <p>نافذة التعديل</p>
                </div>
                <hr class="mt-n2">
                <div wire:loading.remove wire:target="update, GetIncomingbook">
                    <form id="editIncomingbookModalForm" autocomplete="off">
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
                                            <input wire:ignore wire:model.defer='book_date' type="date"
                                                id="editIncomingbookbook_date" placeholder="تاريخ الكتاب"
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

                                    <div class="mb-3 col">
                                        <div class="form-floating form-floating-outline">
                                            <select wire:model="sender_type" id="modalIncomingbooksender_type"
                                                class="form-select @error('sender_type') is-invalid is-filled @enderror">
                                                <option value="">اختر</option>
                                                <option value="داخلي">داخلي</option>
                                                <option value="خارجي">خارجي</option>
                                            </select>
                                            <label for="modalIncomingbooksender_type">نوع الكتاب</label>
                                        </div>
                                        @error('sender_type')
                                            <small class="text-danger inputerror">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col" wire:key="select">
                                        <div class="form-floating form-floating-outline">
                                            <select wire:model.defer="sender_id" id="editIncomingbooksender_id"
                                                class="form-select @error('sender_id') is-invalid is-filled @enderror"
                                                multiple wire:ignore>
                                                <option value=""></option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="editIncomingbooksender_id">الجهة المرسل منها</label>
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
                                                id="editIncomingbookrelated_book_id"
                                                class="form-select @error('related_book_id') is-invalid is-filled @enderror">
                                                <option value=""></option>
                                                @foreach ($outgoingbooks as $outgoingbook)
                                                    <option value="{{ $outgoingbook->id }}">
                                                        {{ $outgoingbook->book_number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="modalIncomingbookrelated_book_id">رقم الكتاب المرتبط</label>
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
                                <div class="col mb-3" style="height: 350px;">
                                    <div class="form-floating form-floating-outline">
                                        <input wire:model.defer='attachment' type="file" id="attachment"
                                            accept=".jpeg,.png,.jpg,.pdf"
                                            class="form-control @error('attachment') is-invalid is-filled @enderror" />
                                        <label for="attachment">صورة الكتاب الوارد</label>
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
                                            @if ($filePreview)
                                                @if ($attachment && $attachment->getClientOriginalExtension() == strtolower('pdf'))
                                                    <embed src="{{ $filePreview }}" type="application/pdf"
                                                        width="100%" height="300px" />
                                                @else
                                                    <img src="{{ $filePreview }}" alt="Selected Image"
                                                        class="img-fluid" width="100%" height="300px" />
                                                @endif
                                            @endif

                                            @if ($previewIncomingbookImage && empty($filePreview))
                                                @if (pathinfo($previewIncomingbookImage, PATHINFO_EXTENSION) == strtolower('pdf'))
                                                    <embed src="{{ $previewIncomingbookImage }}"
                                                        type="application/pdf" width="100%" height="300px" />
                                                @else
                                                    <img src="{{ $previewIncomingbookImage }}" alt="Selected Image"
                                                        class="img-fluid" width="100%" height="300px" />
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
<!--/ Edit Incomingbook Modal -->
