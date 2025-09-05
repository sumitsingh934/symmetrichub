@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10"> {{-- Wider form to support side-by-side fields --}}
            <div class="card">
                <div class="card-header">Create Plan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.plan.store') }}" onsubmit="event.preventDefault(); form_submit(this); return false;">
                        @csrf

                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="user_id" class="mb-2">User</label>
                                <select id="user_id" class="form-select select2" name="user">
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user') == $user->id ? 'selected' : '' }}>
                                    {{ ucfirst($user->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="course_id" class="mb-2">Course</label>
                                <select id="course_id" class="form-select select2" name="course[]" multiple data-placeholder="Select Course">
                                    <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course['id'] }}" {{ collect(old('course'))->contains($course['id']) ? 'selected' : '' }}>
                                    {{ strtoupper($course['name']) }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="course-duration-price-section">
                            <div id="course-details-container"></div>
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm leading-5">
                                    Create Plan
                                </button>
                                <a href="{{ route('admin.plan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm leading-5 text-decoration-none">
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
        const courseData = @json($courses);
        const $userSelect = $('#user_id');
        const $courseSelect = $('#course_id');
        const $detailsContainer = $('#course-details-container');

        $courseSelect.select2({
            placeholder: $courseSelect.data('placeholder'),
            width: '100%'
        });

        function renderCourseFields(selectedCourses) {
            $detailsContainer.empty();

            selectedCourses.forEach(courseId => {
                const course = courseData.find(c => c.id == courseId);
                if (!course) return;

                const durations = course.durations || [];
                const prices = course.prices || {};

                const durationOptions = durations.map(duration => `
                    <option value="${duration}">${duration}</option>
                `).join('');

                const block = $(`
                    <div class="form-group row mb-3 border p-3 rounded" data-course-id="${course.id}">
                        <div class="col-md-6">
                            <label>Duration for ${course.name}</label>
                            <select name="valids[${course.id}]" class="form-control duration-select">
                                <option value="">Select Duration</option>
                                ${durationOptions}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Price for ${course.name}</label>
                            <input type="text" class="form-control price-display" name="prices[${course.id}]" readonly>
                        </div>
                    </div>
                `);

                $detailsContainer.append(block);
            });
        }

        function updateCourseSection() {
            const selectedUser = $userSelect.val();
            const selectedCourses = $courseSelect.val() || [];

            if (selectedUser && selectedCourses.length) {
                renderCourseFields(selectedCourses);
            } else {
                $detailsContainer.empty();
            }
        }

        $userSelect.on('change', function () {
            updateCourseSection();
        });

        $courseSelect.on('change', function () {
            updateCourseSection();
        });

        $(document).on('change', '.duration-select', function () {
            const $block = $(this).closest('.form-group');
            const courseId = $block.data('course-id');
            const selectedDuration = $(this).val();

            const course = courseData.find(c => c.id == courseId);
            const price = course?.prices?.[selectedDuration] || '';
            $block.find('.price-display').val(price);
        });

        if ($userSelect.val() && $courseSelect.val()?.length > 0) {
            updateCourseSection();

            const oldDurations = @json(old('durations') ?? []);
            $.each(oldDurations, function (courseId, duration) {
                const $durationSelect = $(`select[name="durations[${courseId}]"]`);
                $durationSelect.val(duration).trigger('change');
            });
        }
    });
</script>
@endpush
@endsection
