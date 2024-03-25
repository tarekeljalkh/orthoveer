@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Type of Works</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Type of Works</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Type of Works</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.type-of-works.create') }}" class="btn btn-success">Create New <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Lab</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($typeofworks as $typeofwork)
                                            <tr>
                                                <td>{{ $typeofwork->name }}</td>
                                                <td>{{ $typeofwork->price }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td><span class="badge badge-primary">{{ $typeofwork->lab->first_name }}</span></td>
                                                <td><span class="badge badge-info">{{ $typeofwork->category->name }}</span></td>

                                                <td>
                                                    <a href="{{ route('admin.type-of-works.edit', $typeofwork->id) }}"
                                                        class="btn btn-primary">Edit</a>

                                                    <a href="{{ route('admin.type-of-works.destroy', $typeofwork->id) }}"
                                                        class="btn btn-danger delete-item">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: ['excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
