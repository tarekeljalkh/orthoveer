@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Notifications</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Notifications</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Notifications</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="notifications" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Scan Id</th>
                                            <th>Sender</th>
                                            <th>receiver</th>
                                            <th>Scan Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr>
                                                <td>{{ $notification->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $notification->scan_id }}</td>
                                                <td>
                                                    @if ($notification->sender->role == 'doctor')
                                                        DR. {{ $notification->sender->first_name }}
                                                        {{ $notification->sender->last_name }}
                                                    @elseif($notification->sender->role == 'lab')
                                                        LAB. {{ $notification->sender->first_name }}
                                                        {{ $notification->sender->last_name }}
                                                    @elseif($notification->sender->role == 'external_lab')
                                                        External Lab. {{ $notification->sender->first_name }}
                                                        {{ $notification->sender->last_name }}
                                                    @else
                                                        {{ $notification->sender->first_name }}
                                                        {{ $notification->sender->last_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($notification->receiver->role == 'doctor')
                                                        DR. {{ $notification->receiver->first_name }}
                                                        {{ $notification->receiver->last_name }}
                                                    @elseif($notification->receiver->role == 'lab')
                                                        LAB. {{ $notification->receiver->first_name }}
                                                        {{ $notification->receiver->last_name }}
                                                    @elseif($notification->receiver->role == 'external_lab')
                                                        External Lab. {{ $notification->receiver->first_name }}
                                                        {{ $notification->receiver->last_name }}
                                                    @else
                                                        {{ $notification->receiver->first_name }}
                                                        {{ $notification->receiver->last_name }}
                                                    @endif
                                                </td>
                                                <td>{{ $notification->scan->status }}</td>
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
        new DataTable('#notifications', {
            layout: {
                topStart: {
                    buttons: ['excel', 'pdf', 'print']
                }
            }
        });
    </script>
@endpush
