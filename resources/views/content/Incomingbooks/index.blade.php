@extends('layouts/layoutMaster')
@section('title', 'Incomingbooks')
@section('vendor-style')
    <link rel="stylesheet"href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel = "stylesheet"href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel=" stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel=" stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel=" stylesheet" href=" {{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel=" stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel=" stylesheet" href=" {{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel=" stylesheet" href=" {{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel=" stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />


    <link rel="stylesheet" href="{{ asset('Resources/src/dynamsoft.webtwain.css') }}">
    <link rel="stylesheet" href="{{ asset('Resources/src/dynamsoft.webtwain.viewer.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">

@endsection
@section('content')
    @livewire('incomingbooks.incomingbook')
@endsection

@section('vendor-script')
    <script src=" {{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
    <script src=" {{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>


    <script src="{{ asset('Resources/dynamsoft.webtwain.js') }}"></script>
    <script src="{{ asset('Resources/dynamsoft.webtwain.install.js') }}"></script>
    <script src="{{ asset('Resources/dynamsoft.webtwain.initiate.js') }}"></script>
    <script src="{{ asset('Resources/dynamsoft.webtwain.config.js') }}"></script>
    <script src="{{ asset('Resources/src/dynamsoft.webtwain.viewer.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
@endsection

@section('page-script')
    <script src=" {{ asset('assets/js/app-user-list.js') }}"></script>
    <script src=" {{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src=" {{ asset('assets/js/form-basic-inputs.js') }}"></script>
    <script>
        // استبدال دالة printFile الحالية بهذه
        function printFile(fileUrl) {
            const fileExtension = fileUrl.split('.').pop().toLowerCase();
            const isPDF = fileExtension === 'pdf';

            if (isPDF) {
                printJS({
                    printable: fileUrl,
                    type: 'pdf',
                    onError: function(error) {
                        Toast.fire({
                            icon: 'error',
                            title: 'خطأ في طباعة الملف',
                            text: error.message
                        });
                    }
                });
            } else {
                printImage(fileUrl);
            }
        }

        // إضافة مستمع الحدث للطباعة
        window.addEventListener('print-file', event => {
            printFile(event.detail.url);
        });

        async function printImage(fileUrl) {
            try {
                await new Promise((resolve, reject) => {
                    // إنشاء عنصر صورة مؤقت
                    const img = new Image();
                    img.src = fileUrl;

                    img.onload = () => {
                        // إنشاء نافذة طباعة مؤقتة
                        const printWindow = window.open('', '_blank');
                        printWindow.document.write(`
                    <html>
                        <head>
                            <title>طباعة</title>
                            <style>
                                body {
                                    margin: 0;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    height: 100vh;
                                }
                                img {
                                    max-width: 100%;
                                    max-height: 100%;
                                    width: auto;
                                    height: auto;
                                }
                                @media print {
                                    @page {
                                        size: A4;
                                        margin: 0;
                                    }
                                    img {
                                        width: 100%;
                                        height: auto;
                                    }
                                }
                            </style>
                        </head>
                        <body>
                            <img src="${fileUrl}" alt="صورة للطباعة">
                        </body>
                    </html>
                `);
                        printWindow.document.close();

                        // استدعاء الطباعة بعد تحميل النافذة
                        printWindow.onload = () => {
                            printWindow.print();
                            printWindow.close();
                            resolve();
                        };
                    };

                    img.onerror = (error) => {
                        reject(`الصورة غير موجودة: ${error.message}`);
                    };
                });
            } catch (error) {
                alert("خطأ في طباعة الصورة: " + error);
            }
        }

        /* // Dynamsoft Scanner Code
        let DWTObject = null;
        let isInitialized = false;

        function initializeScanner() {
            if (!isInitialized) {
                Toast.fire({
                    icon: 'info',
                    title: 'جاري تهيئة الماسح الضوئي...',
                    showConfirmButton: false
                });

                // تهيئة إعدادات المكتبة
                Dynamsoft.DWT.AutoLoad = false;
                Dynamsoft.DWT.ResourcesPath = "/Resources";
                Dynamsoft.DWT.Containers = [{
                    ContainerId: 'dwtcontrolContainer',
                    Width: '100%',
                    Height: '300px'
                }];

                Dynamsoft.DWT.RegisterEvent('OnWebTwainReady', function() {
                    DWTObject = Dynamsoft.DWT.GetWebTwain('dwtcontrolContainer');
                    isInitialized = true;
                    $('#dwtcontrolContainer').show();
                    AcquireImage();
                });

                Dynamsoft.DWT.Load();
            } else {
                $('#dwtcontrolContainer').show();
                AcquireImage();
            }
        }

        function AcquireImage() {
            if (!DWTObject) {
                Toast.fire({
                    icon: 'error',
                    title: 'لم يتم العثور على الماسح الضوئي',
                });
                return;
            }

            // إغلاق أي اتصال سابق
            if (DWTObject.DataSourceStatus) {
                DWTObject.CloseSource();
            }

            DWTObject.SelectSourceAsync()
                .then(function() {
                    return DWTObject.AcquireImageAsync({
                        IfShowUI: true,
                        IfFeederEnabled: false,
                        IfDuplexEnabled: false,
                        PixelType: Dynamsoft.DWT.EnumDWT_PixelType.TWPT_RGB,
                        Resolution: 300,
                        IfCloseSourceAfterAcquire: true
                    });
                })
                .then(function() {
                    return DWTObject.ConvertToBlob([0], Dynamsoft.DWT.EnumDWT_ImageType.IT_PDF);
                })
                .then(function(blob) {
                    const file = new File([blob], "scanned_document.pdf", {
                        type: "application/pdf"
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.querySelector('#attachment').files = dataTransfer.files;
                    document.querySelector('#attachment').dispatchEvent(new Event('change'));

                    // تنظيف الذاكرة
                    DWTObject.RemoveAllImages();
                    $('#dwtcontrolContainer').hide();

                    Toast.fire({
                        icon: 'success',
                        title: 'تم المسح بنجاح',
                    });
                })
                .catch(function(error) {
                    console.error(error);
                    // محاولة إغلاق المصدر في حالة الخطأ
                    if (DWTObject.DataSourceStatus) {
                        DWTObject.CloseSource();
                    }
                    Toast.fire({
                        icon: 'error',
                        title: 'حدث خطأ أثناء المسح',
                        text: error.message
                    });
                });
        } */

        // المسح الضوئي باستخدام NAPS2
        function initializeNaps2Scanner() {
            Swal.fire({
                icon: 'info',
                title: 'جاري المسح',
                text: 'تم تشغيل الماسح الضوئي جاري عملية اخذ الصورة ...',
                showConfirmButton: false,
                allowOutsideClick: false
            });

            fetch("http://localhost:3001/scan")
                .then(response => {
                    if (!response.ok) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'فشل تشغيل NAPS2'
                        });
                        throw new Error("فشل تشغيل NAPS2");
                    }

                    let attempts = 0;
                    const maxAttempts = 5;

                    function checkScanResult() {
                        fetch('/latest-scan')
                            .then(res => res.json())
                            .then(async data => {
                                if (data.url) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'جاري المسح',
                                        text: 'تم تشغيل الماسح الضوئي جاري عملية اخذ الصورة ...',
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });

                                    try {
                                        const response = await fetch(data.url);
                                        const blob = await response.blob();
                                        const file = new File([blob], data.name, {
                                            type: data.name.endsWith('.pdf') ? 'application/pdf' :
                                                'image/jpeg'
                                        });

                                        const dataTransfer = new DataTransfer();
                                        dataTransfer.items.add(file);
                                        const attachmentInput = document.getElementById('attachment');
                                        attachmentInput.files = dataTransfer.files;

                                        // تحديث Livewire باستخدام الحدث
                                        let component = window.Livewire.find(
                                            document.getElementById('attachment').closest('[wire\\:id]')
                                            .getAttribute('wire:id')
                                        );

                                        // رفع الملف إلى Livewire
                                        const reader = new FileReader();
                                        reader.readAsDataURL(file);
                                        reader.onload = () => {
                                            component.upload('attachment', file, (uploadedFilename) => {
                                                // تحديث عنوان URL المؤقت
                                                component.set('tempImageUrl', data.url);
                                            }, () => {
                                                console.error('Upload failed');
                                            }, (e) => {
                                                console.log('Upload progress:', e.detail.progress);
                                            });
                                        };

                                        // عرض في المعاينة المؤقتة
                                        const container = document.getElementById('dwtcontrolContainer');
                                        container.style.display = 'none';

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'نجاح',
                                            text: 'تم المسح الضوئي بنجاح',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    } catch (error) {
                                        console.error('Error:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'خطأ',
                                            text: 'حدث خطأ أثناء معالجة الملف'
                                        });
                                    }
                                } else if (++attempts < maxAttempts) {
                                    setTimeout(checkScanResult, 3000);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطأ',
                                        text: 'لم يتم العثور على ملف مسح'
                                    });
                                }
                            })
                            .catch(() => {
                                if (++attempts < maxAttempts) {
                                    setTimeout(checkScanResult, 3000);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطأ',
                                        text: 'فشل في جلب نتيجة المسح'
                                    });
                                }
                            });
                    }

                    setTimeout(checkScanResult, 3000);
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: "حدث خطأ: " + error.message
                    });
                });
        }

        $(document).ready(function() {
            function initSelect2(selector, eventName) {
                $(selector).select2({
                    placeholder: 'اختيار',
                    dropdownParent: $(parentModal),
                });
                $(selector).on('change', function(e) {
                    livewire.emit(eventName, e.target.value);
                });
            }
            initSelect2('#search_related_book_id', 'updateSearchRelatedBookId');
            initSelect2('#search_sender_id', 'updateSearchSenderId');
            window.livewire.on('reinitializeSelect2', () => {
                initSelect2('#search_related_book_id', 'updateSearchRelatedBookId');
                initSelect2('#search_sender_id', 'updateSearchSenderId');
            });
        });

        $(document).ready(function() {
            function initSelect2(selector, eventName, parentModal) {
                $(selector).select2({
                    placeholder: 'اختيار',
                    dropdownParent: $(parentModal),
                    allowClear: true
                });
                $(selector).on('change', function(e) {
                    livewire.emit(eventName, e.target.value);
                });
            }
            initSelect2('#addIncomingbookrelated_book_id', 'GetSenderId', '#addincomingbookModal');
            initSelect2('#editIncomingbookrelated_book_id', 'GetSenderId', '#editincomingbookModal');
            window.livewire.on('select2', () => {
                initSelect2('#addIncomingbookrelated_book_id', 'GetSenderId', '#addincomingbookModal');
                initSelect2('#editIncomingbookrelated_book_id', 'GetSenderId', '#editincomingbookModal');
            });
        });


        $(document).ready(function() {
            function initSelect2(selector, eventName, parentModal) {
                $(selector).select2({
                    placeholder: 'اختيار',
                    dropdownParent: $(parentModal),
                    closeOnSelect: false,
                    width: '100%',
                    templateSelection: function(data) {
                        return $('<span>' + data.text + '</span>');
                    },
                    templateResult: function(data) {
                        return $('<span>' + data.text + '</span>');
                    }
                });

                $(selector).on('change', function(e) {
                    livewire.emit(eventName, $(this).val());
                });
            }
            window.livewire.on('initAddSelect2', (selector, values) => {
                $(selector).val(values).trigger('change');
                initSelect2(selector, 'GetDepAndSec', '#addincomingbookModal');
            });
            window.livewire.on('initEditSelect2', (selector, values) => {
                $(selector).val(values).trigger('change');
                initSelect2(selector, 'GetDepAndSec', '#editincomingbookModal');
            });
            window.livewire.on('select2', () => {
                if ($('#addIncomingbooksender_id').length) {
                    initSelect2('#addIncomingbooksender_id', 'GetDepAndSec',
                        '#addincomingbookModal');
                }
                if ($('#editIncomingbooksender_id').length) {
                    initSelect2('#editIncomingbooksender_id', 'GetDepAndSec',
                        '#editincomingbookModal');
                }
            });
            window.livewire.on('initEditSelect2', function(data) {
                $(data.selector).val(data.values).trigger('change');
            });
            $('#editincomingbookModal').on('hidden.bs.modal', function() {
                $('#editIncomingbooksender_id').val(null).trigger('change');
            });
        });

        $(document).ready(function() {
            function initFlatpickr(selector, eventName) {
                $(selector).flatpickr({
                    dateFormat: "d/m/Y",
                    allowInput: true,
                    placeholder: 'يوم / شهر / سنة',
                    defaultDate: null,
                    onChange: function(selectedDates, dateStr, instance) {
                        livewire.emit(eventName, dateStr);
                    }
                });
            }
            initFlatpickr('#addIncomingbookbook_date', 'Incomingbookbook_date');
            initFlatpickr('#editIncomingbookbook_date', 'Incomingbookbook_date');
            window.livewire.on('flatpickr', () => {
                initFlatpickr('#addIncomingbookbook_date', 'Incomingbookbook_date');
                initFlatpickr('#editIncomingbookbook_date', 'Incomingbookbook_date');
            });
        });

        $(document).ready(function() {
            function initFlatpickr(selector, eventName) {
                const inputElement = $(selector);
                const clearButton = $(`${selector}-clear`);
                inputElement.flatpickr({
                    placeholder: 'يوم / شهر / سنة',
                    dateFormat: 'Y-m-d',
                });
                inputElement.on('change', function(e) {
                    livewire.emit(eventName, e.target.value);
                });
                clearButton.on('click', function() {
                    inputElement.val('').trigger('change');
                    livewire.emit(eventName, null);
                });
            }
            initFlatpickr('#showIncomingbookbook_date', 'showIncomingbookbook');
            window.livewire.on('flatpickr', () => {
                initFlatpickr('#showIncomingbookbook_date', 'showIncomingbookbook');
            });
        });

        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode < 48 || ASCIICode > 57)
                return false;
            return true;
        }

        function onlyArabicKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
            // نطاق رموز الحروف العربية والفراغ
            if ((ASCIICode >= 1569 && ASCIICode <= 1610) || ASCIICode === 32) {
                return true;
            }
            return false;
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        window.addEventListener('IncomingbookModalShow', event => {
            setTimeout(() => {
                $('#id').focus();
            }, 100);
        })

        window.addEventListener('success', event => {
            $('#addincomingbookModal').modal('hide');
            $('#editincomingbookModal').modal('hide');
            $('#removeincomingbookModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.title + '<hr>' + event.detail.message,
            })
        })

        window.addEventListener('error', event => {
            $('#removeincomingbookModal').modal('hide');
            Toast.fire({
                icon: 'error',
                title: event.detail.title + '<hr>' + event.detail.message,
                timer: 5000,
            })

        })

        window.addEventListener('showDelayedMessage', event => {
            setTimeout(() => {
                Toast.fire({
                    icon: 'success',
                    title: event.detail.title + '<hr>' + event.detail.message,
                });
            }, 3000);
        });

        // Reset file input and remove preview
        window.addEventListener('resetFileInput', event => {
            const input = document.getElementById(event.detail.input);
            if (input) {
                input.value = '';
                const previewContainer = document.querySelector('.preview-wrapper');
                if (previewContainer) {
                    previewContainer.remove();
                }
            }
        });

        // اقترحات الكلمات المفتاحية باستخدام Tagify
        document.addEventListener('DOMContentLoaded', function() {
            const selectors = ['#addIncomingbookkeywords', '#editIncomingbookkeywords'];

            selectors.forEach(id => {
                const input = document.querySelector(id);
                if (!input) return;

                const tagify = new Tagify(input, {
                    delimiters: ",",
                    maxTags: 6,
                    dropdown: {
                        enabled: 1,
                        maxItems: 10,
                        closeOnSelect: false,
                        highlightFirst: true,
                        classname: 'tags-look'
                    },
                    enforceWhitelist: false,
                    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(
                        ',')
                });

                input.tagify = tagify;

                // جلب الاقتراحات عند الكتابة
                tagify.on('input', function(e) {
                    let value = e.detail.value.trim();

                    if (value.length < 2) {
                        tagify.dropdown.hide();
                        return;
                    }

                    fetch(`/keywords/suggestions?keyword=${encodeURIComponent(value)}`)
                        .then(res => res.json())
                        .then(suggestions => {
                            tagify.settings.whitelist = suggestions.map(item => item.value);
                            tagify.dropdown.show.call(tagify, value);
                        });
                });

                // منع إدخال أكثر من 6 كلمات
                tagify.on('add', function(e) {
                    if (tagify.value.length > 6) {
                        tagify.removeTag(e.detail.data.value);
                        alert('لا يمكن إضافة أكثر من 6 كلمات مفتاحية');
                    }
                });
            });
        });
    </script>
@endsection
