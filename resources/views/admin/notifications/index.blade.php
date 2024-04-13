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
                                        <th>Scan Id</th>
                                        <th>Date</th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications->groupBy('scan_id') as $scanId => $notificationsGroup)
                                    <tr>
                                        <td>{{ $scanId }}</td>

                                        <td>
                                            @foreach ($notificationsGroup as $notification)
                                            {{ $notification->created_at->format('d/m/Y') }} <br>
                                        @endforeach

                                            {{-- {{ $notificationsGroup->first()->created_at->format('d/m/Y') }} --}}
                                        </td>
                                        <td>
                                            <!-- Display sender details here -->
                                            @foreach ($notificationsGroup as $notification)
                                                Sender: {{ $notification->sender->first_name }}, {{ $notification->sender->last_name }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <!-- Display receiver details here -->
                                            @foreach ($notificationsGroup as $notification)
                                                Receiver: {{ $notification->receiver->first_name }}, {{ $notification->receiver->last_name }} <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($notificationsGroup as $notification)
                                                @if ($notification->scan->latestStatus)
                                                    {{ $notification->scan->latestStatus->status }} <br>
                                                @else
                                                    N/A <br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($notificationsGroup as $notification)
                                                @if ($notification->scan->latestStatus)
                                                    {{ $notification->scan->latestStatus->note }} <br>
                                                @else
                                                    N/A <br>
                                                @endif
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
