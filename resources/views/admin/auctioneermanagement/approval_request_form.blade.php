@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Approval Request Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Approval Request Management</a>
                            <span class="breadcrumb-item">All Approval Requests</span>
                            <span class="breadcrumb-item active">Auction House Approval Requests</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            <div class="content">

                <div class="card-body">
                    <form action="{{ route('admin.auctioneer.update_approval_request', ['uuid' => $user->uuid]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <h6><label>Request Status</label></h6>
                                <select data-placeholder="Select a State..." class="form-control form-control-lg select" name="is_approved" data-container-css-class="select-lg" data-fouc>
                                        <option value="1" name="is_approved"  {{ $user->is_approved == '1' ? 'selected' : '' }} data-fouc>Approved</option>
                                        <option value="0" name="is_approved" {{ $user->is_approved == '0' ? 'selected' : '' }} data-fouc>Unapproved</option>
                                </select>
                            </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /content area -->

@endsection