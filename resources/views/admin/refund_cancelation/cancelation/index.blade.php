@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Cancelation</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Cancelation Management</a>
                            <span class="breadcrumb-item active">All Cancelation</span>
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
                        <h5 class="card-title">All Cancelation</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        You can <code>Search</code>, <code>View</code> & <code>Delete</code> the specific Cancelation from here.
                    </div>

                    <table class="table datatable-show-all">
                        <thead>
                            <tr>
                                <th>ID#</th>
                                <th>User Name</th>
                                <th>Cancelation Request Date</th>
                                <th>Product Name</th>
                                <th>Paid Amount</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>Shahaan</td>
                                <td><span>2021-06-14</span><span>11:12:13</span></td>
                                <td>Bike</td>
                                <td>$ <span>300</span></td>
                                <td><span class="badge badge-success">Approved</span></td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('admin.cancelation.edit') }}" class="dropdown-item"><i class="icon-pencil3"></i> Eidt</a>
                                                <a href="javascript:void(0)" class="dropdown-item"><i class="icon-trash-alt"></i> Delete</a>
                                                <a href="{{ route('admin.cancelation.detail') }}" class="dropdown-item"><i class="icon-eye2"></i> Detail View</a>
                                                <a href="" class="dropdown-item"><i class="fa fa-check"></i> Status</a>
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
