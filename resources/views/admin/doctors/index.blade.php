@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Doctors</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Doctors</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Doctors</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">Create New <i
                                        class="fas fa-plus"></i></a>
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
                                            <th>Landline</th>
                                            <th>Address</th>
                                            <th>Postal Code</th>
                                            <th>Siret Number</th>
                                            <th>Email Verified</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($doctors as $doctor)
                                            <tr>
                                                <td>{{ $doctor->first_name }}</td>
                                                <td>{{ $doctor->last_name }}</td>
                                                <td>{{ $doctor->email }}</td>
                                                <td><img style="width: 50px" src="{{ asset($doctor->image) }}"></td>
                                                <td>{{ $doctor->mobile }}</td>
                                                <td>{{ $doctor->landline }}</td>
                                                <td>{{ $doctor->address }}</td>
                                                <td>{{ $doctor->postal_code }}</td>
                                                <td>{{ $doctor->siret_number }}</td>
                                                @if ($doctor->email_verified_at)
                                                    <td>
                                                        <div class="badge badge-success">Yes</div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="badge badge-danger">No</div>
                                                    </td>
                                                @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-primary">Edit</a>
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
