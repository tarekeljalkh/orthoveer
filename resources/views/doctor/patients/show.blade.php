@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('doctor.patients.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Patient: {{ $patient->last_name }}, {{ $patient->first_name }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('doctor.patients.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Patient</div>
            </div>
        </div>
        <div class="section-body">

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-3">
                    <div class="card profile-widget">
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">Patient Name: <div
                                    class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div><a href="{{ route('doctor.patients.edit', $patient->id) }}"><i
                                            class="fas fa-user-edit"></i></a>
                                </div>
                            </div>
                            {{ $patient->last_name }}, {{ $patient->first_name }}
                            <br>
                            <br>
                            <a href="{{ route('doctor.scans.index') }}" class="btn btn-outline-primary">New Scan</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-9">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="">
                            <div class="card-header">
                                <h4>Orders</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Chart Number</th>
                                                <th>Date of Birth</th>
                                                <th>Last Scan Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </form>
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
