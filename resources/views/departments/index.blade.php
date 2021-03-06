@extends('layouts.app')

@section('title')
    Departments
@endsection

@section('header')
    @parent

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Departments</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Departments</h3>

                                <a href="{{ route('departments.create') }}" class="btn btn-sm bg-gradient-primary float-right"><i class="fas fa-plus"></i>&nbsp; Add New</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 20px">#</th>
                                                <th>Name</th>
                                                <th style="width: 100px" class="text-center">Status</th>
                                                <th style="width: 150px" class="text-center">Options</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($departments as $department)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}.</td>
                                                    <td>{{ $department->name }}</td>
                                                    <td class="text-center">
                                                        @if ($department->status == 1)
                                                            <span class="badge bg-primary">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex justify-content-center">
                                                        <a class="btn btn-primary btn-xs" href="{{ route('departments.edit', [$department]) }}"><i class="fas fa-pencil-alt"></i>&nbsp; Edit</a>
                                                        &nbsp;
                                                        <a class="btn btn-danger btn-xs" href="#" onclick="event.preventDefault(); $('#delete-form-{{ $department->id }}').submit();"><i class="fas fa-trash"></i>&nbsp;
                                                            Delete</a>

                                                        <form method="POST" action="{{ route('departments.destroy', [$department]) }}" id="delete-form-{{ $department->id }}" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center" colspan="4">No records found.</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                {{ $departments->links() }}
                            </div>
                        </div>
                        <!-- /.card -->
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
