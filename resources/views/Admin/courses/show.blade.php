@extends('layouts.adminapp')

@section('header')
    Course Details: {{ ucfirst($coursePrice->course->name) }}
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Shop Details -->
        <div class="lg:col-span-2">
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-semibold">Course Information</h3>
                    <div>
                        <a href="{{ route('admin.courses.edit', $coursePrice->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-decoration-none">Edit</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Course Name</p>
                        <p class="font-medium">{{ ucfirst($coursePrice->course->name) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Duration</p>
                        <p class="font-medium">{{ $coursePrice->duration }} Months</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Price</p>
                        <p class="font-medium">{{ ucfirst($coursePrice->price) }}</p>
                    </div>
                    
                     @php
                        $isActive = $coursePrice->course->status == 1;
                        $status = $isActive ? 'Active' : 'Inactive';
                        $statusClass = $isActive 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-red-100 text-red-800';
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
