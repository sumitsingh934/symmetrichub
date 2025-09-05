@extends('layouts.adminapp')

@section('title', 'Dashboard')

@section('content')

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="row">

    <!-- Left Column: Profit & Sales -->
    <div class="col-lg-12 order-1">
      <div class="row">
        <!-- Profit Card -->
        <div class="col-md-3 mb-4">
          <div class="card">
            <a href="{{ route('admin.users.index') }}">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="fa-solid fa-users"></i>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1 text-secondary">Users</span>
                <h3 class="card-title mb-2">{{ $data['userCount'] }}</h3>
              </div>
            </a>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div class="card">
            <a href="{{ route('admin.plan.index') }}">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="fa-solid fa-clipboard-list"></i>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1 text-secondary">Plans</span>
                <h3 class="card-title mb-2">{{ $data['planCount'] }}</h3>
              </div>
            </a>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div class="card">
            <a href="{{ route('admin.courses.index') }}">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="fa-solid fa-book-open"></i>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1 text-secondary">Course</span>
                <h3 class="card-title mb-2">{{ $data['courseCount'] }}</h3>
              </div>
            </a>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div class="card">
            <a href="{{ route('admin.contact.index') }}">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="fa-solid fa-message"></i>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1 text-secondary">Enquiries</span>
                <h3 class="card-title mb-2">{{ $data['enquiryCount'] }}</h3>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

  </div> <!-- /.row -->

</div>
<!-- / Content -->

@endsection
