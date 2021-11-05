@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Auction House Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Auction House Management</a>
                            <span class="breadcrumb-item active">Auction House</span>
                            <span class="breadcrumb-item active">View Auction House Details</span>
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
                        Auction House Details
                    </h6>
                    <span class="text-muted d-block"></span>
                    <span class="text-muted d-block"><code>Auction House's Profile</code>, <code>Addresses</code>, <code>Localisation Settings</code> & <code>Notification Permission Setting</code></span>
                </div>

                <div class="collapsible-sortable">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">
                                <a data-toggle="collapse" class="text-default" href="#collapsible-controls-group1"><b>Auction House's Profile</b></a>
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
                                                    <img class="img-fluid rounded-circle" src="{{ asset('admin/global_assets/images/image.png') }}" width="170" height="170" alt="">
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
                                                                    <th>Auction House Name</th>
                                                                    <td>Houslie</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Profile Type</th>
                                                                    <td>Auctioneer</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status</th>
                                                                    <td><span class="badge badge-success">Approved</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Rating</th>
                                                                    <td>3.5</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Reviews</th>
                                                                    <td>12</td>
                                                                </tr>
                                                                 <tr>
                                                                    <th>Email</th>
                                                                    <td>sellx@sellx.com</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone Number</th>
                                                                    <td> <span>+071</span> 328443324832</td>
                                                                </tr>
                                                                 <tr>
                                                                    <th>Credentials</th>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-3">
                                                                                <img src="{{asset('admin/global_assets/images/placeholders/placeholder.jpg')}}" width="60" height="70" alt="">
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <img src="{{asset('admin/global_assets/images/placeholders/placeholder.jpg')}}" width="60" height="70" alt="">
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <img src="{{asset('admin/global_assets/images/placeholders/placeholder.jpg')}}" width="60" height="70" alt="">
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <img src="{{asset('admin/global_assets/images/placeholders/placeholder.jpg')}}" width="60" height="70" alt="">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Category</th>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col">Cars</div>
                                                                            <div class="col">Watches</div>
                                                                            <div class="col">Bikes</div>
                                                                            <div class="col">Phone</div>
                                                                            <div class="col">Watches</div>
                                                                            <div class="col">Bikes</div>
                                                                            <div class="col">Phone</div>
                                                                            <div class="col">Cars</div>
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
                                    {{-- <div class="col-6">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td>sellx@sellx.com</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone code</th>
                                                                    <td>+971</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Phone Number</th>
                                                                    <td>328443324832</td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-11 ml-4">
                                        <h5>Introduction</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempor massa finibus, convallis orci sit amet, cursus mi. Etiam sit amet vulputate eros. Suspendisse potenti. Vivamus a laoreet lorem. Phasellus cursus erat non sagittis accumsan. In ullamcorper, lectus fringilla scelerisque viverra, tortor orci gravida ex, ut imperdiet nibh arcu et magna. Donec varius consectetur magna et porttitor. Nullam porta nec mauris ac ultricies. Ut sagittis ullamcorper malesuada. Vivamus congue augue vel volutpat ultrices.</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-11 ml-4">
                                        <h5>Description</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempor massa finibus, convallis orci sit amet, cursus mi. Etiam sit amet vulputate eros. Suspendisse potenti. Vivamus a laoreet lorem. Phasellus cursus erat non sagittis accumsan. In ullamcorper, lectus fringilla scelerisque viverra, tortor orci gravida ex, ut imperdiet nibh arcu et magna. Donec varius consectetur magna et porttitor. Nullam porta nec mauris ac ultricies. Ut sagittis ullamcorper malesuada. Phasellus in sagittis lorem. Suspendisse potenti. Cras hendrerit pellentesque ex nec commodo. Aliquam accumsan erat sed dignissim sodales. Vivamus congue augue vel volutpat ultrices.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /collapsible with controls -->
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
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-striped">
                                                        <div><h6><label><b>Address #</b></label></h6></div>
                                                        <tbody>
                                                            <tr>
                                                                <th>Address Name</th>
                                                                <td>Auction House</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address</th>
                                                                <td>loorum ipsum, street  34, local post, distt shanchgen</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone Code</th>
                                                                <td>+971</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone Number</th>
                                                                <td>3232434345</td>
                                                            </tr>
                                                            {{-- <tr>
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
                                                            </tr> --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        {{-- @empty
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-striped">
                                                        <div><h6><label><b>No Address Found</b></label></h6></div>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforelse --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- /content area -->

@endsection