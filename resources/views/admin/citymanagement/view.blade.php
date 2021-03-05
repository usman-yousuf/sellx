@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - City Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> City Management</a>
                            <span class="breadcrumb-item active">All Cities</span>
                            <span class="breadcrumb-item active">View City</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            <div class="content">

                <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">
                                <a class="collapsed text-default" data-toggle="collapse" href="#collapsible-controls-group1"><b>City's Detail</b></a>
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
                            <div class="">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{$data->name ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Country Code</th>
                                                            <td>{{$data->country_code ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>District</th>
                                                            <td>{{$data->district ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Population</th>
                                                            <td>{{$data->population ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Updated At</th>
                                                            <td>{{$data->updated_at ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created At</th>
                                                            <td>{{$data->created_at ?? 'not set'}}</td>
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
            <!-- /content area -->

@endsection