@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Refund</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Refund Management</a>
                            <span class="breadcrumb-item active">All Refund</span>
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
                        <h5 class="card-title">All Refund</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        You can <code>Search</code>, <code>View</code> & <code>Delete</code> the specific Refund from here.
                    </div>

                    <table class="table datatable-show-all">
                        <thead>
                            <tr>
                                <th>ID#</th>
                                <th>User Name</th>
                                <th>Refund Request Date</th>
                                <th>Refund Amount</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->refundProfile->username ?? 'No Name'}}</td>
                                    <td>{{$item->created_at ?? ''}}</td>
                                    <td>$ <span>{{$item->refund_amount ?? ''}}</span></td>
                                    @if($item->is_approved == 1)
                                        <td><span class="badge badge-success">Approved</span></td>
                                    @elseif($item->is_approved == 0)
                                        <td><span class="badge badge-danger">Unapproved</span></td>
                                    @endif
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{ route('admin.refund.edit', ['uuid' => $item->uuid]) }}" class="dropdown-item"><i class="icon-pencil3"></i> Eidt</a>
                                                    <a href="{{ route('admin.refund.delete', ['uuid' => $item->uuid]) }}" class="dropdown-item"><i class="icon-trash-alt"></i> Delete</a>
                                                    <a href="{{ route('admin.refund.detail', ['uuid' => $item->uuid]) }}" class="dropdown-item"><i class="icon-eye2"></i> Detail View</a>
                                                    <a href="" class="dropdown-item"><i class="fa fa-check"></i> Status</a>
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
