@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Refund Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Refund Management</a>
                            <span class="breadcrumb-item active">Refund</span>
                            <span class="breadcrumb-item active">Edit Refund</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->

            <div class="content">

                <div class="card-body">

                    <form id="create_category" action="{{ route('admin.refund.update', $refund_data->uuid) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="refund_user_name">User Name</label>
                                                <input type="text" placeholder="" id="txt_name-d" name="refund_user_name" value="{{$profile->username ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="refund_user_name">Refund Amount</label>
                                                <input type="text" placeholder="" id="refund_amount-d" name="refund_amount" value="{{$refund_data->refund_amount ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="refund_date">Refund Request Date</label>
                                                <input type="text" placeholder="date" id="date-d" name="refund_date" value="{{$refund_data->created_at ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <h6><label>Status</label></h6>
                                        <select data-placeholder="Select a State..." class="form-control form-control-lg select" name="is_approved" data-container-css-class="select-lg" data-fouc>
                                                <option value="1" name="is_approved" data-fouc>Approved</option>
                                                <option value="0" name="is_approved" data-fouc>Unapproved</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <h5 class="ml-2">Account Details</h5>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="account_holder">Account Holder</label>
                                                <input type="text" placeholder="Iso" id="txt_name-d" name="account_holder" value="{{$refund_data->name ?? 'No Name'}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="iban_number">Iban Number</label>
                                                <input type="text" placeholder="Iso" id="txt_name-d" name="iban_number" value="{{$refund_data->iban ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="branch_address">Branch Address</label>
                                                <input type="text" placeholder="Iso" id="txt_name-d" name="branch_address" value="{{$refund_data->branch_address ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="branch_code">Branch Code</label>
                                                <input type="number" placeholder="Iso" id="txt_name-d" name="branch_code" value="{{$refund_data->branch_code ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="text-right">
                            <input type="hidden" name='id' id='country_id' value="" />
                            <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>

                </div>

            </div>
            <!-- /content area -->

@endsection
