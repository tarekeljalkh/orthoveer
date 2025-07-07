@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ __('messages.create_invoice') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('messages.invoice') }}</div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('admin.invoices.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    {{-- Invoice Details --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('messages.invoice_details') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">


                                    <div class="form-group col-md-6">
                                        <label for="user_id">{{ __('messages.created_by_user') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="user_id" class="form-control select2" required>
                                            <option value="">{{ __('messages.choose') }}</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }}
                                                    {{ $user->last_name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="doctor_id">{{ __('messages.doctors') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="doctor_id" class="form-control select2" required>
                                            <option value="">{{ __('messages.choose') }}</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->first_name }}
                                                    {{ $doctor->last_name }} ({{ $doctor->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>



                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('messages.invoice_date') }}</label>
                                        <input type="date" name="invoice_date" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('messages.due_date') }}</label>
                                        <input type="date" name="due_date" class="form-control">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('messages.total_amount') }} <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="total_amount" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="status">{{ __('messages.status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="unpaid" selected>{{ __('messages.unpaid') }}</option>
                                            <option value="paid">{{ __('messages.paid') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.payment_method') }}</label>
                                    <input type="text" name="payment_method" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.notes') }}</label>
                                    <textarea name="notes" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.upload_invoice_pdf') }}</label>
                                    <input type="file" name="pdf_path" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="scans">{{ __('messages.attach_scans') }}</label>
                                    <select name="scans[]" id="scans" class="form-control select2" multiple>
                                        @foreach ($scans as $scan)
                                            <option value="{{ $scan->id }}">Scan #{{ $scan->id }} -
                                                {{ $scan->created_at->format('d/m/Y') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">{{ __('messages.create_invoice') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
