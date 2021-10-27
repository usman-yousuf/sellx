@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Transfer Amounts Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Transfer Amounts Management</a>
                            <span class="breadcrumb-item active">Transfer Amounts</span>
                            <span class="breadcrumb-item active">Add or Update Transfer Amounts</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            <div class="content">

                <div class="card-body">

                    <form id="create_category" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>

                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Auction House Name</label>
                                                <input type="text" placeholder="Iso" id="txt_name-d" name="auction_name" value="houslie" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Transfer_amount">Transfer Amount</label>
                                                <input type="text" placeholder="Name" id="txt_house_name-d" name="Transfer_amount" value="300" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="date">Auction Date</label>
                                                <input type="text" placeholder="date" id="date-d" name="iso3" value="date" class="form-control">
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
