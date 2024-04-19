@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Welcome Lab Worker</h1>
        </div>
        <div class="row">

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('lab.scans.pending') }}" style="text-decoration:none; color: inherit;">

                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pending Scans</h4>
                            </div>
                            <div class="card-body">
                                {{ $pendingScans }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('lab.scans.index') }}" style="text-decoration:none; color: inherit;">

                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-th-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Completed Scans</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalScans }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('lab.scans.index') }}" style="text-decoration:none; color: inherit;">

                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Wating to Make The Order</h4>
                            </div>
                            <div class="card-body">
                                {{ $waitingScans }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('lab.scans.index') }}" style="text-decoration:none; color: inherit;">

                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Delivered Scans</h4>
                            </div>
                            <div class="card-body">
                                {{ $deliveredScans }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="section-body">
        </div>
    </section>
@endsection
