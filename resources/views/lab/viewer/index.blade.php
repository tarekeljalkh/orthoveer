@extends('lab.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('lab.dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Order ID: {{ $order->id }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('lab.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('lab.orders.index') }}">Orders</a></div>
                <div class="breadcrumb-item"><a href="#">{{ $order->id }}</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-8 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <a href="{{ route('lab.orders.downloadStl', $order->id) }}" class="btn btn-primary">Download Files <i class="fas fa-download"></i></a>

                                @if ($order->stl_upper)
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Upper Stl</h4>
                                                <div class="card-header-action">
                                                    <a href="{{ $order->stl_upper }}" download class="btn btn-success">Download <i class="fas fa-download"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="stl_upper" style="width:500px;height:500px;margin:0 auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($order->stl_lower)
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Lower Stl</h4>
                                                <div class="card-header-action">
                                                    <a href="{{ $order->stl_lower }}" download class="btn btn-success">Download <i class="fas fa-download"></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="stl_lower" style="width:500px;height:500px;margin:0 auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($order->pdf)
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Image Or Pdf</h4>
                                            <div class="card-header-action">
                                                <a href="{{ $order->pdf }}" download class="btn btn-success">Download <i class="fas fa-download"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{ $order->pdf }}" style="width:200px;height:200px;margin:0 auto;">
                                        </div>
                                    </div>
                                </div>
                            @endif


                                @if (!$order->stl_upper && !$order->stl_lower)
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>No Stl Available</h4>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Comments ({{ count($order->comments) }})</h4>
                            <div class="card-header-action">
                                <a href="#" data-toggle="modal" data-target="#commentModal"
                                    class="btn btn-success">Add <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="activities">

                                        @foreach ($order->comments as $comment)
                                            <div class="activity">
                                                <div class="activity-icon bg-primary text-white shadow-primary">
                                                    <i class="fas fa-comment-alt"></i>
                                                </div>
                                                <div class="activity-detail">
                                                    <div class="mb-2">
                                                        <span class="text-job text-primary">
                                                            @if ($comment->user->role === 'admin')
                                                                Admin,
                                                            @elseif ($comment->user->role === 'doctor')
                                                                Dr.
                                                            @elseif ($comment->user->role === 'lab')
                                                                Lab,
                                                            @endif
                                                            {{ $comment->user->last_name }},
                                                            {{ $comment->user->first_name }},
                                                        </span>
                                                        <span class="bullet"></span>
                                                        <span
                                                            class="text-job text-info">{{ \Carbon\Carbon::parse($comment->scan_date)->format('d/m/Y') }}</span>
                                                    </div>
                                                    <p>{{ $comment->text }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <form action="{{ route('lab.orders.reject', $order->id) }}" method="post">
                                @csrf
                                @method('post')

                                <div class="row">

                                    <div class="form-group col-md-8 col-8">
                                        <input class="form-control" type="text" name="reject_note"
                                            placeholder="Enter Rejection Note" required>
                                    </div>

                                    <div class="form-group col-md-4 col-4">
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                        {{-- <a href="{{ route('lab.orders.reject', $order->id) }}" class="btn btn-danger">Reject</a> --}}
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>
                </div>

            </div>


        </div>
    </section>



    <div class="modal fade" tabindex="-1" role="dialog" id="commentModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <textarea class="form-control" name="comment" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addCommentButton">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/stl_js/stl_viewer.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var stl_viewer_upper = new StlViewer(
                document.getElementById("stl_upper"), {
                    models: [{
                        id: 1,
                        filename: "{{ asset($order->stl_upper) }}",
                        display: "smooth",
                        color: "#FFC0CB"
                    }]
                }
            );

            var stl_viewer_lower = new StlViewer(
                document.getElementById("stl_lower"), {
                    models: [{
                        id: 2,
                        filename: "{{ asset($order->stl_lower) }}",
                        display: "smooth",
                        color: "#FFC0CB"
                    }]
                }
            );
            stl_viewer.download_model(2, '{{ asset($order->stl_lower) }}');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#addCommentButton').click(function() {
                var formData = new FormData();
                formData.append('comment', $('textarea[name="comment"]').val());
                // Correctly include the order ID in your request
                formData.append('order_id', '{{ $order->id }}');

                $.ajax({
                    url: "{{ route('lab.comments.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Comment added successfully, reload or update the page accordingly
                            window.location.reload();
                        } else {
                            // Handle failure
                            alert("Failed to add comment.");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                        alert("An error occurred.");
                    }
                });
            });
        });
    </script>
@endpush
