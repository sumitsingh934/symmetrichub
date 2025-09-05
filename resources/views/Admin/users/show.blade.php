@extends('layouts.adminapp')

@section('header')
    User Details: {{ ucfirst($user->name) }}
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Shop Details -->
        <div class="lg:col-span-2">
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-semibold">User Information</h3>
                    <div>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-decoration-none">Edit</a>
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-decoration-none">Back</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">User Name</p>
                        <p class="font-medium">{{ ucfirst($user->name) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Gender</p>
                        <p class="font-medium">{{ ucfirst($user->gender) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-medium">{{ $user->phone }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Referral Id</p>
                        <p class="font-medium">{{ $user->referral_id }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Referred By</p>
                        @foreach($user->plan as $plans)
                        <p class="font-medium">{{ $plans->referred_by }}</p>
                        @endforeach
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Wallet</p>
                        <p class="font-medium">{{ $user->wallet }}</p>
                    </div>
                    
                     @php
                      $status = $user->status == '1' ? 'Active' : 'Inactive';
                      $statusClass = $user->status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                    @endphp

                    <div>
                       <p class="text-sm text-gray-600">Status</p>
                       <p class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusClass }}">
                        {{ $status }}
                       </p>
                    </div>

                </div>
            </div>
        </div>         
    </div>

<div class="grid grid-cols-2 lg:grid-cols-3 gap-6 py-5">
    <div class="lg:col-span-3">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-xl font-semibold">User Plan Details</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-2">Course Name</th>
                            <th class="px-4 py-2">Referred By</th>
                            <th class="px-4 py-2">Paid</th>
                            <th class="px-4 py-2">Start Date</th>
                            <th class="px-4 py-2">End Date</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->plan as $plan)
                        @php
                            $action = '';
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

                            if($plan->status == 1){
                                $Paidamount = $plan->amount;
                            }else{
                                $Paidamount = 'Payment No Recive';
                            }
                        @endphp

                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $plan->course->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ ucfirst($userName) ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $Paidamount ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $plan->updated_at ? $plan->updated_at->format('Y-m-d') : '-' }}</td>
                                <td class="px-4 py-2">
                                    Current Date: {{ $currentDate }} <br>
                                    Status: {{ $status }} <br>
                                    @if ($status == 'Remaining')
                                    Remaining: {{ $remainingMonths }} months ({{ $remainingDaysInMonth }} days)
                                    @elseif ($status == 'Expired')
                                    Expired: {{ $remainingMonths }} months ({{ $remainingDaysInMonth }} days)
                                    @else
                                    No active plan
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @php
                                        $planStatus = $plan->status == 1 ? 'Active' : 'Inactive';
                                        $planStatusClass = $plan->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                        $toggleStatus = $plan->status == 1 ? 0 : 1;
                                    @endphp

                                    <span id="status-{{ $plan->id }}" class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $planStatusClass }}">
                                        {{ $planStatus }}
                                    </span>
                                    <button
                                        onclick="plan_status_change('{{ route('admin.plan.toggle-status', $plan->id) }}', {{ $toggleStatus }}, {{ $plan->id }}, '{{ $toggleStatus == 1 ? 'Active' : 'Inactive' }}')"
                                        class="ml-2 bg-blue-500 hover:bg-blue-700 text-white text-xs px-2 py-1 rounded">
                                        Toggle
                                    </button>
                                </td>
                                <td class="px-4 py-2">
                                    @php
                                        $action .= '<a href="' . route('admin.users.edit', $user->id) . '" class="text-dark bg-transparent hover-effect p-1 rounded">
                                            <i class="fas fa-edit"></i>
                                        </a>';
                                        echo $action;
                                    @endphp
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">No plan details available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
