@extends('layouts.userapp')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center mx-auto w-75" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5">
                <h2 class="text-center mb-4 text-primary">Contact Us</h2>
                <p class="text-center text-muted mb-4">We'd love to hear from you! Fill out the form below and we'll get back to you shortly.</p>
                
                <form id="contact-form" method="POST" action="{{ route('contact.store') }}">
                    @csrf

                    <div class="mb-3">
                        <input type="text" id="contact-name" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" 
                               placeholder="Full Name" autocomplete="name">
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="email" id="contact-email" 
                               class="form-control form-control-lg @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" 
                               placeholder="Email" autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="tel" id="contact-phone" 
                               class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                               name="phone" value="{{ old('phone') }}" 
                               placeholder="Phone" autocomplete="tel">
                        @error('phone')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <textarea id="contact-message" 
                                  class="form-control form-control-lg @error('message') is-invalid @enderror" 
                                  name="message" rows="5" 
                                  placeholder="Your Message">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">Send Message</button>
                    </div>
                </form>

                <div class="text-center mt-4 text-muted small">
                    <p>Or reach us directly at <a href="{{ route('home') }}">info@symmetrichub.com</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
