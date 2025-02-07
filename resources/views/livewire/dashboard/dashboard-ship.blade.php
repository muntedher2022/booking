<div>


     <div class="row">
        <!-- رسم بياني: Line Area Chart -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">العمل اليومي</h5>
                        <small class="text-muted">قسم الأملاك و الأراضي</small>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-calendar-month-outline"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="javascript:void(0);" class="dropdown-item">Today</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Yesterday</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Last 7 Days</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Last 30 Days</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Current Month</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Last Month</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="lineAreaChart"></div>
                </div>
            </div>
        </div>
        <!--/ Line Area Chart -->

    </div>

    <div class="row mb-3">
        <div class="col-12 mb-4">
            <div class="card">
                <h5 class="card-header text-center text-md-start">المتأخرين من الدفع</h5>
                <div class="card-datatable text-nowrap">
                    <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="DataTables_Table_1_length"><label>Show <select
                                            name="DataTables_Table_1_length" aria-controls="DataTables_Table_1"
                                            class="form-select form-select-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label></div>
                            </div>
                            <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                                <div id="DataTables_Table_1_filter" class="dataTables_filter"><label>Search:<input
                                            type="search" class="form-control form-control-sm" placeholder=""
                                            aria-controls="DataTables_Table_1"></label></div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="dt-column-search table table-bordered dataTable" id="DataTables_Table_1"
                                aria-describedby="DataTables_Table_1_info" style="width: 1230px;">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0"
                                            aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                            style="width: 162.2px;"
                                            aria-label="Name: activate to sort column descending" aria-sort="ascending">
                                            Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" style="width: 233.2px;"
                                            aria-label="Email: activate to sort column ascending">Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" style="width: 228.2px;"
                                            aria-label="Post: activate to sort column ascending">Post</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" style="width: 173.2px;"
                                            aria-label="City: activate to sort column ascending">City</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" style="width: 81.2px;"
                                            aria-label="Date: activate to sort column ascending">Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" style="width: 87px;"
                                            aria-label="Salary: activate to sort column ascending">Salary</th>
                                    </tr>
                                    <tr>
                                        <th style="border-left: medium;" rowspan="1" colspan="1"><input
                                                type="text" class="form-control" placeholder="Search Name"></th>
                                        <th style="border-left: medium;" rowspan="1" colspan="1"><input
                                                type="text" class="form-control" placeholder="Search Email"></th>
                                        <th style="border-left: medium;" rowspan="1" colspan="1"><input
                                                type="text" class="form-control" placeholder="Search Post"></th>
                                        <th style="border-left: medium;" rowspan="1" colspan="1"><input
                                                type="text" class="form-control" placeholder="Search City"></th>
                                        <th style="border-left: medium;" rowspan="1" colspan="1"><input
                                                type="text" class="form-control" placeholder="Search Date"></th>
                                        <th style="border-left: medium; border-right: medium;" rowspan="1"
                                            colspan="1">
                                            <input type="text" class="form-control" placeholder="Search Salary">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd">
                                        <td class="sorting_1">Aila Quailadis</td>
                                        <td>aquail29@prlog.org</td>
                                        <td>Technical Writer</td>
                                        <td>Shuangchahe</td>
                                        <td>02/11/2021</td>
                                        <td>$24137.29</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="sorting_1">Aili De Coursey</td>
                                        <td>adew@etsy.com</td>
                                        <td>Environmental Specialist</td>
                                        <td>Łazy</td>
                                        <td>09/30/2021</td>
                                        <td>$14082.44</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="sorting_1">Alaric Beslier</td>
                                        <td>abeslier2n@zimbio.com</td>
                                        <td>Tax Accountant</td>
                                        <td>Ocucaje</td>
                                        <td>04/16/2021</td>
                                        <td>$19366.53</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="sorting_1">Aliza MacElholm</td>
                                        <td>amacelholm20@printfriendly.com</td>
                                        <td>VP Sales</td>
                                        <td>Sosnovyy Bor</td>
                                        <td>11/17/2021</td>
                                        <td>$16741.31</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="sorting_1">Allyson Moakler</td>
                                        <td>amoakler8@shareasale.com</td>
                                        <td>Safety Technician</td>
                                        <td>Mogilany</td>
                                        <td>12/29/2021</td>
                                        <td>$11677.32</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="sorting_1">Alma Harvatt</td>
                                        <td>aharvatt11@addtoany.com</td>
                                        <td>Administrative Assistant</td>
                                        <td>Ulundi</td>
                                        <td>11/04/2021</td>
                                        <td>$21782.82</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="sorting_1">Annetta Glozman</td>
                                        <td>aglozman1r@storify.com</td>
                                        <td>Staff Accountant</td>
                                        <td>Pendawanbaru</td>
                                        <td>08/25/2021</td>
                                        <td>$10745.32</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="sorting_1">Babb Skirving</td>
                                        <td>bskirving24@cbsnews.com</td>
                                        <td>Analyst Programmer</td>
                                        <td>Balky</td>
                                        <td>09/27/2021</td>
                                        <td>$24733.28</td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="sorting_1">Bailie Coulman</td>
                                        <td>bcoulman1@yolasite.com</td>
                                        <td>VP Quality Control</td>
                                        <td>Hinigaran</td>
                                        <td>05/20/2021</td>
                                        <td>$13633.69</td>
                                    </tr>
                                    <tr class="even">
                                        <td class="sorting_1">Beatrix Longland</td>
                                        <td>blongland12@gizmodo.com</td>
                                        <td>VP Quality Control</td>
                                        <td>Damu</td>
                                        <td>07/18/2021</td>
                                        <td>$22794.60</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Email</th>
                                        <th rowspan="1" colspan="1">Post</th>
                                        <th rowspan="1" colspan="1">City</th>
                                        <th rowspan="1" colspan="1">Date</th>
                                        <th rowspan="1" colspan="1">Salary</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_info" id="DataTables_Table_1_info" role="status"
                                    aria-live="polite">
                                    Showing 1 to 10 of 100 entries</div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_paginate paging_simple_numbers"
                                    id="DataTables_Table_1_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled"
                                            id="DataTables_Table_1_previous"><a aria-controls="DataTables_Table_1"
                                                aria-disabled="true" role="link" data-dt-idx="previous"
                                                tabindex="-1" class="page-link"><i
                                                    class="ri-arrow-left-s-line"></i></a>
                                        </li>
                                        <li class="paginate_button page-item active"><a href="#"
                                                aria-controls="DataTables_Table_1" role="link" aria-current="page"
                                                data-dt-idx="0" tabindex="0" class="page-link">1</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                aria-controls="DataTables_Table_1" role="link" data-dt-idx="1"
                                                tabindex="0" class="page-link">2</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                aria-controls="DataTables_Table_1" role="link" data-dt-idx="2"
                                                tabindex="0" class="page-link">3</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                aria-controls="DataTables_Table_1" role="link" data-dt-idx="3"
                                                tabindex="0" class="page-link">4</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                aria-controls="DataTables_Table_1" role="link" data-dt-idx="4"
                                                tabindex="0" class="page-link">5</a></li>
                                        <li class="paginate_button page-item disabled"
                                            id="DataTables_Table_1_ellipsis"><a aria-controls="DataTables_Table_1"
                                                aria-disabled="true" role="link" data-dt-idx="ellipsis"
                                                tabindex="-1" class="page-link">…</a></li>
                                        <li class="paginate_button page-item "><a href="#"
                                                aria-controls="DataTables_Table_1" role="link" data-dt-idx="9"
                                                tabindex="0" class="page-link">10</a></li>
                                        <li class="paginate_button page-item next" id="DataTables_Table_1_next"><a
                                                href="#" aria-controls="DataTables_Table_1" role="link"
                                                data-dt-idx="next" tabindex="0" class="page-link"><i
                                                    class="ri-arrow-right-s-line"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
