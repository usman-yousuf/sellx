@extends('layouts.backend')

@section('content')

    <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Admin Dashboard</span> - Country Management</h4>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Country Management</a>
                            <span class="breadcrumb-item active">All Countries</span>
                            <span class="breadcrumb-item active">Update Country</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            <div class="content">

                <div class="card-body">
                    
                    <form id="create_category" action="{{ route('admin.countries.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>

                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="iso">Iso</label>
                                                <input type="text" placeholder="Iso" id="txt_iso-d" name="iso" value="{{$data->iso ?? 'not set'}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" placeholder="Name" id="txt_name-d" name="name" value="{{$data->name ?? 'not set'}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nicename">Nicename</label>
                                                <input type="text" placeholder="Nicename" id="txt_nicename-d" name="nicename" value="{{$data->nicename ?? 'not set'}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="iso3">Iso3</label>
                                                <input type="text" placeholder="Iso3" id="txt_iso3-d" name="iso3" value="{{$data->iso3 ?? 'not set'}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="numcode">Numcode</label>
                                                <input type="text" placeholder="Numcode" id="txt_numcode-d" name="numcode" value="{{$data->numcode ?? 'not set'}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="phonecode">Phonecode</label>
                                                <input type="text" placeholder="Phonecode" id="txt_phonecode-d" name="phonecode" value="{{$data->phonecode ?? 'not set'}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                </fieldset>
                            </div>
                        </div>

                        <div class="text-right">
                            <input type="hidden" name='id' id='country_id' value="{{ $data->id ?? '' }}" />
                            <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>

                </div>

            </div>
            <!-- /content area -->

@endsection