<div class="modal-body">
    <ul class="list-group">

        <li class="list-group-item d-flex justify-content-between align-items-center">
            Username
            <span class="badge badge-pill">{{ $customer->username }}</span>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center">
            Name
            <span class="badge badge-pill">{{ $customer->name }}</span>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center">
            Mobile
            <span class="badge badge-pill">{{ $customer->mobile }}</span>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center">
            Customer Status
            <span class="text-danger">{{ $customer->status }}</span>
        </li>

        @if ($customer->status === 'suspended')
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Suspend Reason
            <span class="text-danger">{{ $customer->suspend_reason }}</span>
        </li>
        @endif

    </ul>
</div>
<div class="modal-footer">
    @if ($customer->payment_status == 'billed')
    <a class="btn btn-outline-primary" href="{{ route('customer_bills.index', ['customer_id' => $customer->id]) }}"
        role="button">Submit Payment</a>
    @endif
    @can('editSuspendDate', $customer)
    <a class="btn btn-outline-info" href="{{ route('customers.suspend_date.create', ['customer' => $customer->id ]) }}"
        role="button">Reschedule payment date and Activate</a>
    @endcan
</div>
