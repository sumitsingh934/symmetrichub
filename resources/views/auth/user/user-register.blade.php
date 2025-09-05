@extends('layouts.userapp')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-center py-4 py-md-5">
        <div class="form-card rounded-4 p-3 p-md-5 shadow-lg">
            <h2 class="text-center mb-4 text-primary">Symmetric Hub</h2>
            <div class="form-scrollable-content py-4">
                <form id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="discount_id" id="discount_id">

                    <div class="row g-4"> {{-- Increased gutter spacing for better looks --}}

                        <div class="col-12 col-md-6 position-relative">
                            <input type="text" id="reg-username"
                                   class="form-control rounded-pill custom-input @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}"
                                   placeholder="Full Name" autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 position-relative">
                            <input type="email" id="reg-email"
                                   class="form-control rounded-pill custom-input @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   placeholder="Email" autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                                       
                    <div class="col-12 col-md-12 position-relative">
                        <input type="text" name="referral_id" id="referral_id" class="form-control rounded-pill" value="{{ $user }}" disabled/>
                        @if(!empty($user))
                            <input type="hidden" name="referred_by" value="{{ $user }}">
                        @endif
                        @error('referral_id')
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-denger">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                        <div class="col-12 col-md-6 position-relative">
                            <input type="text" id="reg-phone"
                                   class="form-control rounded-pill custom-input @error('phone') is-invalid @enderror"
                                   name="phone" value="{{ old('phone') }}"
                                   placeholder="Phone" autocomplete="tel">
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <select id="gender" class="form-select rounded-pill custom-input @error('gender') is-invalid @enderror" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <select id="course" class="form-control rounded-pill custom-input @error('course') is-invalid @enderror" name="course">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course['id'] }}" {{ old('course') == $course['id'] ? 'selected' : '' }}>
                                        {{ strtoupper($course['name']) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <select id="duration" class="form-control rounded-pill custom-input @error('duration') is-invalid @enderror" name="duration">
                                <option value="">Select Duration</option>
                            </select>
                            @error('duration')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <input type="text" class="form-control rounded-pill custom-input @error('price') is-invalid @enderror" id="price" name="price" placeholder="Price..." readonly>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

<div class="col-12 col-md-6 password-field-wrapper">
    <div class="position-relative">
        <input type="password" id="password"
               class="form-control rounded-pill custom-input"
               name="password" placeholder="Password" autocomplete="new-password">
        <span class="password-toggle" onclick="togglePasswordVisibility(this)">
            <i class="fas fa-eye-slash"></i>
        </span>
    </div>
    @error('password')
        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
    @enderror
</div>

                        @if($discount && $isDiscountActive)
                        <div class="col-12 d-flex gap-2 align-items-center">
                            <div class="flex-grow-1">
                                <input type="text" class="form-control rounded-pill @error('coupon') is-invalid @enderror"
                                       id="coupon" name="coupon" placeholder="Enter Coupon Code">
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary rounded-pill flex-shrink-0" id="apply-coupon">Apply</button>
                            </div>
                            @error('coupon')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                    </div>
                </form>
            </div>
            <div class="d-grid">
                <button type="submit" form="register-form" class="btn btn-primary btn-lg rounded-pill">Register</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

                window.togglePasswordVisibility = function(el) {
                    const passwordInput = el.closest(".password-field-wrapper").querySelector("input");
                    const eyeIcon = el.querySelector("i");
                    
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        eyeIcon.classList.remove("fa-eye-slash");
                        eyeIcon.classList.add("fa-eye");
                    } else {
                        passwordInput.type = "password";
                        eyeIcon.classList.remove("fa-eye");
                        eyeIcon.classList.add("fa-eye-slash");
                    }
                };

                $('#apply-coupon').on('click', function () {
                    const $button = $(this);
                    if ($button.prop('disabled')) return;
                    const couponCode = $('#coupon').val();
                    const originalPrice = parseFloat($('#price').val());
                    const courseId = $('#course').val();
                    const duration = $('#duration').val();
                    if (!couponCode || !originalPrice || !courseId || !duration) {
                        alert('Please enter a coupon and make sure course, duration, and price are selected.');
                        return;
                    }
                    $.ajax({
                        url: '{{ route("coupon.validate") }}',
                        method: 'POST',
                        data: {
                            coupon: couponCode,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            if (response.valid) {
                                const discount = (originalPrice * response.discount_percent) / 100;
                                const discountedPrice = (originalPrice - discount).toFixed(2);
                                $('#price').val(discountedPrice);
                                alert(response.message + ` (${response.discount_percent}% OFF)`);
                                $button.prop('disabled', true).text('Applied');
                            }
                        },
                        error: function (xhr) {
                            alert(xhr.responseJSON?.message ?? 'Something went wrong.');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection