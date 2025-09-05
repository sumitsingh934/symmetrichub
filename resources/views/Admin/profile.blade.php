@extends('layouts.adminapp')

@section('title', 'Admin Profile')

@section('content')
<div class="container-xxl d-flex justify-content-center align-items-center" style="min-height: 85vh;">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inners" id="authentication-inner" style="width: 450px;">
      <div class="card">
        <div class="card-body">
          <h2 class="mb-2 text-center py-2">Update Profile</h2>

          @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
          @endif

          <form id="adminProfileForm" action="{{ route('admin.update',$admin->id) }}" method="POST" onsubmit="event.preventDefault();form_submit(this);return false;">
            @csrf
            <div class="mb-3 py-2">
              <label for="name" class="form-label">Name</label>
              <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name', $admin->name) }}"
                required
              />
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email', $admin->email) }}"
                required
              />
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Phone</label>
              <input
                type="text"
                class="form-control @error('phone') is-invalid @enderror"
                id="phone"
                name="phone"
                value="{{ old('phone', $admin->phone) }}"
              />
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <label for="password" class="form-label">New Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  class="form-control @error('password') is-invalid @enderror"
                  id="password"
                  name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                />
                <span class="input-group-text cursor-pointer" id="togglePassword">
                  <i class="bx bx-hide"></i>
                </span>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  class="form-control"
                  id="password_confirmation"
                  name="password_confirmation"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                />
                <span class="input-group-text cursor-pointer" id="togglePasswordConfirm">
                  <i class="bx bx-hide"></i>
                </span>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Update Profile</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
