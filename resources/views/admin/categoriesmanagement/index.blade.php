@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Category Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Category Management</a>
                            <span class="breadcrumb-item active">All Categories</span>
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
                        <h5 class="card-title">All Categories Listing</h5>

                        <div class="text-center">
                            <a href="{{ route('admin.categories.create_form') }}"><button  type="button" class="btn btn-outline-success btn-float rounded-round"><i class="icon-plus2"></i> Create</button></a>
                        </div>

                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        You can <code>Search</code>, <code>View</code>, <code>Create</code>, <code>Update</code> & <code>Delete</code> the specific Category from here.
                    </div>

                    <table class="table datatable-show-all">
                        <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Slug</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Update at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $info)
                                <tr>
                                    <td>{{$info->id}}</td>
                                    <td>{{$info->slug}}</td>
                                    <td>{{$info->name}}</td>
                                    
                                    @if($info->status == 1)
                                        <td><span class="badge badge-success">Active</span></td>
                                    @elseif($info->status == 0)
                                        <td><span class="badge badge-danger">Inactive</span></td>
                                    @endif

                                    <td>{{$info->updated_at ?? 'not set'}}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{route('admin.categories.view', ['uuid' => $info->uuid])}}" class="dropdown-item"><i class="icon-eye2"></i> View</a>
                                                    <a href="{{route('admin.categories.edit_form', ['uuid' => $info->uuid])}}" class="dropdown-item"><i class="icon-pencil3"></i> Update</a>
                                                    <a href="{{route('admin.categories.delete', ['uuid' => $info->uuid])}}" class="dropdown-item"><i class="icon-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <div class="text-center"><h6><b>No Record Found.</b></h6></div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /page length options -->

            </div>
            <!-- /content area -->

@endsection