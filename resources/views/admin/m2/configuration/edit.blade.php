@extends('admin.layouts.app')

@section('title')
    Configurations
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
                        <h4 class="m-0 text-dark">Configurations</h4>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item">Personal Training</li>
                            <li class="breadcrumb-item active">Configurations</li>
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
                            <form method="POST" action="{{ route('admin.m2.configurations.update', [$setting]) }}" role="form" id="form" class="needs-validation">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <h6 class="mb-2 mt-0">General</h6>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>No. of Class Per Slot</label>
                                                <input type="text" name="m2_num_classes_per_slot" value="{{ $setting->m2_num_classes_per_slot }}"
                                                       class="form-control @error('m2_num_classes_per_slot') is-invalid @enderror">

                                                @error('m2_num_classes_per_slot')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Duration (In Minutes)</label>
                                                <input type="number" name="duration" value="{{ $class->duration }}" class="form-control @error('duration') is-invalid @enderror">

                                                @error('duration')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Duration Label</label>
                                                <input type="text" name="duration_label" value="{{ $class->duration_label }}" class="form-control @error('duration_label') is-invalid @enderror">

                                                @error('duration_label')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <h6 class="mb-2 mt-3">Member</h6>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Individual PT Price</label>
                                                <input type="text" name="m2_individual_price" value="{{ $setting->m2_individual_price }}" class="form-control @error('m2_individual_price') is-invalid @enderror">

                                                @error('m2_individual_price')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Couple PT Price</label>
                                                <input type="text" name="m2_couple_price" value="{{ $setting->m2_couple_price }}" class="form-control @error('m2_couple_price') is-invalid @enderror">

                                                @error('m2_couple_price')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <h6 class="mb-2 mt-3">Coach</h6>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Individual PT Price</label>
                                                <input type="text" name="m2_coach_individual_price" value="{{ $setting->m2_coach_individual_price }}"
                                                       class="form-control @error('m2_coach_individual_price') is-invalid @enderror">

                                                @error('m2_coach_individual_price')
                                                <div class="invalid-feedback">
                                                    This field is required
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Couple PT Price</label>
                                                <input type="text" name="m2_coach_couple_price" value="{{ $setting->m2_coach_couple_price }}" class="form-control @error('m2_coach_couple_price') is-invalid @enderror">

                                                @error('m2_coach_couple_price')
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
