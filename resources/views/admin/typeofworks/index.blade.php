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
                                <table id="typeofWorks" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('messages.id') }}</th>
                                            <th>{{ trans('messages.name') }}</th>
                                            <th>Lab Price</th>
                                            <th>Bag Coule</th>
                                            <th>My Price</th>
                                            <th>Invoice To</th>
                                            <th>Cash Out</th>
                                            <th>My Benefit</th>
                                            <th>Accessories</th>
                                            <th>{{ trans('messages.lab') }}</th>
                                            <th>Second Lab</th>
                                            <th>{{ trans('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($typeofworks as $typeofwork)
                                            <tr>
                                                <td>{{ $typeofwork->id }}</td>
                                                <td>{{ $typeofwork->name }}</td>
                                                <td>{{ $typeofwork->lab_price }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->bag_coule }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->my_price }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->invoice_to }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->cash_out }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->my_benefit }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->accessories }}
                                                    {{ config('settings.site_currency_icon') }}</td>
                                                <td>
                                                    <span class="badge badge-primary">{{ $typeofwork->lab->first_name }}</span>
                                                </td>
                                                <td>
                                                    @if ($typeofwork->secondLab)
                                                    <span class="badge badge-primary">{{ $typeofwork->secondLab->first_name }}</span>
                                                @else
                                                    No Secondary Lab
                                                @endif
                                                                                            </td>
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
        new DataTable('#typeofWorks', {
            layout: {
                topStart: {
                    buttons: [
                        'excel',
                        'pdf',
                        'print',
                    ]
                }
            },
            select: true
        });
    </script>
@endpush
