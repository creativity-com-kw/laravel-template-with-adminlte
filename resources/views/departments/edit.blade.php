@extends('layouts.app')

@section('title')
    Departments
@endsection

@section('header')
    @parent

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('../vendor/almasaeed2010/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../vendor/almasaeed2010/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class=" content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
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
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Edit <small></small></h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('departments.update',[$department]) }}" role="form" id="form" class="needs-validation">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputName">Name</label>
                                        <input type="text" name="name" value="{{ $department->name }}" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Name">

                                        @error('name')
                                        <div class="invalid-feedback">
                                            This field is required
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="inputStatus">Status</label>
                                        <select name="status" class="form-control select2bs4 @error('status') is-invalid @enderror" id="inputStatus" style="width: 100%;">
                                            <option value="">-</option>
                                            <option value="1" {{ $department->status == '1' ? 'selected' : null }}>Active</option>
                                            <option value="0" {{ $department->status == '0' ? 'selected' : null }}>Inactive</option>
                                        </select>

                                        @error('status')
                                        <div class="invalid-feedback">
                                            This field is required
                                        </div>
                                        @enderror
                                    </div>
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

    <!-- Select2 -->
    <script src="{{ asset('../vendor/almasaeed2010/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('../vendor/almasaeed2010/adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('../vendor/almasaeed2010/adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        $(function () {
            // Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // Initialize jQuery validator
            $('#form_').validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    status: {
                        required: true
                    },
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        })
    </script>
@endsection
