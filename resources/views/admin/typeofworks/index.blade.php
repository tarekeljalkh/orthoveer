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
                                <a href="{{ route('admin.type-of-works.create') }}" class="btn btn-success">Create New <i class="fas fa-plus"></i></a>
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
                                            <th>Price with TVA</th>
                                            <th>My Price</th>
                                            <th>Cash Out</th>
                                            <th>My Benefit</th>
                                            <th>Accessories</th>
                                            <th>Special Price for Doctor</th>
                                            <th>{{ trans('messages.lab') }}</th>
                                            <th>{{ trans('messages.lab_due_date') }}</th>
                                            <th>{{ trans('messages.second_lab') }}</th>
                                            <th>{{ trans('messages.second_lab_due_date') }} </th>
                                            <th>{{ trans('messages.external_lab') }}</th>
                                            <th>{{ trans('messages.external_lab_due_date') }} </th>
                                            <th>{{ trans('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($typeofworks as $typeofwork)
                                            <tr>
                                                <td>{{ $typeofwork->id }}</td>
                                                <td>{{ $typeofwork->name }}</td>
                                                <td>{{ $typeofwork->lab_price }} {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->price_with_tva }} {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->my_price }} {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->cash_out }} {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->my_benefit }} {{ config('settings.site_currency_icon') }}</td>
                                                <td>{{ $typeofwork->accessories }} {{ config('settings.site_currency_icon') }}</td>
                                                <td>
                                                    @if($typeofwork->doctorPrices->isNotEmpty())
                                                        @foreach($typeofwork->doctorPrices as $doctorPrice)
                                                            <div class="badge badge-info">{{ $doctorPrice->doctor->first_name }} {{ $doctorPrice->doctor->last_name }}: {{ $doctorPrice->price }} {{ config('settings.site_currency_icon') }}</div><br>
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-danger">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-primary">{{ $typeofwork->lab->first_name }}</span>
                                                </td>
                                                <td>{{ $typeofwork->lab_due_date }}</td>
                                                <td>
                                                    @if ($typeofwork->secondLab)
                                                        <span class="badge badge-primary">{{ $typeofwork->secondLab->first_name }}</span>
                                                    @else
                                                        No Secondary Lab
                                                    @endif
                                                </td>
                                                <td>{{ $typeofwork->second_lab_due_date }} </td>
                                                <td>
                                                    @if ($typeofwork->externalLab)
                                                        <span class="badge badge-primary">{{ $typeofwork->externalLab->first_name }}</span>
                                                    @else
                                                        No External Lab
                                                    @endif
                                                </td>
                                                <td>{{ $typeofwork->external_lab_due_date }}</td>
                                                <td>
                                                    <a href="{{ route('admin.type-of-works.edit', $typeofwork->id) }}" class="btn btn-primary">Edit</a>
                                                    <a href="{{ route('admin.type-of-works.destroy', $typeofwork->id) }}" class="btn btn-danger delete-item">Delete</a>
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
