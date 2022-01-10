@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Auctioneer Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Auctioneer Management</a>
                            <span class="breadcrumb-item active">All Auctioneers</span>
                            <span class="breadcrumb-item active">View Auctioneer Details</span>
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
                        Auctioneer's Personal Details
                    </h6>
                    <span class="text-muted d-block"></span>
                    <span class="text-muted d-block"><code>Auctioneer's Profile</code>, <code>Addresses</code>, <code>Localisation Settings</code> & <code>Notification Permission Setting</code></span>
                </div>

                <div class="collapsible-sortable">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">
                                <a data-toggle="collapse" class="text-default" href="#collapsible-controls-group1"><b>Auctioneer's Profile</b></a>
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
                                                    @if ($user->profile_image)
                                                        <img class="img-fluid rounded-circle" src="{{ asset('assets/images/').'/'.$user->profile_image}}" width="170" height="170">
                                                    @elseif (!$user->profile_image)
                                                        <img class="img-fluid rounded-circle" src="{{ asset('assets/images/attachment.png')}}" width="170" height="170">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Auction House Name</th>
                                                                    <td>{{$user->auction_house_name ?? 'No name'}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Profile Type</th>
                                                                    <td>{{$user->profile_type ?? 'no type'}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status</th>
                                                                    @if($user->is_approved == 1)
                                                                        <td><span class="badge badge-success">Approved</span></td>
                                                                    @elseif($user->is_approved == 0)
                                                                        <td><span class="badge badge-danger">Unapproved</span></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Category</th>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col">{{$category->name ?? ''}}</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td>{{$user->email ?? ''}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone code</th>
                                                                    <td>{{$user->phone_code ?? ''}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone Number</th>
                                                                    <td>{{$user->phone_number ?? ''}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Social Login</th>
                                                                    @if($user->is_social == 1)
                                                                        <td><span class="badge badge-success">Yes</span></td>
                                                                    @elseif($user->is_social == 0)
                                                                        <td><span class="badge badge-danger">No</span></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Social Platform</th>
                                                                    @if($user->social_type != null)
                                                                        <td>{{$user->social_type}}</td>
                                                                    @elseif($user->social_type == null)
                                                                        <td>Empty</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Social Email</th>
                                                                    @if($user->social_email != null)
                                                                        <td>{{$user->social_email}}</td>
                                                                    @elseif($user->social_email == null)
                                                                        <td>Empty</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <th>Social ID</th>
                                                                    @if($user->social_id != null)
                                                                        <td>{{$user->social_id}}</td>
                                                                    @elseif($user->social_id == null)
                                                                        <td>Empty</td>
                                                                    @endif
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
                                        @forelse($user->addresses as $address)
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-striped">
                                                        <div><h6><label><b>Address# {{$loop->iteration}}</b></label></h6></div>
                                                        <tbody>
                                                            <tr>
                                                                <th>Address Name</th>
                                                                <td>{{$address->address_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Reciever Name</th>
                                                                <td>{{$address->reciever_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone Code</th>
                                                                <td>{{$address->phone_code}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone Number</th>
                                                                <td>{{$address->phone_number}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address 1</th>
                                                                <td>{{$address->address1}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address 2</th>
                                                                <td>{{$address->address2}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Zip</th>
                                                                <td>{{$address->zip}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>State</th>
                                                                <td>{{$address->state}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>City</th>
                                                                <td>{{$address->city}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Country</th>
                                                                <td>{{$address->countryInfo->nicename ?? 'not set'}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Latitude</th>
                                                                <td>{{$address->latitude}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Longitude</th>
                                                                <td>{{$address->longitude}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Default Address</th>
                                                                @if($address->is_default == 1)
                                                                    <td><span class="badge badge-success">Yes</span></td>
                                                                @elseif($address->is_default == 0)
                                                                    <td><span class="badge badge-danger">No</span></td>
                                                                @endif
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-striped">
                                                        <div><h6><label><b>No Address Found</b></label></h6></div>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">
                                <a class="collapsed text-default" data-toggle="collapse" href="#collapsible-controls-group3"><b>Localisation Settings</b></a>
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

                        <div id="collapsible-controls-group3" class="collapse">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Currency</th>
                                                            <td>
                                                                {{$user->LocalisationSetting->currency->code ?? 'not set'}}
                                                                <br />
                                                                {{$user->LocalisationSetting->currency->name ?? 'not set'}}
                                                                <br />
                                                                {{$user->LocalisationSetting->currency->symbol ?? 'not set'}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Country</th>
                                                            <td>{{$user->LocalisationSetting->country->nicename ?? 'not set'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Language</th>
                                                            <td>{{$user->LocalisationSetting->language->name ?? 'not set'}}</td>
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

                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">
                                <a class="collapsed text-default" data-toggle="collapse" href="#collapsible-controls-group4"><b>Notification Permission Settings</b></a>
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

                        <div id="collapsible-controls-group4" class="collapse">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Emails Enable</th>
                                                            <td>
                                                                @if($user->notificationpermissions->is_email_enable == 1)
                                                                    <span class="badge badge-success">Yes</span>
                                                                @elseif($user->notificationpermissions->is_email_enable == 0)
                                                                    <span class="badge badge-danger">No</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Push Notifications Enable</th>
                                                            <td>
                                                                @if($user->notificationpermissions->is_push_enable == 1)
                                                                    <span class="badge badge-success">Yes</span>
                                                                @elseif($user->notificationpermissions->is_push_enable == 0)
                                                                    <span class="badge badge-danger">No</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>SMS Enable</th>
                                                            <td>
                                                                @if($user->notificationpermissions->is_sms_enable == 1)
                                                                    <span class="badge badge-success">Yes</span>
                                                                @elseif($user->notificationpermissions->is_sms_enable == 0)
                                                                    <span class="badge badge-danger">No</span>
                                                                @endif
                                                            </td>
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
                <!-- /collapsible with controls -->





            </div>
            <!-- /content area -->

@endsection
