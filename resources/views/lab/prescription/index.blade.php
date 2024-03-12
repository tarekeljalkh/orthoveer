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
                <div class="breadcrumb-item"><a href="#">Order</a></div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-8 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>General Informations</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <div class="col-sm-6 col-md-6">
                                    <label for="site-title" class="form-control-label"
                                        style="font-weight: bold;">Patient:</label>
                                    <label for="site-title"
                                        class="form-control-label">{{ $order->patient->first_name }}</label>

                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="site-title" class="form-control-label" style="font-weight: bold;">Graph
                                        Number:</label>
                                    <label for="site-title" class="form-control-label">safasfg</label>
                                </div>
                            </div>

                            <hr>
                            {{-- <div class="live-divider"></div> --}}

                            <div class="form-group row align-items-center">
                                <div class="col-sm-6 col-md-6">
                                    <label for="site-title" class="form-control-label"
                                        style="font-weight: bold;">Doctor:</label>
                                    <label for="site-title" class="form-control-label">Dr. {{ $order->doctor->last_name }},
                                        {{ $order->doctor->first_name }}</label>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group row align-items-center">
                                <div class="col-sm-6 col-md-6">
                                    <label for="site-title" class="form-control-label"
                                        style="font-weight: bold;">Procedure:</label>
                                    <label for="site-title" class="form-control-label">safasfg</label>
                                </div>
                            </div>


                            <hr>
                            <div class="form-group row align-items-center">
                                <div class="col-sm-6 col-md-6">
                                    <label for="site-title" class="form-control-label d-block"
                                        style="font-weight: bold;">Cabinet:</label>
                                    <label for="site-title" class="form-control-label d-block">safasfg</label>
                                    <label for="another-field" class="form-control-label d-block"
                                        style="font-weight: bold;">Delivery Address:</label>
                                    <label for="another-field" class="form-control-label d-block">example</label>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <label for="site-title" class="form-control-label d-block"
                                        style="font-weight: bold;">Scan Date:</label>
                                    <label for="site-title"
                                        class="form-control-label d-block">{{ \Carbon\Carbon::parse($order->scan_date)->format('d/m/Y') }}</label>
                                    <label for="another-field" class="form-control-label d-block"
                                        style="font-weight: bold;">Due Date:</label>
                                    <label for="another-field"
                                        class="form-control-label d-block">{{ \Carbon\Carbon::parse($order->due_date)->format('d/m/Y') }}</label>
                                    <label for="yet-another-field" class="form-control-label d-block"
                                        style="font-weight: bold;">Status:</label>
                                    <label for="yet-another-field"
                                        class="form-control-label d-block">{{ $order->status }}</label>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <label for="site-title" class="form-control-label d-block"
                                        style="font-weight: bold;">Signature:</label>
                                    <label for="site-title" class="form-control-label d-block">safasfg</label>
                                    <label for="another-field" class="form-control-label d-block"
                                        style="font-weight: bold;">License:</label>
                                    <label for="another-field" class="form-control-label d-block">example</label>
                                </div>
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
                            <div class="row">
                                <div class="form-group col-md-8 col-8">
                                    <label>Return Cancel</label>
                                </div>

                                <div class="form-group col-md-4 col-4">
                                    <a href="#" class="btn btn-danger">Return</a>
                                </div>

                            </div>
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
