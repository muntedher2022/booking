@extends('layouts/layoutMaster')

@section('title', 'التقارير')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2-bootstrap-5-theme/select2-bootstrap-5-theme.css')}}" />
@endsection

@section('content')
    @livewire('report.report-component')
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/forms-selects.js')}}"></script>
    <script>
        $(document).ready(function() {
            function initSelect2() {
                $('#entities').select2({
                    dropdownParent: $('#entities').parent(),
                    placeholder: 'اختر الدوائر والأقسام',
                    allowClear: true,
                    width: '100%',
                    dir: 'rtl',
                    templateResult: formatOption,
                    templateSelection: formatOption
                }).on('change', function(e) {
                    // تحديث قيمة الفلتر عبر Livewire
                    Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
                        .set('filters.sender_id', $(this).val());
                });
            }

            function formatOption(option) {
                if (!option.id) return option.text;
                let icon = option.element.closest('optgroup').label === 'الدوائر' ?
                    'mdi-office-building' : 'mdi-domain';
                return $(`<span><i class="mdi ${icon} me-2"></i>${option.text}</span>`);
            }

            initSelect2();

            Livewire.on('contentChanged', function() {
                $('#entities').select2('destroy');
                initSelect2();
            });
        });

        function printReport() {
            let printFrame = document.createElement('iframe');
            printFrame.style.display = 'none';
            document.body.appendChild(printFrame);

            let printContent = `
                <!DOCTYPE html>
                <html dir="rtl">
                <head>
                    <title>تقرير المخاطبات</title>
                    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css') }}">
                    <style>
                        body {
                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                            padding: 2rem;
                        }

                        .print-container {
                            max-width: 1200px;
                            margin: 0 auto;
                        }

                        .print-header {
                            display: flex;
                            align-items: center;
                            gap: 2rem;
                            margin-bottom: 2rem;
                            padding-bottom: 1rem;
                            border-bottom: 2px solid #696cff;
                        }

                        .header-logo {
                            width: 80px;
                            height: 80px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .header-logo img {
                            width: 100%;
                            height: 100%;
                            object-fit: contain;
                            visibility: visible;
                        }

                        .header-content {
                            flex-grow: 1;
                        }

                        .header-content h2 {
                            color: #333;
                            margin: 0 0 10px 0;
                            font-size: 24px;
                            font-weight: bold;
                        }

                        .header-details {
                            display: flex;
                            gap: 20px;
                            color: #666;
                            font-size: 14px;
                        }

                        .header-details span {
                            display: flex;
                            align-items: center;
                            gap: 5px;
                        }

                        .header-details img {
                            visibility: visible !important;
                            vertical-align: middle;
                            display: inline-block;
                        }

                        /* تنسيق الجدول */
                        .table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 2rem;
                            background: white;
                        }

                        .table th,
                        .table td {
                            padding: 1rem;
                            text-align: center;
                            border: 1px solid #e0e0e0;
                        }

                        .table thead th {
                            background-color: #696cff !important;
                            color: white !important;
                            font-weight: 600;
                            font-size: 1rem;
                            white-space: nowrap;
                            border-bottom: 3px solid #5a5fd7;
                        }

                        .table tbody tr:nth-child(even) {
                            background-color: #f8f9fa;
                        }

                        .table tbody tr:hover {
                            background-color: #f1f1ff;
                        }

                        .table td {
                            font-size: 0.95rem;
                            vertical-align: middle;
                        }

                        .print-footer {
                            margin-top: 2rem;
                            padding-top: 1rem;
                            border-top: 1px solid #e0e0e0;
                            text-align: center;
                            font-size: 0.875rem;
                            color: #666;
                        }

                        @page {
                            size: A4 landscape;
                            margin: 1.5cm;
                        }

                        @media print {
                            body { -webkit-print-color-adjust: exact; }
                            .table thead th {
                                -webkit-print-color-adjust: exact;
                                background-color: #696cff !important;
                                color: white !important;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-container">
                        <div class="print-header">
                            <div class="header-logo">
                                <img src="{{ asset('assets/img/logo/GCPI.png') }}" alt="logo">
                            </div>
                            <div class="header-content">
                                <h2>تقرير المخاطبات</h2>
                                <div class="header-details">
                                    <span>
                                        <img src="{{ asset('assets/img/logo/calendar.png') }}" alt="calendar" style="width: 20px; height: 20px; margin-left: 5px;">
                                        تاريخ الطباعة: ${new Date().toLocaleDateString('ar-IQ')}
                                    </span>
                                    <span>
                                        <img src="{{ asset('assets/img/logo/clock.png') }}" alt="clock" style="width: 20px; height: 20px; margin-left: 5px;">
                                        وقت الطباعة: ${new Date().toLocaleTimeString('ar-IQ')}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            ${document.getElementById('reportTable').innerHTML}
                        </div>
                        <div class="print-footer">
                            <p>© ${new Date().getFullYear()} جميع الحقوق محفوظة | تم إنشاء هذا التقرير بتاريخ ${new Date().toLocaleDateString('ar-IQ')}</p>
                        </div>
                    </div>
                </body>
                </html>
            `;

            // طباعة المحتوى من خلال iframe
            let frameDoc = printFrame.contentWindow.document;
            frameDoc.open();
            frameDoc.write(printContent);
            frameDoc.close();

            printFrame.contentWindow.onafterprint = function() {
                document.body.removeChild(printFrame);
            };

            setTimeout(function() {
                printFrame.contentWindow.print();
            }, 500);
        }
    </script>
@endsection
