@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Discount List</h5>
                    <a href="{{ route('admin.discounts.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-decoration-none">Create New Discount</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table text-center" id="discount-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Discont Duration</th>
                                    <th>Expired IN</th>
                                    <th>Percentage</th>
                                    <th>Coupon Number</th>
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

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>

<script>
$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const timezone = 'Asia/Kolkata';

    const table = $('#discount-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.discounts.discount_list') }}",
            type: 'POST',
            data: function (d) {
                d._token = csrfToken;
            }
        },
        columns: [
            { data: 'index', name: 'index' },
            { data: 'title', name: 'title' },
            { data: 'discount', name: 'discount' },
            {
                data: null,
                name: 'expired',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    const id = 'countdown-' + row.index;
                    return `<span id="${id}" class="countdown" data-start="${row.start_date}" data-duration="${row.duration_days}">Loading...</span>`;
                }
            },
            { data: 'percent', name: 'percent' },
            { data: 'coupon', name: 'coupon' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Countdown updater — run every second
    setInterval(updateCountdowns, 1000);

    function updateCountdowns() {
        $('span.countdown').each(function () {
            const el = $(this);
            const startDateStr = el.data('start');      // e.g. "2025-09-02"
            const duration = parseInt(el.data('duration'));

            if (!startDateStr || isNaN(duration)) {
                el.text('Invalid data');
                return;
            }

            const start = moment.tz(startDateStr, timezone).startOf('day');
            const end = start.clone().add(duration, 'days');
            const now = moment.tz(timezone);

            if (now.isBefore(end)) {
                const diff = moment.duration(end.diff(now));
                const days = Math.floor(diff.asDays());
                const hours = diff.hours();
                const minutes = diff.minutes();
                const seconds = diff.seconds();

                const parts = [];
                if (days > 0) parts.push(`${days} day${days !== 1 ? 's' : ''}`);
                if (hours > 0) parts.push(`${hours} hour${hours !== 1 ? 's' : ''}`);
                if (minutes > 0) parts.push(`${minutes} minute${minutes !== 1 ? 's' : ''}`);
                if (seconds > 0) parts.push(`${seconds} second${seconds !== 1 ? 's' : ''}`);

                const output = parts.length === 1
                    ? parts[0]
                    : parts.slice(0, -1).join(', ') + ' and ' + parts.slice(-1);

                el.text(output);
            } else {
                el.text('Expired');
            }
        });
    }
});
</script>

@endpush
@endsection
