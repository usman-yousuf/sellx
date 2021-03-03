@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - User Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> User Management</a>
                            <span class="breadcrumb-item active">All Users</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            <div class="content">

                <!-- Page length options -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Page length options</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        It is possible to easily customise the options shown in the length menu using the <code>lengthMenu</code> initialisation option. This parameter can take one of two forms: 1) A <code>1D</code> array of options which will be used for both the displayed option and the value; 2) A <code>2D</code> array in which the first array is used to define the value options and the second array the displayed options. The example below shows a 2D array being used to include a <code>"Show all"</code> records option.
                    </div>

                    <table class="table datatable-show-all">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Job Title</th>
                                <th>DOB</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Marth</td>
                                <td><a href="#">Enright</a></td>
                                <td>Traffic Court Referee</td>
                                <td>22 Jun 1972</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Jackelyn</td>
                                <td>Weible</td>
                                <td><a href="#">Airline Transport Pilot</a></td>
                                <td>3 Oct 1981</td>
                                <td><span class="badge badge-secondary">Inactive</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Aura</td>
                                <td>Hard</td>
                                <td>Business Services Sales Representative</td>
                                <td>19 Apr 1969</td>
                                <td><span class="badge badge-danger">Suspended</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Nathalie</td>
                                <td><a href="#">Pretty</a></td>
                                <td>Drywall Stripper</td>
                                <td>13 Dec 1977</td>
                                <td><span class="badge badge-info">Pending</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sharan</td>
                                <td>Leland</td>
                                <td>Aviation Tactical Readiness Officer</td>
                                <td>30 Dec 1991</td>
                                <td><span class="badge badge-secondary">Inactive</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Maxine</td>
                                <td><a href="#">Woldt</a></td>
                                <td><a href="#">Business Services Sales Representative</a></td>
                                <td>17 Oct 1987</td>
                                <td><span class="badge badge-info">Pending</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sylvia</td>
                                <td><a href="#">Mcgaughy</a></td>
                                <td>Hemodialysis Technician</td>
                                <td>11 Nov 1983</td>
                                <td><span class="badge badge-danger">Suspended</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Lizzee</td>
                                <td><a href="#">Goodlow</a></td>
                                <td>Technical Services Librarian</td>
                                <td>1 Nov 1961</td>
                                <td><span class="badge badge-danger">Suspended</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Kennedy</td>
                                <td>Haley</td>
                                <td>Senior Marketing Designer</td>
                                <td>18 Dec 1960</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Chantal</td>
                                <td><a href="#">Nailor</a></td>
                                <td>Technical Services Librarian</td>
                                <td>10 Jan 1980</td>
                                <td><span class="badge badge-secondary">Inactive</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Delma</td>
                                <td>Bonds</td>
                                <td>Lead Brand Manager</td>
                                <td>21 Dec 1968</td>
                                <td><span class="badge badge-info">Pending</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Roland</td>
                                <td>Salmos</td>
                                <td><a href="#">Senior Program Developer</a></td>
                                <td>5 Jun 1986</td>
                                <td><span class="badge badge-secondary">Inactive</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Coy</td>
                                <td>Wollard</td>
                                <td>Customer Service Operator</td>
                                <td>12 Oct 1982</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Maxwell</td>
                                <td>Maben</td>
                                <td>Regional Representative</td>
                                <td>25 Feb 1988</td>
                                <td><span class="badge badge-danger">Suspended</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Cicely</td>
                                <td>Sigler</td>
                                <td><a href="#">Senior Research Officer</a></td>
                                <td>15 Mar 1960</td>
                                <td><span class="badge badge-info">Pending</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-file-pdf"></i> Export to .pdf</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-excel"></i> Export to .csv</a>
                                                <a href="#" class="dropdown-item"><i class="icon-file-word"></i> Export to .doc</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /page length options -->

            </div>
            <!-- /content area -->

@endsection