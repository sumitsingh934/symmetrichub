@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Plan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.plan.update', $plan->id) }}" onsubmit="event.preventDefault();form_submit(this);return false;">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="course" class="col-md-4 col-form-label text-md-right">Course</label>
                            <div class="col-md-6">
                                <select name="course" id="course" class="form-select select2">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}"
                                    {{ (old('course', $course->id) == $plan->course->id) ? 'selected' : '' }}>
                                    {{ ($course->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-right">User Name</label>
                            <div class="col-md-6">
                                <select name="username" id="username" class="form-select select2">
                                    <option value="">Select Username</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                    {{ (old('username', $user->id ) == $userId) ? 'selected' : '' }}>
                                    {{ ($user->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="reffred_by" class="col-md-4 col-form-label text-md-right">Reffred By</label>
                            <div class="col-md-6">
                                <input id="reffral_id" type="text" class="form-control rounded" name="reffral_id" value="{{ old('reffral_id' , $plan->referred_by) }}" disabled>
                                <input id="reffred_by" type="hidden" class="form-control" name="reffred_by" value="{{ old('reffred_by' , $plan->referred_by) }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>
                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control rounded" name="amount" value="{{ old('amount' , $plan->amount) }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="valid" class="col-md-4 col-form-label text-md-right">Duration</label>
                            <div class="col-md-6">
                                <select name="valid" id="valid" class="form-select select2">
                                    <option value="">Select Duration</option>
                                    @foreach($courseprices as $courseprice)
                                    <option value="{{ $courseprice->duration }}"
                                    {{ (old('valid', $courseprice->duration) == $duration) ? 'selected' : '' }}>
                                    {{ $courseprice->duration }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">
                                <select name="status" id="status" class="form-select select2">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ $plan->status == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $plan->status == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm leading-5">
                                    Update User
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center bg-gray-500 text-white px-4 py-2 
                                rounded hover:bg-gray-600 text-sm leading-5 text-decoration-none">Cancel</a>
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
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: function() {
                return $(this).data('placeholder');
            },
            //allowClear: true,
            width: 'resolve'
        });
    });
</script>
@endpush
@endsection
