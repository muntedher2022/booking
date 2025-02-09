@extends('layouts/layoutMaster')
@section('title', 'Outgoingbooks')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
@endsection
@section('content')

    @livewire('outgoingbooks.outgoingbook')

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
@endsection

@section('page-script')
    <script src=" {{ asset('assets/js/app-user-list.js') }}"></script>
    <script src=" {{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src=" {{ asset('assets/js/form-basic-inputs.js') }}"></script>
    <script>
        /* function printFile(fileUrl) {
                                                const fileExtension = fileUrl.split('.').pop().toLowerCase();
                                                const isPDF = fileExtension === 'pdf';

                                                if (isPDF) {
                                                    printJS({
                                                        printable: fileUrl,
                                                        type: 'pdf',
                                                        onError: function(error) {
                                                            alert("خطأ في طباعة ملف PDF: " + error.message);
                                                        }
                                                    });
                                                } else {
                                                    printJS({
                                                        printable: fileUrl,
                                                        type: 'image',
                                                        onError: function(error) {
                                                            alert("خطأ في طباعة ملف PDF: " + error.message);
                                                        }
                                                    });
                                                }
                                            } */

        function printFile(fileUrl) {
            const fileExtension = fileUrl.split('.').pop().toLowerCase();
            const isPDF = fileExtension === 'pdf';

            if (isPDF) {
                printJS({
                    printable: fileUrl,
                    type: 'pdf',
                    onError: function(error) {
                        alert("خطأ في طباعة ملف PDF: " + error.message);
                    }
                });
            } else {
                // طباعة الصور بحجم ورقة A4
                printImage(fileUrl);
            }
        }

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

        $(document).ready(function() {
            function initSelect2(selector, eventName) {
                $(selector).select2({
                    placeholder: 'اختيار',
                    dropdownParent: $(parentModal)
                });
                $(selector).on('change', function(e) {
                    livewire.emit(eventName, e.target.value);
                });
            }
            initSelect2('#search_related_book_id', 'updateSearchRelatedBookId');
            initSelect2('#search_recipient_id', 'updateSearchRecipientId');
            window.livewire.on('reinitializeSelect2', () => {
                initSelect2('#search_related_book_id', 'updateSearchRelatedBookId');
                initSelect2('#search_recipient_id', 'updateSearchRecipientId');
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
            initSelect2('#addOutgoingbookrelated_book_id', 'GetRecipientId', '#addoutgoingbookModal');
            initSelect2('#editOutgoingbookrelated_book_id', 'GetRecipientId', '#editoutgoingbookModal');
            window.livewire.on('select2', () => {
                initSelect2('#addOutgoingbookrelated_book_id', 'GetRecipientId', '#addoutgoingbookModal');
                initSelect2('#editOutgoingbookrelated_book_id', 'GetRecipientId', '#editoutgoingbookModal');
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
                initSelect2(selector, 'GetDepAndSec', '#addoutgoingbookModal');
            });
            window.livewire.on('initEditSelect2', (selector, values) => {
                $(selector).val(values).trigger('change');
                initSelect2(selector, 'GetDepAndSec', '#editoutgoingbookModal');
            });
            window.livewire.on('select2', () => {
                if ($('#addOutgoingbookrecipient_id').length) {
                    initSelect2('#addOutgoingbookrecipient_id', 'GetDepAndSec',
                        '#addoutgoingbookModal');
                }
                if ($('#editOutgoingbookrecipient_id').length) {
                    initSelect2('#editOutgoingbookrecipient_id', 'GetDepAndSec',
                        '#editoutgoingbookModal');
                }
            });
            window.livewire.on('initEditSelect2', function(data) {
                $(data.selector).val(data.values).trigger('change');
            });
            $('#editoutgoingbookModal').on('hidden.bs.modal', function() {
                $('#editOutgoingbookrecipient_id').val(null).trigger('change');
            });
        });

        $(document).ready(function() {
            function initFlatpickr(selector, eventName) {
                const inputElement = $(selector);
                inputElement.flatpickr({
                    dateFormat: "Y/m/d",
                    allowInput: true,
                    placeholder: 'يوم / شهر / سنة',
                    maxDate: "today",
                    yearSelectorType: "input", // تمكين الكتابة في حقل السنة داخل الرزنامة
                });
                inputElement.on('change', function(e) {
                    livewire.emit(eventName, e.target.value);
                });
            }
            initFlatpickr('#addOutgoingbookbook_date', 'Outgoingbookbook_date');
            initFlatpickr('#editOutgoingbookbook_date', 'Outgoingbookbook_date');
            window.livewire.on('flatpickr', () => {
                initFlatpickr('#addOutgoingbookbook_date', 'Outgoingbookbook_date');
                initFlatpickr('#editOutgoingbookbook_date', 'Outgoingbookbook_date');
            });
        });

        $(document).ready(function() {
            function initFlatpickr(selector, eventName) {
                const inputElement = $(selector);
                const clearButton = $(`${selector}-clear`);
                inputElement.flatpickr({
                    dateFormat: "Y/m/d",
                    allowInput: true,
                    placeholder: 'يوم / شهر / سنة',
                    maxDate: "today",
                });
                inputElement.on('change', function(e) {
                    livewire.emit(eventName, e.target.value);
                });
                clearButton.on('click', function() {
                    inputElement.val('').trigger('change');
                    livewire.emit(eventName, null);
                });
            }
            initFlatpickr('#showOutgoingbookbook_date', 'showOutgoingbookbook_date');
            window.livewire.on('flatpickr', () => {
                initFlatpickr('#showOutgoingbookbook_date', 'showOutgoingbookbook_date');
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

        window.addEventListener('OutgoingbookModalShow', event => {
            setTimeout(() => {
                $('#id').focus();
            }, 100);
        })

        window.addEventListener('success', event => {
            $('#addoutgoingbookModal').modal('hide');
            $('#editoutgoingbookModal').modal('hide');
            $('#removeoutgoingbookModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.title + '<hr>' + event.detail.message,
            })
        })

        window.addEventListener('error', event => {
            $('#removeoutgoingbookModal').modal('hide');
            Toast.fire({
                icon: 'error',
                title: event.detail.title + '<hr>' + event.detail.message,
                timer: 5000,
            })

        })
    </script>
@endsection
