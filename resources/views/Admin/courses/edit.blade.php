@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Course</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.courses.update', $coursePrice->id) }}" onsubmit="event.preventDefault();form_submit(this);return false;">
                        @csrf

                        <!-- Name & Discount -->
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="col-form-label">Name</label>
                                <input id="name" type="text" class="form-control rounded" name="name" value="{{ $coursePrice->course->name }}" autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="col-form-label">Status</label>
                                <select id="status" class="form-control select2" name="status">
                                    <option value="">Select Status</option>
                                    <option value="0" {{ $coursePrice->course->status == '0' ? 'selected' : '' }}>Inactive</option>
                                    <option value="1" {{ $coursePrice->course->status == '1' ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                        </div>

                        <!-- Duration & Base Price -->
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="duration" class="col-form-label">Duration</label>
                                <input id="durations" type="number" class="form-control rounded" name="durations" value="{{ $coursePrice->duration }}" disabled>
                                <input id="duration" type="hidden" class="form-control rounded" name="duration" value="{{ $coursePrice->duration }}">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="col-form-label">Base Price</label>
                                <input id="price" type="number" class="form-control rounded" name="price" value="{{ $coursePrice->price }}">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group row mb-0">
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Update Course
                                </button>
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
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

@endsection
