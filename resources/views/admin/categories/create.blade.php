@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Add New Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></div>
                <div class="breadcrumb-item"><a href="#">Add New Category</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                {{-- Category Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.categories.store') }}" method="post" class="needs-validation"
                            novalidate="">
                            @csrf

                            <div class="card-header">
                                <h4>Add New Category</h4>
                            </div>
                            <div class="card-body">


                                <div class="row">

                                    <div class="form-group col-md-12 col-12">
                                        <label>Category Name</label>
                                        <input type="text" name="name" class="form-control" required="">
                                    </div>

                                </div>

                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Add</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Category Section --}}

            </div>
        </div>
    </section>
@endsection
