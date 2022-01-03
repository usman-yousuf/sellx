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
                            <span class="breadcrumb-item active">View User Details</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            <div class="content">

               <!-- Collapsible with controls -->
                <div class="mb-3 pt-2">
                    <h6 class="mb-0 font-weight-semibold">
                        Buyer's Personal Details
                    </h6>
                    <span class="text-muted d-block"></span>
                    <span class="text-muted d-block"><code>User's Profile</code>, <code>Addresses</code>, <code>Localisation Settings</code> & <code>Notification Permission Setting</code></span>
                </div>

                <div class="collapsible-sortable">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">
                                <a data-toggle="collapse" class="text-default" href="#collapsible-controls-group1"><b>User's Profile</b></a>
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
                                    <div class="col-sm-12">
                                        <div class="card bg-slate-600" style="background-image: url({{asset('admin/global_assets/images/backgrounds/panel_bg.png')}}); background-size: contain;">
                                            <div class="card-body text-center">
                                                <div class="card-img-actions d-inline-block mb-3">
                                                    {{-- @dd($user_profile->profile_image) --}}
                                                    <img class="img-fluid rounded-circle" src="{{ asset('assets/images/').'/'.$user_profile->profile_image}}" width="170" height="170" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <td>{{$user_profile->first_name ?? ''}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Last Name</th>
                                                                    <td>{{$user_profile->last_name ?? ''}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td>{{$users->email ?? ''}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Date of birth</th>
                                                                    <td>{{$user_profile->dob ?? ''}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Role</th>
                                                                    <td>{{$users->role ?? ''}}</td>
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

                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">
                                <a class="collapsed text-default" data-toggle="collapse" href="#collapsible-controls-group2"><b>Addresses</b></a>
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

                        <div id="collapsible-controls-group2" class="collapse">
                            <div class="">
                                <div class="card-body">
                                    <div class="container">
                                        {{-- @forelse($user->addresses as $address) --}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-striped">
                                                        <div><h6><label><b>Address# {{$loop->iteration ?? ''}}</b></label></h6></div>
                                                        <tbody>
                                                            <tr>
                                                                <th>Address Name</th>
                                                                <td>{{$address->address_name ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Reciever Name</th>
                                                                <td>{{$address->reciever_name ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone Code</th>
                                                                <td>{{$address->phone_code ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone Number</th>
                                                                <td>{{$address->phone_number ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address 1</th>
                                                                <td>{{$address->address1 ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address 2</th>
                                                                <td>{{$address->address2 ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Zip</th>
                                                                <td>{{$address->zip ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>State</th>
                                                                <td>{{$address->state ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>City</th>
                                                                <td>{{$address->city ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Country</th>
                                                                <td>{{$address->countryInfo->nicename ?? 'not set'}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Latitude</th>
                                                                <td>{{$address->latitude ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Longitude</th>
                                                                <td>{{$address->longitude ?? ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Default Address</th>
                                                                {{-- @if($address->is_default == 1) --}}
                                                                    <td><span class="badge badge-success">Yes</span></td>
                                                                {{-- @elseif($address->is_default == 0) --}}
                                                                    <td><span class="badge badge-danger">No</span></td>
                                                                {{-- @endif --}}
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        {{-- @empty --}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-striped">
                                                        <div><h6><label><b>No Address Found</b></label></h6></div>
                                                    </table>
                                                </div>
                                            </div>
                                        {{-- @endforelse --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /collapsible with controls -->





            </div>
            <!-- /content area -->

@endsection
