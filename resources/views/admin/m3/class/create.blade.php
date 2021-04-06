@extends('admin.layouts.app')

@section('title')
    Create
@endsection

@section('header')
    @parent

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class=" content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">Create</h4>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item">Group Class</li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.m3.classes.index') }}">Classes</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card card-primary card-outline">
                            <!-- form start -->
                            <form method="POST" action="{{ route('admin.m3.classes.store') }}" role="form" autocomplete="off" enctype="multipart/form-data" id="form" class="needs-validation">
                                @csrf

                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-2">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="" onerror="this.onerror=null; this.src='{{ asset('themes/AdminLTE/dist/img/default-1000x1000.png') }}';" id="profile_img" class="rounded mb-2" width="300"
                                                     height="auto" alt=""/>

                                                <div class="w-100 d-flex" style="justify-content: space-evenly">
                                                    <a class="btn btn-sm btn-primary" onclick="$('.js-image-upload').click();">
                                                        <i class="fa fa-upload mr-1"></i> Set Image
                                                    </a>
                                                </div>

                                                <input type="file" name="image" class="js-image-upload form-control d-none" accept='.jpg, .jpeg, .png'
                                                       onchange="document.getElementById('profile_img').src = window.URL.createObjectURL(this.files[0]);"/>

                                                @error('image')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                                                @error('name')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No. of Seats</label>
                                                <input type="number" name="num_seats" value="{{ old('num_seats') }}" min="0" class="form-control @error('num_seats') is-invalid @enderror">

                                                @error('num_seats')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Duration (In Minutes)</label>
                                                <input type="number" name="duration" value="{{ old('duration') }}" min="0" class="form-control @error('duration') is-invalid @enderror">

                                                @error('duration')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Duration Label</label>
                                                <input type="text" name="duration_label" value="{{ old('duration_label') }}" class="form-control @error('duration_label') is-invalid @enderror">

                                                @error('duration_label')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Seat Price</label>
                                                <input type="text" name="seat_price" value="{{ old('seat_price') }}" min="0" class="form-control @error('seat_price') is-invalid @enderror">

                                                @error('seat_price')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Floor Price</label>
                                                <input type="text" name="floor_price" value="{{ old('floor_price') }}" min="0" class="form-control @error('floor_price') is-invalid @enderror">

                                                @error('floor_price')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>App Visibility</label>
                                                <select name="app_visibility" class="form-control @error('app_visibility') is-invalid @enderror">
                                                    <option value="">Select App Visibility</option>
                                                    <option value="1" {{ old('app_visibility') == '1' ? 'selected' : null }}>Show</option>
                                                    <option value="0" {{ old('app_visibility') == '0' ? 'selected' : null }}>Hide</option>
                                                </select>

                                                @error('app_visibility')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                                    <option value="">Select Status</option>
                                                    <option value="1" {{ old('status') == '1' ? 'selected' : null }}>Active</option>
                                                    <option value="0" {{ old('status') == '0' ? 'selected' : null }}>Inactive</option>
                                                </select>

                                                @error('status')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!-- /.row -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm bg-gradient-primary float-right"><i class="fas fa-save"></i>&nbsp; Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('footer')
    @parent

@endsection
