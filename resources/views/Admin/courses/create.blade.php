@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Course</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.courses.store') }}" onsubmit="event.preventDefault();form_submit(this);return false;">
                        @csrf

                        <!-- Name & Discount -->
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="col-form-label">Name</label>
                                <input id="name" type="text" class="form-control rounded" name="name" value="{{ old('name') }}" autofocus>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="col-form-label">Status</label>
                                <select id="status" class="form-control select2" name="status">
                                    <option value="">Select Status</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
               
                        </div>

                        <!-- Duration & Base Price -->
                        <div class="form-group row mb-3">
                            <div class="col-md-6">
                                <label for="duration" class="col-form-label">Duration</label>
                                <select id="duration" class="form-select" name="duration[]" multiple>
                                    <option>Select Duration</option>
                                    <option value="1">Month 1</option>
                                    <option value="2">Month 2</option>
                                    <option value="3">Month 3</option>
                                    <option value="4">Month 4</option>
                                    <option value="5">Month 5</option>
                                    <option value="6">Month 6</option>
                                    <option value="7">Month 7</option>
                                    <option value="8">Month 8</option>
                                    <option value="9">Month 9</option>
                                    <option value="10">Month 10</option>
                                    <option value="11">Month 11</option>
                                    <option value="12">Month 12</option>
                                
                                </select>
                            </div>
                            <div id="priceInputs" class="row g-3 mb-3"></div>
                


                        <!-- Buttons -->
                        <div class="form-group row mb-0">
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Create Course
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

@push('scripts')
<script>
  $(document).ready(function () {
    // Initialize Select2
    $('#duration').select2({
      placeholder: "Select Duration",
      width: '100%'
    });

    const priceData = {};

    $('#duration').on('change', function () {
      const selectedMonths = $(this).val();
      const priceInputs = $('#priceInputs');

      // Save current price values
      $('#priceInputs input').each(function () {
        const name = $(this).attr('name');
        const value = $(this).val();
        if (value !== '') {
          priceData[name] = value;
        }
      });

      // Clear inputs
      priceInputs.empty();

      // Re-add inputs, restoring existing values if any
      if (selectedMonths) {
        selectedMonths.forEach(month => {
          const name = `price_month_${month}`;
          const value = priceData[name] || '';

          const inputGroup = $(`
            <div class="col-md-6">
              <label class="form-label">Month ${month} Price</label>
              <input type="number" name="${name}" class="form-control" placeholder="Enter price for month ${month}" value="${value}" required>
            </div>
          `);
          priceInputs.append(inputGroup);
        });
      }
    });
  });
</script>

@endpush
@endsection
