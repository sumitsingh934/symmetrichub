@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Plans</h5>
                    <a href="{{ route('admin.plan.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-decoration-none">Create New Plan</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table text-center" id="users-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course Name</th>
                                    <th>User</th>
                                    <th>Referred By</th>
                                    <th>Referral Id</th>
                                    <th>Validity</th>
                                    <th>Actual Price</th>
                                    <th>Paid</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('#users-table').DataTable({
        processing: true,
        ajax: {
            url: "{{ route('admin.plan.plan_list') }}", 
            type: 'POST',
            data: function(d) {
                return $.extend({}, d, {
                    _token: csrfToken
                });
            }
        },
        columns: [
            { data: 'index', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'user', name: 'user' },
            {data: 'referred_by', name: 'referred_by'},
            { data: 'referral_id', name: 'referral_id' },
            { data: 'valid', name: 'valid' },
            { data: 'actualprice', name: 'actualprice' },
            { data: 'amount', name:'amount'},
            { data: 'status', name:'status'},
            { data: 'action', name: 'action', orderable: true, searchable: true },
        ]
    });
});
</script>

@endpush

