@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ trans('messages.labs') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">{{ trans('messages.labs') }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('messages.labs') }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.labs.create') }}"
                                    class="btn btn-success">{{ trans('messages.create_new') }} <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="labs" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('messages.id') }}</th>
                                            <th>{{ trans('messages.first_name') }}</th>
                                            <th>{{ trans('messages.last_name') }}</th>
                                            <th>{{ trans('messages.email') }}</th>
                                            <th>{{ trans('messages.email_verified') }}</th>
                                            <th>{{ trans('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($labs as $lab)
                                            <tr>
                                                <td>{{ $lab->id }}</td>
                                                <td>{{ $lab->first_name }}</td>
                                                <td>{{ $lab->last_name }}</td>
                                                <td>{{ $lab->email }}</td>
                                                @if ($lab->email_verified_at)
                                                    <td>
                                                        <div class="badge badge-success">{{ trans('messages.yes') }}</div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="badge badge-danger">{{ trans('messages.no') }}</div>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('admin.labs.edit', $lab->id) }}"
                                                        class="btn btn-primary">{{ trans('messages.edit') }}</a>

                                                    <a href="{{ route('admin.labs.destroy', $lab->id) }}"
                                                        class="btn btn-danger delete-item">{{ trans('messages.delete') }}</a>

                                                    @if ($lab->labScans->isNotEmpty())
                                                        <a href="{{ route('admin.labs.show', $lab->id) }}"
                                                            class="btn btn-info">{{ trans('messages.see scans') }}</a>
                                                    @endif

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
        new DataTable('#labs', {
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
