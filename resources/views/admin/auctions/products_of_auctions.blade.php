@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Products</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Auctions Management</a>
                            <span class="breadcrumb-item active">All products</span>
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
                        <h5 class="card-title">All Products of All Auctions</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- You can <code>Search</code>, <code>View</code> & <code>Delete</code> the specific Auction from here. --}}
                    </div>

                    <table class="table datatable-show-all">
                        <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Product</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Auction House</th>
                                <th>Won List</th>
                                <th>Product Status</th>
                                <th>Payment Status</th>
                                {{-- <th class="text-center">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                 <td>
                                    <img src="{{ asset('admin/global_assets/images/car.jpg') }}" width="36" height="36" alt="">
                                </td>
                                <td>Car</td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td><span>2021-06-14</span><span>11:12:13</span></td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-danger">Pending</span></td>
                                {{-- <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="far fa-hand-paper"></i> Stop</a>
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-hourglass-start"></i> Start</a>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                             <tr>
                                <td>12</td>
                                 <td>
                                    <img src="{{ asset('admin/global_assets/images/car.jpg') }}" width="36" height="36" alt="">
                                </td>
                                <td>Car</td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td><span>2021-06-14</span><span>11:12:13</span></td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-danger">Pending</span></td>
                                {{-- <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="far fa-hand-paper"></i> Stop</a>
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-hourglass-start"></i> Start</a>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                             <tr>
                                <td>12</td>
                                 <td>
                                    <img src="{{ asset('admin/global_assets/images/car.jpg') }}" width="36" height="36" alt="">
                                </td>
                                <td>Car</td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td><span>2021-06-14</span><span>11:12:13</span></td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-danger">Pending</span></td>
                                {{-- <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="far fa-hand-paper"></i> Stop</a>
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-hourglass-start"></i> Start</a>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                             <tr>
                                <td>12</td>
                                 <td>
                                    <img src="{{ asset('admin/global_assets/images/car.jpg') }}" width="36" height="36" alt="">
                                </td>
                                <td>Car</td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td><span>2021-06-14</span><span>11:12:13</span></td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-danger">Pending</span></td>
                                {{-- <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="far fa-hand-paper"></i> Stop</a>
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-hourglass-start"></i> Start</a>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                             <tr>
                                <td>12</td>
                                 <td>
                                    <img src="{{ asset('admin/global_assets/images/car.jpg') }}" width="36" height="36" alt="">
                                </td>
                                <td>Car</td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td><span>2021-06-14</span><span>11:12:13</span></td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-danger">Pending</span></td>
                                {{-- <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="far fa-hand-paper"></i> Stop</a>
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-hourglass-start"></i> Start</a>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /page length options -->

            </div>
            <!-- /content area -->

@endsection
