@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Won List</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Won List Management</a>
                            <span class="breadcrumb-item active">Won List</span>
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
                        <h5 class="card-title">All Products of Won List</h5>
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
                                <th>UserName</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Auction House</th>
                                <th>Product Qty</th>
                                <th>Product Price</th>
                                <th>Product Status</th>
                                <th>Payment Status</th>
                                {{-- <th class="text-center">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>Halan</td>
                                <td>
                                    <img src="{{ asset('public/admin/global_assets/images/car.jpg') }}" width="30" height="30" alt="">
                                    <span class="ml-1">Car</span></td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td>8</td>
                                <td>300</td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-success">Won</span></td>
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
<td>Halan</td>
                                <td>
                                    <img src="{{ asset('public/admin/global_assets/images/car.jpg') }}" width="30" height="30" alt="">
                                    <span class="ml-1">Car</span></td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td>8</td>
                                <td>300</td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-success">Won</span></td>
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
<td>Halan</td>
                                <td>
                                    <img src="{{ asset('public/admin/global_assets/images/car.jpg') }}" width="30" height="30" alt="">
                                    <span class="ml-1">Car</span></td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td>8</td>
                                <td>300</td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-success">Won</span></td>
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
<td>Halan</td>
                                <td>
                                    <img src="{{ asset('public/admin/global_assets/images/car.jpg') }}" width="30" height="30" alt="">
                                    <span class="ml-1">Car</span></td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td>8</td>
                                <td>300</td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-success">Won</span></td>
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
<td>Halan</td>
                                <td>
                                    <img src="{{ asset('public/admin/global_assets/images/car.jpg') }}" width="30" height="30" alt="">
                                    <span class="ml-1">Car</span></td>
                                <td>Abscee</td>
                                <td>Milky Auction House</td>
                                <td>8</td>
                                <td>300</td>
                                <td><span class="badge badge-success">Complete</span></td>
                                <td><span class="badge badge-success">Won</span></td>
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
