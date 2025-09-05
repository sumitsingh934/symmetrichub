@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Discount</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.discounts.store') }}" onsubmit="event.preventDefault();form_submit(this);return false;">
                        @csrf

                        <!-- Name & Discount -->
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="col-form-label">Title</label>
                                <input id="title" type="text" class="form-control rounded" name="title" value="{{ old('title') }}"  oninput="updateCoupon()" autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="coupon_number" class="col-form-label">Coupon</label>
                                <input id="coupon_number" type="text" class="form-control" name="coupon_number" value="{{ old('coupon_number') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="status" class="col-form-label">Status</label>
                                <select id="status" class="form-select" name="status">
                                    <option value="">Select Status</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="discounts" class="col-form-label">Select Month For Discount</label>
                                <select class="form-select select2" id="discounts" name="discounts"></select>
                            </div>
                            <div id="percentInputs" class="row g-3 mb-3"></div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="percent" class="col-form-label">Select Percent</label>
                                <select class="form-select select2" id="percent" name="percent">
                                    <option value="">Select Percent</option>
                                    <option value="10" {{ old('percent') == '10' ? 'selected' : '' }}>10%</option>
                                    <option value="20" {{ old('percent') == '20' ? 'selected' : '' }}>20%</option>
                                    <option value="25" {{ old('percent') == '25' ? 'selected' : '' }}>25%</option>
                                    <option value="30" {{ old('percent') == '30' ? 'selected' : '' }}>30%</option>
                                    <option value="50" {{ old('percent') == '50' ? 'selected' : '' }}>50%</option>
                                    <option value="75" {{ old('percent') == '75' ? 'selected' : '' }}>75%</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="description" class="col-form-label">Date</label>
                                <input type="date" class="form-control" name="discount_date">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>


                        <!-- Buttons -->
                        <div class="form-group row mb-0">
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Create Discount
                                </button>
                                <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
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
    $('#discounts').select2({
        placeholder: 'Select Month For Discount...',
        multiple: true,
        ajax: {
            url: '{{ route("admin.discounts.search") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

  
  });

    $('.select2').select2({
            placeholder: function() {
                return $(this).data('placeholder');
            },
            //allowClear: true,
            width: 'resolve'
        });

    const randomNumber = Math.floor(Math.random() * (9999 - 1000 + 1)) + 1000;

    function updateCoupon() {
        const titleValue = document.getElementById('title').value;
        document.getElementById('coupon_number').value = titleValue + randomNumber;
    }

</script>

@endpush
@endsection
