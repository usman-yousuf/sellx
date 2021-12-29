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
                            <span class="breadcrumb-item active">User</span>
                            <span class="breadcrumb-item active">Add or Update User</span>
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
                                                <label for="name">First Name</label>
                                                <input type="text" placeholder="Iso" id="txt_name-d" name="name" value="Fixess" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Last Name</label>
                                                <input type="text" placeholder="Iso" id="txt_name-d" name="name" value="Fixess" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">User Name</label>
                                                <input type="text" placeholder="Iso" id="txt_name-d" name="name" value="Fixson-hel" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" placeholder="email" id="email-d" name="email" value="admin@admin.com" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" placeholder="password" id="password-d" name="password" value="******" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="confirm_password">Confirm Password</label>
                                                <input type="text" placeholder="confirm password" id="confirm_password-d" name="confirm_password" value="******" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="numcode">Role Type</label>
                                                <select type="text" placeholder="Numcode" id="txt_numcode-d" name="numcode" value="status" class="form-control">
                                                    <option value="1">Admin</option>
                                                    <option value="2">Super Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="img">Image</label>
                                                <input type="file" placeholder="image" id="img-d" name="img" value="" class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <img class="img-fluid rounded-circle" src="{{asset('admin/global_assets/images/user.png')}}" width="170" height="170" alt="">
                                            </div>
                                        </div>
                                    </div> --}}
                                <div class="col-12 mt-3">
                                    <h6>Image</h6>
                                    <div class="w-100 ">
                                        <label for="media12">
                                            <img src="{{ asset('assets/images/upload_img.svg') }}" class="w_inherit-s img-fluid" alt="upload img"/>
                                        </label>
                                         <input id="media12" type="file" name="media"  style="display: none"/>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 media_image-d d-none">
                                    {{-- <img src="{{ asset('assets/images/close.svg') }}" class="remove_img-s position-absolute" alt="remove img"> --}}
                                    <div class="" >
                                        <img class="img-fluid rounded-circle" id="previewImg" src="" width="170" height="170" />
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
