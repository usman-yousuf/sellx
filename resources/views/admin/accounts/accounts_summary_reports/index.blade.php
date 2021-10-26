@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Deposits</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Deposit Management</a>
                            <span class="breadcrumb-item active">All Deposits</span>
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
                            <h6 class="card-title">
                                <a data-toggle="collapse" class="text-default" href="#collapsible-controls-group1"><b>Accounts Summary Report</b></a>
                            </h6>

                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="reload"></a>
                                    <a class="list-icons-item" data-action="move"></a>
                                    <a class="list-icons-item" data-action="fullscreen"></a>
                                    <a class="list-icons-item" data-action="remove"></a>
                                </div>
                            </div>
                        </div>

                        <div id="collapsible-controls-group1" class="collapse show">
                            <div class="card">

                                <div class="row">

                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <h5>Summary</h5>
                                                                </tr>
                                                                <tr>
                                                                    <th>Auction House Name</th>
                                                                    <td>houseclo</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total Auctions Completed</th>
                                                                    <td>5</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total Amount</th>
                                                                    <td>$ <span>300</span>/-</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Collected Amount</th>
                                                                    <td>$ <span>250</span>/-</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Service Fee</th>
                                                                    <td>$ <span>30</span>/-</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Transferred Amount</th>
                                                                    <td>$ <span>250</span>/-</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Pending Amount</th>
                                                                    <td>$ <span>50</span>/-</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /page length options -->

            </div>
            <!-- /content area -->

@endsection
