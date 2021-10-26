@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Auctions</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Auction Management</a>
                            <span class="breadcrumb-item active">Auction</span>
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
                                <a data-toggle="collapse" class="text-default" href="#collapsible-controls-group1"><b>Edit Auction</b></a>
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
                                                           <form action="">
                                                               @csrf
                                                                <tbody>
                                                                <tr>
                                                                    <th>Auction Name</th>
                                                                    <td>
                                                                        <input type="text" class="form-control" id="user_name">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Auction House</th>
                                                                    <td>
                                                                        <input type="number" class="form-control" id="deposit_amount">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Category</th>
                                                                    <td>
                                                                        <input type="text" class="form-control" id="category">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Auction Date</th>
                                                                    <td>
                                                                        <input type="dateTime" class="form-control" id="date">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status</th>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <select data-placeholder="Select a State..." class="form-control form-control-lg select" name="is_approved" data-container-css-class="select-lg" data-fouc>
                                                                                    <option value="0" name="is_approved">complete</option>
                                                                                    <option value="1" name="is_approved">pending</option>
                                                                                    <option value="2" name="is_approved">upcoming</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    <td>
                                                                        <div class="text-right">
                                                                            <a href="{{ route('admin.deposit') }}" role="button" type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                           </form>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-6">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td>{{$user->user->email}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone code</th>
                                                                    <td>{{$user->user->phone_code}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone Number</th>
                                                                    <td>{{$user->user->phone_number}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Social Login</th>
                                                                    @if($user->user->is_social == 1)
                                                                        <td><span class="badge badge-success">Yes</span></td>
                                                                    @elseif($user->user->is_social == 0)
                                                                        <td><span class="badge badge-danger">No</span></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Social Platform</th>
                                                                    @if($user->user->social_type != null)
                                                                        <td>{{$user->user->social_type}}</td>
                                                                    @elseif($user->user->social_type == null)
                                                                        <td>Empty</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Social Email</th>
                                                                    @if($user->user->social_email != null)
                                                                        <td>{{$user->user->social_email}}</td>
                                                                    @elseif($user->user->social_email == null)
                                                                        <td>Empty</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Social ID</th>
                                                                    @if($user->user->social_id != null)
                                                                        <td>{{$user->user->social_id}}</td>
                                                                    @elseif($user->user->social_id == null)
                                                                        <td>Empty</td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /page length options -->

            </div>
            <!-- /content area -->

@endsection
