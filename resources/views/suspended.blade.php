@extends('layouts.master2')

@section('content')
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="card text-center p-5">
                        <div class="card-body">
                            <i class="fe fe-lock text-danger" style="font-size:4rem;"></i>
                            <h3 class="mt-3">Account Suspended</h3>
                            <p class="text-muted">
                                {{ $org->name ?? 'Your account' }} has been suspended due to an expired subscription.
                            </p>
                            <div class="alert alert-warning">
                                <strong>To restore access:</strong><br>
                                Pay your subscription renewal and contact us at<br>
                                <strong>support@lipakodi.co.ke</strong>
                            </div>
                            <a href="mailto:support@lipakodi.co.ke" class="btn btn-primary">
                                <i class="fe fe-mail"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
