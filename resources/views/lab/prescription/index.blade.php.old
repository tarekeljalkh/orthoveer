@extends('lab.layouts.master')

@push('styles')
<style>
    body {
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
    }
    .prescription-container {
        width: 100%;
        margin: 20mm auto;
        background: #ffffff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .prescription-header {
        display: flex;
        justify-content: space-between;
        padding: 20px 0;
    }
    .prescription-header-left,
    .prescription-header-right {
        flex: 1;
    }
    .prescription-header-left {
        text-align: left;
    }
    .prescription-header-right {
        text-align: right;
    }
    .prescription-header-left img {
        max-width: 150px;
        margin-bottom: 10px;
    }
    .prescription-body {
        padding: 20px;
        line-height: 1.5;
        color: #333333;
        text-align: left;
        word-wrap: break-word; /* Ensure long words wrap correctly */
    }
    .prescription-footer {
        text-align: center;
        padding: 10px;
        font-size: 12px;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        .prescription-container,
        .prescription-container * {
            visibility: visible;
        }
        .prescription-container {
            position: fixed;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            width: 100%;
            max-width: 800px;
            margin: 0;
            padding: 0;
        }
        @page {
            size: auto;
            margin: 0mm;
        }
    }
</style>

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Scan ID: {{ $scan->id }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('lab.scans.index') }}">Scans</a></div>
                <div class="breadcrumb-item"><a href="#">Scan</a></div>
            </div>
        </div>

        <div class="section-body">
            <button class="btn btn-primary btn-icon icon-left" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
            <div class="prescription-container">
                <div class="prescription-header">
                    <div class="prescription-header-left">
                        <img src="{{ asset('assets/logo.png')}}" alt="Logo" height="75px">
                        <br><br>
                        <p><strong>ORTHOVEER</strong><br>
                        17 rue du petit Albi<br>
                        95800 Cergy<br>
                        Bloc C2 Porte 203<br>
                        orthoveer@gmail.com<br>
                        0745556967</p>
                    </div>

                    <div class="prescription-header-right">
                        <p><strong>Doctor:</strong><br>
                        {{ $scan->doctor->first_name }} {{ $scan->doctor->last_name }}<br>
                        {{ $scan->doctor->address }}<br>
                        {{ $scan->doctor->email }}<br>
                        {{ $scan->doctor->mobile }}</p>
                    </div>
                </div>
                <div class="prescription-body">
                    <h1>Prescription</h1>
                    <p><strong>Patient:</strong> {{ $scan->patient->first_name }} {{ $scan->patient->last_name }}</p>
                    <p><strong>Date:</strong> {{ $scan->due_date->format('d/m/Y') }}</p>
                    <p><strong>Type Of Work:</strong> {{ $scan->typeofwork->name }}</p>
                    <p><strong>Notes:</strong> {{ $scan->latestStatus->note ?? 'No Note' }}</p>
                    <p><strong>Delivery Date:</strong> {{ \Carbon\Carbon::now()->addDays($scan->typeofwork->lab_due_date)->format('d/m/Y') }}</p>
                </div>
                <div class="prescription-footer">
                    &copy; {{ date('Y') }} Orthoveer. All rights reserved.
                </div>
            </div>
        </div>
    </section>
@endsection
