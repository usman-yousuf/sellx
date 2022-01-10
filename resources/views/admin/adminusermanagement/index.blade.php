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
                        <h5 class="card-title">All Users Profile Listing</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        You can <code>Search</code>, <code>View</code> & <code>Delete</code> the specific User from here.
                    </div>
                     <div class="text-right text-white mr-3">
                        <a href="{{route('admin.adminusers.add')}}" role="button" type="submit" class="btn btn-primary">Add User<i class="fa fa-user-plus ml-2"></i></a>
                    </div>

                    <table class="table datatable-show-all">
                        <thead>
                            <tr>
                                <th>ID#</th>
                                <!-- {{-- <th>Image</th> --}} -->
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>UserName</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            @foreach($user->profiles as $profile)
                            <tr>
                                <td>{{$user->id ?? ''}}</td>
                                <td><span class="ml-1">{{$profile->first_name ?? 'no name'}}</span></td>
                                <td><span class="ml-1">{{$profile->last_name ?? 'no  name'}}</span></td>
                                <td>{{$user->name ?? ''}}</td>
                                <td><a href="javascript:(void)">{{$user->role ?? ''}}</a></td>
                                <!-- @if($user->is_approved == 1)
                                    <td><span class="badge badge-success">Approved</span></td>
                                @elseif($user->is_approved == 0)
                                    <td><span class="badge badge-danger">Unapproved</span></td>
                                @endif  -->
                                <td>{{$user->email ?? ''}}</td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{route('admin.adminusers.view', $user->uuid)}}" class="dropdown-item"><i class="icon-eye2"></i> View</a>
                                                <a href="{{route('admin.adminusers.update.view.form', $user->uuid)}}" class="dropdown-item"><i class="icon-pencil3"></i> Update</a>
                                                <a href="{{route('admin.adminusers.delete', $user->uuid)}}" class="dropdown-item"><i class="icon-trash-alt"></i> Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                </tr>
                                @endforeach
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
