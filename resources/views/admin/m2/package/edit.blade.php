@extends('admin.layouts.app')

@section('title')
    Edit
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
                        <h4 class="m-0 text-dark">Edit</h4>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item">Personal Training</li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.m2.packages.index') }}">Packages</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                            <form id="remove-image-form" action="{{ route('admin.m2.packages.image.delete', [$package]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>

                            <!-- form start -->
                            <form method="POST" action="{{ route('admin.m2.packages.update', [$package]) }}" role="form" autocomplete="off" enctype="multipart/form-data" id="form" class="needs-validation">
                                @csrf

                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="{{ $package->image_url }}" onerror="this.onerror=null; this.src='{{ asset('themes/AdminLTE/dist/img/default-1000x500.png') }}';" id="profile_img" class="rounded mb-2" width="300" height="auto"  alt=""/>

                                                <div class="w-100 d-flex" style="justify-content: space-evenly">
                                                    <a class="btn btn-sm btn-primary" onclick="$('.js-image-upload').click();">
                                                        <i class="fa fa-upload mr-1"></i> Set Image
                                                    </a>

                                                    @unless (!$package->image)
                                                        <a class="btn btn-sm btn-danger" onclick="event.preventDefault(); $('#remove-image-form').submit();">
                                                            <i class="fa fa-times mr-1"></i> Remove Image
                                                        </a>
                                                    @endunless
                                                </div>

                                                <input type="file" name="image" class="js-image-upload form-control d-none" accept='.jpg, .jpeg, .png' onchange="document.getElementById('profile_img').src = window.URL.createObjectURL(this.files[0]);"/>

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
                                                <input type="text" name="name" value="{{ $package->name }}" class="form-control @error('name') is-invalid @enderror">

                                                @error('name')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No. of Classes</label>
                                                <input type="number" name="num_classes" value="{{ $package->num_classes }}" min="0" class="form-control @error('num_classes') is-invalid @enderror">

                                                @error('num_classes')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ $package->description }}</textarea>

                                                @error('description')
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
                                                <label>Validity (In Days)</label>
                                                <input type="number" name="validity" value="{{ $package->validity }}" min="0" class="form-control @error('validity') is-invalid @enderror">

                                                @error('validity')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Validity Label</label>
                                                <input type="text" name="validity_label" value="{{ $package->validity_label }}" class="form-control @error('validity_label') is-invalid @enderror">

                                                @error('validity_label')
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
                                                <label>Price</label>
                                                <input type="text" name="price" value="{{ $package->price }}" min="0" class="form-control @error('price') is-invalid @enderror">

                                                @error('price')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Sort Order</label>
                                                <input type="number" name="sort_order" value="{{ $package->sort_order }}" min="0" class="form-control @error('sort_order') is-invalid @enderror">

                                                @error('sort_order')
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
                                                    <option value="1" @if($package->app_visibility == '1') selected @endif>Show</option>
                                                    <option value="0" @if($package->app_visibility == '0') selected @endif>Hide</option>
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
                                                    <option value="1" @if($package->status == '1') selected @endif>Active</option>
                                                    <option value="0" @if($package->status == '0') selected @endif>Inactive</option>
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
                                    <button type="submit" class="btn btn-sm bg-gradient-primary float-right"><i class="fas fa-save"></i>&nbsp; Update</button>
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
