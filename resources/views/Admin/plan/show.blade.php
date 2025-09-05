@extends('layouts.adminapp')

@section('header')
    User Details: {{ ucfirst($plan->course->name) }}
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Shop Details -->
        <div class="lg:col-span-2">
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-semibold">User Information</h3>
                    <div>
                        <a href="{{ route('admin.plan.edit', $plan->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-decoration-none">Edit</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Course Name</p>
                        <p class="font-medium">{{ strtoupper($plan->course->name) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">User</p>
                        <p class="font-medium">{{ $plan->users->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Paid</p>
                        <p class="font-medium">{{ $plan->amount }} </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Reffered By</p>
                        <p class="font-medium">{{ $plan->referred_by }} </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Duration</p>
                        <p class="font-medium">{{ $plan->duration }} Months </p>
                    </div>
                    
                    @php
                      $status = $plan->status == 'active' ? 'Active' : 'Inactive';
                      $statusClass = $plan->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
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
@endsection
