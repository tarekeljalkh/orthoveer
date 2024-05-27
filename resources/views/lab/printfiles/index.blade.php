@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>All Print Files</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">{{ trans('messages.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="#">All Print Files</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Print Files</h4>
                            <div class="card-header-action">
                                <a href="{{ route('lab.printfiles.create') }}" class="btn btn-success">{{ trans('messages.create_new') }} <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="printfiles" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Scan ID</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scans as $scan)
                                        <tr>
                                            <td>{{ $scan->id }}</td>
                                            <td>
                                                @foreach ($scan->printFiles as $printFile)
                                                    <div class="btn-group dropleft">
                                                        <button type="button" class="btn btn-dark dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropleft">
                                                            <a class="dropdown-item" href="{{ route('lab.printfiles.download', $printFile->id) }}"><i class="fas fa-download"></i> Download The File</a>
                                                        </div>
                                                    </div><br>
                                                @endforeach
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
    </section>
@endsection

@push('scripts')
    <script>
        new DataTable('#printfiles', {
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush

