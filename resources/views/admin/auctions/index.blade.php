@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Auctions Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Auctions Management</a>
                            <span class="breadcrumb-item active">All Auctions</span>
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
                        <h5 class="card-title">All Auctions Listing</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        You can <code>Search</code>, <code>View</code> & <code>Delete</code> the specific Auction from here.
                    </div>

                    <table class="table datatable-show-all">
                        <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Auction Name</th>
                                <th>Auction House</th>
                                <th>Category</th>
                                <th>Auction DateTime</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($auctions as $auction)
                            
                                @forelse ($auction->auction as $item)
                                
                                    @forelse ($auction->categories as $category)
                                    <tr>
                                        <td>{{$auction->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$auction->auction_house_name}}</td>
                                        <td><a href="#">{{$category->name}}</a></td>
                                        <td>{{$auction->updated_at}}</td> {{-- auction dateTime required delibrately left "$user->updated_at" to keep date time format as it is. --}}
                                        @if($auction->is_approved == 0)
                                            <td><span class="badge badge-danger">Upcoming</span></td>
                                        @elseif($auction->is_approved == 1)
                                            <td><span class="badge badge-success">Complete</span></td>
                                        @elseif($auction->is_approved == 2)
                                            <td><span class="badge badge-primary">Live</span></td>
                                        @endif
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('admin.auctions.edit.auctions.view', ['uuid' => $item->uuid, 'cat_id'=> $category->id]) }}" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                                                        <a href="{{ route('admin.auctions.delete.auctions', ['uuid' => $item->uuid]) }}" class="dropdown-item"><i class="icon-trash-alt"></i> Delete</a>
                                                        <a href="{{ route('admin.auctions.products.detail', ['uuid' => $item->uuid]) }}" class="dropdown-item"><i class="icon-eye2"></i> Detail View</a>
                                                        <a href="javascript:void(0)" class="dropdown-item"><i class="far fa-hand-paper"></i> Stop Auction</a>
                                                        <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-hourglass-start"></i> Start Auction</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                        
                                    @empty
                                        
                                    @endforelse
                                    
                                @empty
                                    
                                @endforelse
                            @empty
                                <div class="text-center"><h6><b>No Record Found.</h6></b><div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /page length options -->

            </div>
            <!-- /content area -->

@endsection
