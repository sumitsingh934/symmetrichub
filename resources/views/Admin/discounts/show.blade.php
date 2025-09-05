@extends('layouts.adminapp')

@section('header')
    Discount Details: {{ ucfirst($discount->title) }}
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Shop Details -->
        <div class="lg:col-span-2">
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-semibold">Discount Information</h3>
                    <div>
                        <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-decoration-none">Edit</a>
                        <a href="{{ route('admin.discounts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-decoration-none">Back</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Title</p>
                        <p class="font-medium">{{ ucfirst($discount->title) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Coupon Code</p>
                        <p class="font-medium">{{ ucfirst($discount->coupon_number) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Percent</p>
                        <p class="font-medium">{{ ucfirst($discount->percentage) }}%</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Duration Day</p>
                        <p class="font-medium">{{ $discount->discount_duration_day }} Days</p>
                    </div>
                    
                     @php
                        use Carbon\Carbon;
                        $isActive = $discount->status == 1;
                        $status = $isActive ? 'Active' : 'Inactive';
                        $statusClass = $isActive 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-red-100 text-red-800';

                        $startDate = Carbon::parse($discount->discount_date);
                        $durationInDays = $discount->discount_duration_day;

                    @endphp
                    
                    <div>
                        <p class="text-sm text-gray-600">Expired</p>
                        <div id="countdown">Loading countdown...</div>
                    </div>
                    
                    <div>
                       <p class="text-sm text-gray-600">Status</p>
                       <p class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusClass }}">
                        {{ $status }}
                       </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Description</p>
                        <p class="font-medium">{{ ucfirst($discount->description) }}</p>
                    </div>

                </div>
            </div>
        </div>         
    </div>
@push('scripts')
<script>
    const discountDate = "<?php echo $startDate; ?>"; 
    const discountDurationDay = <?php echo $durationInDays; ?>; 

 const startDate = new Date(discountDate.replace(' ', 'T'));
    const endDate = new Date(startDate);
    endDate.setDate(endDate.getDate() + discountDurationDay);

    function updateCountdown() {
        const now = new Date();
        let totalSeconds = Math.floor((endDate - now) / 1000);

        if (totalSeconds <= 0) {
            document.getElementById('countdown').textContent = "Expired";
            clearInterval(timerInterval);
            return;
        }

        const days = Math.floor(totalSeconds / 86400);
        totalSeconds %= 86400;

        const hours = Math.floor(totalSeconds / 3600);
        totalSeconds %= 3600;

        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;

        const parts = [];

        if (days > 0) parts.push(`${days} day${days !== 1 ? 's' : ''}`);
        if (hours > 0) parts.push(`${hours} hour${hours !== 1 ? 's' : ''}`);
        if (minutes > 0) parts.push(`${minutes} minute${minutes !== 1 ? 's' : ''}`);
        if (seconds >= 0) parts.push(`${seconds} second${seconds !== 1 ? 's' : ''}`);

        document.getElementById('countdown').textContent = parts.join(' ');
    }

    updateCountdown();

    const timerInterval = setInterval(updateCountdown, 1000);

</script>

@endpush    
@endsection
