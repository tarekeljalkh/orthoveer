@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>External Labs</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">External Labs</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All External Labs</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.external_labs.create') }}" class="btn btn-success">Create New <i class="fas fa-plus"></i></a>
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
                                            <th>Status</th>
                                            <th>Email Verified</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($external_labs as $external_lab)
                                            <tr onclick="window.location='{{ route('admin.external_labs.show', $external_lab->id) }}';"
                                                style="cursor:pointer;">
                                                <td>{{ $external_lab->first_name }}</td>
                                                <td>{{ $external_lab->last_name }}</td>
                                                <td>{{ $external_lab->email }}</td>
                                                <td>{{ $external_lab->image }}</td>
                                                <td>{{ $external_lab->mobile }}</td>
                                                <td>{{ $external_lab->landline }}</td>
                                                <td>{{ $external_lab->address }}</td>
                                                <td>{{ $external_lab->postal_code }}</td>
                                                <td>{{ $external_lab->siret_number }}</td>
                                                <td>
                                                    <div
                                                        class="badge
                                                    {{ $external_lab->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $external_lab->status }}
                                                    </div>
                                                </td>
                                                <td>{{ $external_lab->email_verified_at }}</td>
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
