@extends('layouts.userapp')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">

                <!-- Fixed Header -->
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center sticky-top">
                    <h5 class="mb-0">Welcome To {{ ucfirst(auth()->user()->name) }}</h5>
                    <span class="badge bg-light text-dark">{{ auth()->user()->updated_at->format('F d, Y') }}</span>
                </div>

                <!-- Scrollable Body -->
                <div class="card-body" style="max-height: 70vh; overflow-y: auto; overflow-x: hidden;">

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('registered'))
                        <h4 class="mb-3 text-success">{{ __('Thank you for registration!') }}</h4>
                        <p class="lead">We will get back to you within <strong>24 hours</strong>.</p>
                    @endif

                    <div class="row g-4">
                        <!-- Wallet -->
                        <div class="col-md-4">
                            <div class="p-4 bg-light rounded shadow-sm h-100 text-center">
                                <h5 class="mb-2 text-primary">Wallet</h5>
                                <p class="mb-0 fs-5 fw-bold">{{ auth()->user()->wallet }}</p>
                            </div>
                        </div>

                        <!-- Referral -->
                        <div class="col-md-8">
                            <div class="p-4 bg-white border rounded shadow-sm h-100">
                                <h5 class="mb-3 text-info">Your Referral Code</h5>
                                <p class="mb-2">Share this code or link with your friends:</p>

                                <div class="input-group">
                                    <input type="text" class="form-control" id="referral-link"
                                        value="{{ route('user.refferal', ['ref' => auth()->user()->referral_id]) }}" readonly>
                                    <button class="btn btn-outline-primary" onclick="copyToClipboard('referral-link')">
                                        Copy
                                    </button>
                                </div>
                                <div id="copy-success" class="text-success mt-2 fw-semibold" style="display: none;">
                                    ✅ Copied!
                                </div>
                            </div>
                        </div>

                        <!-- Courses -->
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded shadow-sm h-100">
                                <h5 class="mb-2 text-primary">Your Courses</h5>
                                @foreach($plan as $plans)
                                    <p class="mb-1">{{ ucfirst($plans->course->name) }}</p>
                                @endforeach
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="col-md-6">
                            <div class="p-4 bg-white border rounded shadow-sm h-100">
                                <h5 class="mb-2 text-primary">Plan Duration</h5>
                                @foreach($plan as $plan)
                                    @php
                                        $start = $plan->updated_at ? $plan->updated_at : null;
                                        $validDays = $plan->valid * 30; 
                                        $endDate = $start ? $start->copy()->addDays($validDays) : null; 
                                        $now = \Carbon\Carbon::now();

                                        $status = 'No Plan';
                                        $remainingMonths = 0;
                                        $remainingDaysInMonth = 0;

                                        if ($endDate) {
                                            $remainingDays = $endDate->diffInDays($now, false); 

                                            if ($remainingDays > 0) {
                                                $status = 'Expired';
                                                $remainingDays = abs($remainingDays);
                                            } else {
                                                $status = 'Remaining';
                                                $remainingDays = abs($remainingDays);
                                            }
                                            $remainingMonths = floor($remainingDays / 30);
                                            $remainingDaysInMonth = $remainingDays % 30;
                                        }

                                        $currentDate = $now->format('Y-m-d');
                                    @endphp

                                    <p class="mb-1 fw-semibold">
                                        Course: {{ ucfirst($plan->course->name) }} <br>
                                        Current Date: {{ $currentDate }} <br>
                                        Status: {{ $status }} <br>
                                        Paid: {{ $plan->amount }} <br>
                                        @if ($status == 'Remaining')
                                            Remaining: {{ $remainingMonths }} months ({{ $remainingDaysInMonth }} days)
                                        @elseif ($status == 'Expired')
                                            Expired: {{ $remainingMonths }} months ({{ $remainingDaysInMonth }} days)
                                        @else
                                            No active plan
                                        @endif
                                    </p>
                                @endforeach
                            </div>
                        </div>

                        <!-- Paid Amount -->
                        <div class="col-md-6">
                            <div class="p-4 bg-white border rounded shadow-sm h-100 text-center">
                                <h5 class="mb-2 text-primary">Total Paid</h5>
                                <h4 class="fw-bold text-success">{{ $total_amount }}</h4>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Fixed Footer -->
                <div class="card-footer bg-light text-center sticky-bottom">
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="btn btn-danger">
                        🔓 Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    const input = document.getElementById(elementId);
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        const msg = document.getElementById('copy-success');
        msg.style.display = 'block';
        setTimeout(() => {
            msg.style.display = 'none';
        }, 2000);
    });
}
</script>
@endsection
