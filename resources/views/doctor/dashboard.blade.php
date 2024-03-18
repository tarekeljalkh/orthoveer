@extends('doctor.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Welcome Doctor</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Current Cases</h4>
                        </div>
                        <div class="card-body">
                            {{ $currentScans }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pending Casess</h4>
                        </div>
                        <div class="card-body">
                            {{ $pendingScans }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Cases</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalScans }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Rejected Cases</h4>
                        </div>
                        <div class="card-body">
                            {{ $rejectedScans }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="section-body">
        </div>
    </section>
@endsection
