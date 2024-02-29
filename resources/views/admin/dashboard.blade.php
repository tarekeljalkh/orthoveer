@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Welcome Admin</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Doctors</h4>
                        </div>
                        <div class="card-body">
                            {{ $doctors }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-flask"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Labs</h4>
                        </div>
                        <div class="card-body">
                            {{ $labs }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-vials"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>External Labs</h4>
                        </div>
                        <div class="card-body">
                            {{ $external_labs }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
        </div>
    </section>
@endsection
