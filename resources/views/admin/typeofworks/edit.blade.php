@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Type of Work</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.type-of-works.index') }}">Type of Work</a></div>
                <div class="breadcrumb-item"><a href="#">Edit Type of Work</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                {{-- Type of Work Section --}}
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.type-of-works.update', $typeofwork->id) }}" method="post" class="needs-validation"
                            novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-header">
                                <h4>Edit Type of Works</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $typeofwork->name }}" required="">
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control" value="{{ $typeofwork->price }}" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Select Lab</label>
                                        <select class="form-control select2" name="lab_id">
                                            @foreach ($labs as $lab)
                                                <option @selected($lab->first_name === $typeofwork->lab->first_name) value="{{ $lab->id }}">{{ $lab->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Select Category</label>
                                        <select class="form-control select2" name="category_id">
                                            @foreach ($categories as $category)
                                                <option @selected($category->name === $typeofwork->category->name) value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Update</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                {{-- End Type of Work Section --}}

            </div>
        </div>
    </section>
@endsection
