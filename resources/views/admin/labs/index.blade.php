@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Labs</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Labs</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Labs</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.labs.create') }}" class="btn btn-success">Create New <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Image</th>
                                            <th>Mobile</th>
                                            <th>Email Verified</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($labs as $lab)
                                            <tr onclick="window.location='{{ route('admin.labs.show', $lab->id) }}';"
                                                style="cursor:pointer;">
                                                <td>{{ $lab->first_name }}</td>
                                                <td>{{ $lab->last_name }}</td>
                                                <td>{{ $lab->email }}</td>
                                                <td><img style="width: 50px" src="{{ asset($lab->image) }}"></td>
                                                <td>{{ $lab->mobile }}</td>
                                                @if ($lab->email_verified_at)
                                                    <td>
                                                        <div class="badge badge-success">Yes</div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="badge badge-danger">No</div>
                                                    </td>
                                                @endif
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
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
