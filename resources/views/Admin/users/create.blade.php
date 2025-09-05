@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create User</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store') }}" onsubmit="event.preventDefault();form_submit(this);return false;">
                        @csrf

                        {{-- Row 1: Name + Email --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input id="name" type="text" class="form-control rounded" name="name" value="{{ old('name') }}" placeholder="Enter Full Name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control rounded" name="email" value="{{ old('email') }}" placeholder="Enter Email Address">
                            </div>
                        </div>

                        {{-- Row 2: Phone + Education --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input id="phone" type="text" class="form-control rounded" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone">
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" class="form-select select2" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
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
                                        <option value="{{ $course['id'] }}" {{ old('course') == $course['id'] ? 'selected' : '' }}>
                                            {{ strtoupper($course['name']) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="duration" class="form-label">Choose Plan</label>
                                <select id="duration" class="form-select select2" name="duration">
                                    <option value="">Select Duration</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">Course Price</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price...">
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
                                    Create User
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

    const durationSelect = $('#duration');
    const priceInput = $('#price');

    function populateDurations(courseId, selectedDuration = null) {
        durationSelect.empty().append('<option value="">Select Duration</option>');

        const selectedCourse = coursesData.find(course => String(course.id) === courseId);

        if (selectedCourse?.durations?.length) {
            selectedCourse.durations.forEach(duration => {
                const isSelected = String(duration) === String(selectedDuration);
                durationSelect.append(new Option(duration, duration, isSelected, isSelected));
            });
        }

        durationSelect.trigger('change.select2');
    }

    function populatePrice(courseId, duration, selectedPrice = null) {
        const selectedCourse = coursesData.find(course => String(course.id) === courseId);
        const price = selectedCourse?.prices?.[duration];

        if (price !== undefined) {
            priceInput.val(price);
        } else {
            priceInput.val('');
        }
    }

    const initialCourse = $('#course').val();
    const initialDuration = durationSelect.data('selected');
    const initialPrice = priceInput.val(); 

    if (initialCourse) {
        populateDurations(initialCourse, initialDuration);
        if (initialDuration) {
            populatePrice(initialCourse, initialDuration, initialPrice);
        }
    }

    $('#course').on('change', function () {
        const selectedCourseId = $(this).val();

        durationSelect.empty().append('<option value="">Select Duration</option>').trigger('change.select2');
        priceInput.val(''); 

        populateDurations(selectedCourseId);
    });

    durationSelect.on('change', function () {
        const selectedDuration = $(this).val();
        const selectedCourseId = $('#course').val();

        populatePrice(selectedCourseId, selectedDuration);
    });
});


</script>


@endpush

@endsection
