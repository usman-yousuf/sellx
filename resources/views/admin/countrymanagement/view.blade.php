@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Country Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Country Management</a>
                            <span class="breadcrumb-item active">All Ccountries</span>
                            <span class="breadcrumb-item active">View Country</span>
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
                                <a class="collapsed text-default" data-toggle="collapse" href="#collapsible-controls-group1"><b>Country's Detail</b></a>
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
                                                            <th>Iso</th>
                                                            <td>{{$data->iso ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{$data->name ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nicename</th>
                                                            <td>{{$data->nicename ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Iso3</th>
                                                            <td>{{$data->iso3 ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Numcode</th>
                                                            <td>{{$data->numcode ?? 'not set'}}</td>
                                                        </tr>
                                                         <tr>
                                                            <th>Phonecode</th>
                                                            <td>{{$data->phonecode ?? 'not set'}}</td>
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