@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit User</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" onsubmit="event.preventDefault();form_submit(this);return false;">
                        @csrf

                        {{-- Row 1: Name + Email --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input id="name" type="text" class="form-control rounded" name="name" value="{{ old('name', $user->name) }}" autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control rounded" name="email" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>

                        {{-- Row 2: Phone + Education --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input id="phone" type="text" class="form-control rounded" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="referred_by" class="form-label">Referred By</label>
                                <input id="referred_by" type="text" class="form-control rounded" name="referred_by" value="{{ old('referred_by', $plan->referred_by) }}">
                            </div>
                        </div>
     
                        <div class="form-group row mb-3">

                            <div class="col-md-6">
                                <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                                <select name="status" id="status" class="form-select select2">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ $user->status == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->status == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" class="form-select select2" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        {{-- Row 3: Gender + Course --}}
                        <div class="form-group row mb-3">
                            
                            <div class="col-md-6">
                                <label for="course" class="form-label">Course</label>
                                <select id="course" class="form-select select2" name="course">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course['id'] }}" 
                                   {{ $course['id'] === $plan->course_id ? 'selected' : '' }}>
                                   {{ strtoupper($course['name']) }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label for="duration" class="form-label">Choose Duration</label>
                                <select id="duration" class="form-select select2" name="duration">
                                    <option >Select Duration</option>
                                    @foreach($coursePrices as $coursePrice)
                                    <option value="{{ $coursePrice->duration }}" 
                                   {{ $coursePrice->duration == $plan->valid ? 'selected' : '' }}>
                                   {{ $coursePrice->duration }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            
                            <div class="col-md-6">
                                <label for="price" class="form-label">Course Price</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price..." value="{{ $plan->amount }}">
                            </div>

                             <div class="col-md-6 form-password-toggle">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control rounded" id="password" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                    <span class="input-group-text cursor-pointer" id="togglePassword">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm leading-5">
                                    Update User
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm leading-5 text-decoration-none">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    const coursesData = @json($courses);

    function populateDurations(courseId) {
        const durationSelect = $('#duration');
        durationSelect.empty().append('<option value="">Select Duration</option>');

        const selectedCourse = coursesData.find(course => String(course.id) === courseId);
        if (selectedCourse && Array.isArray(selectedCourse.durations)) {
            selectedCourse.durations.forEach(duration => {
                durationSelect.append(new Option(duration, duration));
            });
        }

        durationSelect.trigger('change.select2');
    }

    function populatePrice(courseId, duration) {
        const priceInput = $('#price'); // input field
        priceInput.val(''); // clear old value

        const selectedCourse = coursesData.find(course => String(course.id) === courseId);
        if (selectedCourse && selectedCourse.prices && selectedCourse.prices[duration] !== undefined) {
            const price = selectedCourse.prices[duration];
            priceInput.val(price); // set value directly
        }
    }

    $('#course').on('change', function () {
        const selectedCourseId = $(this).val();
        $('#duration').empty().append('<option value="">Select Duration</option>').trigger('change.select2');
        $('#price').val(''); // clear price input
        if (selectedCourseId) {
            populateDurations(selectedCourseId);
        }
    });

    $('#duration').on('change', function () {
        const selectedDuration = $(this).val();
        const selectedCourseId = $('#course').val();
        $('#price').val(''); // clear price input
        if (selectedCourseId && selectedDuration) {
            populatePrice(selectedCourseId, selectedDuration);
        }
    });
});

</script>

@endpush

@endsection
