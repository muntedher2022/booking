<div>
    @can('reports-view')
        <div class="card">
            @can('reports-create')
                <div class="card-header">
                    <h4 class="d-flex align-items-center gap-2">
                        <span class="text-muted d-flex align-items-center">
                            <i class="mdi mdi-file-chart-outline fs-4"></i>
                            <span class="ms-1">التقارير</span>
                        </span>
                        <i class="mdi mdi-chevron-left text-primary"></i>
                        <span class="fw-bold text-primary d-flex align-items-center">
                            <i class="mdi mdi-file-document-outline me-1 fs-4"></i>
                            <span class="ms-1">إنشاء تقرير جديد</span>
                        </span>
                    </h4>
                </div>
            @endcan

            <div class="card-body">
                <!-- الأعمدة المطلوبة -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 d-flex align-items-center">
                            <i class="mdi mdi-table-column me-2 text-primary"></i>
                            <span class="fw-semibold">الأعمدة المطلوبة</span>
                        </h5>

                        <button class="btn btn-primary btn-sm" wire:click="generateReport"
                            {{ count($selectedColumns) > 0 ? '' : 'disabled' }}>
                            <i class="mdi mdi-file-document-outline me-1"></i>
                            إنشاء التقرير
                        </button>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach ($availableColumns as $key => $label)
                                <div class="col-md-3">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content p-3"
                                            for="column_{{ $key }}">
                                            <span class="custom-option-body">
                                                <i class="mdi {{ $this->getColumnIcon($key) }} mb-2"></i>
                                                <span
                                                    class="custom-option-title fw-semibold mb-1">{{ $label }}</span>
                                                <small class="d-block text-muted">اختر للإضافة في التقرير</small>
                                            </span>
                                            <input class="form-check-input" type="checkbox" wire:model="selectedColumns"
                                                value="{{ $key }}" id="column_{{ $key }}">
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- الفلاتر -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 d-flex align-items-center">
                            <i class="mdi mdi-filter-outline me-2 text-primary"></i>
                            <span class="fw-semibold">الفلاتر</span>
                        </h5>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">نوع الكتاب</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-format-list-bulleted"></i></span>
                                    <select wire:model="filters.book_type" class="form-select">
                                        <option value="">الكل</option>
                                        <option value="وارد">وارد</option>
                                        <option value="صادر">صادر</option>
                                    </select>
                                </div>
                            </div>

                            <!-- نطاق الكتاب -->
                            <div class="col-md-4">
                                <label class="form-label">نطاق الكتاب</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-map-outline"></i></span>
                                    <select wire:model="filters.sender_type" class="form-select">
                                        <option value="">الكل</option>
                                        <option value="داخلي">داخلي</option>
                                        <option value="خارجي">خارجي</option>
                                    </select>
                                </div>
                            </div>

                            <!-- درجة الأهمية -->
                            <div class="col-md-4">
                                <label class="form-label">درجة الأهمية</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-star-outline"></i></span>
                                    <select wire:model="filters.importance" class="form-select">
                                        <option value="">الكل</option>
                                        <option value="عادي">عادي</option>
                                        <option value="عاجل">عاجل</option>
                                        <option value="سري">سري</option>
                                        <option value="سري للغاية">سري للغاية</option>
                                    </select>
                                </div>
                            </div>

                            <!-- التاريخ -->
                            <div class="col-md-6">
                                <label class="form-label">من تاريخ</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-calendar-range"></i></span>
                                    <input type="date" wire:model="filters.date_from" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">إلى تاريخ</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-calendar-range"></i></span>
                                    <input type="date" wire:model="filters.date_to" class="form-control">
                                </div>
                            </div>

                            <!-- الكلمات المفتاحية -->
                            <div class="col-md-6">
                                <label class="form-label">الكلمات المفتاحية</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                                    <input type="text" wire:model="filters.keywords" class="form-control"
                                        placeholder="بحث في الكلمات المفتاحية">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الدوائر والأقسام</label>
                                <div wire:ignore>
                                    <select id="entities" class="select2 form-select" multiple
                                        data-placeholder="اختر الدوائر والأقسام">
                                        <optgroup label="الدوائر">
                                            @foreach ($this->getDepartments() as $department)
                                                <option value="dep_{{ $department->id }}">
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="الأقسام">
                                            @foreach ($this->getSections() as $section)
                                                <option value="sec_{{ $section->id }}">{{ $section->section_name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- النتائج -->
                @if ($showResults && count($reportData) > 0)
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="mdi mdi-table me-2 text-primary"></i>
                                <span class="fw-semibold">نتائج التقرير</span>
                            </h5>
                            <div>
                                <button wire:click="exportToExcel" class="btn btn-success btn-sm">
                                    <i class="mdi mdi-file-excel-outline me-1"></i>تصدير Excel
                                </button>
                                <button onclick="printReport()" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-printer-outline me-1"></i>طباعة
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="table-responsive" id="reportTable">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-primary">
                                        <tr>
                                            @foreach ($selectedColumns as $column)
                                                <th class="text-center">{{ $availableColumns[$column] ?? $column }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reportData as $row)
                                            <tr>
                                                @foreach ($selectedColumns as $column)
                                                    <td class="text-center">{{ $row[$column] }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
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


@push('styles')
    <style>
        .custom-option-icon {
            margin: 0;
        }

        .custom-option-icon .custom-option-content {
            padding: 1.4rem !important;
            border: 1px solid #e0e0e0;
            border-radius: 0.75rem;
            width: 100%;
            cursor: pointer;
            position: relative;
            transition: all 0.25s ease;
        }

        .custom-option-icon .custom-option-content:hover {
            background: #f8f9fa;
            transform: translateY(-4px);
            box-shadow: 0 3px 12px 0 rgba(105, 108, 255, 0.1);
        }

        .custom-option-icon i {
            font-size: 2rem;
            color: #696cff;
            display: block;
            text-align: center;
        }

        .custom-option-body {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100px;
        }

        .custom-option-title {
            color: #566a7f;
            font-size: 0.9375rem;
        }

        .form-check-input {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1;
        }

        .form-check-input:checked~.custom-option-content {
            border: 2px solid #696cff;
            background-color: #f1f1ff;
        }

        .form-check-input:checked~.custom-option-content .custom-option-title {
            color: #696cff;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .print-container {
                padding: 20px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .print-header {
                display: flex;
                align-items: center;
                gap: 20px;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #696cff;
            }

            .header-logo {
                background: #696cff;
                color: white;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 30px;
            }

            .header-logo i {
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

            .header-details i {
                visibility: visible;
                color: #696cff;
            }

            .print-footer {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #ddd;
                text-align: center;
                color: #666;
                font-size: 12px;
            }

            .table {
                margin-top: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .table thead th {
                background-color: #696cff !important;
                color: white !important;
                font-weight: bold;
            }

            @page {
                margin: 2cm;
                size: A4;
            }
        }
    </style>
@endpush
