<div class="btn-group dropleft" role="group">

    <button id="btnGroupActionsOnCustomer" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Action
    </button>

    <div class="dropdown-menu" aria-labelledby="btnGroupActionsOnCustomer">
        {{-- --}}
        @can('update', $customer)
        @if (isset($customers))
        <a class="dropdown-item"
            href="{{ route('customers.edit', ['customer' => $customer->id, 'page' => $customers->currentPage()]) }}">
            Edit
        </a>
        @else
        <a class="dropdown-item" href="{{ route('customers.edit', ['customer' => $customer->id, 'page' => 1]) }}">
            Edit
        </a>
        @endif
        @endcan
        {{-- --}}
        @can('delete', $customer)
        <a class="dropdown-item" href="#"
            onclick='deleteCustomer("{{ route("customers.destroy", ["customer" => $customer->id]) }}")'>
            Delete
        </a>
        @endcan
        {{-- --}}
        @can('editSpeedLimit', $customer)
        <a class="dropdown-item" href="{{ route('customer-package-time-limit.edit', ['customer' => $customer->id]) }}">
            Edit Time
        </a>
        <a class="dropdown-item" href="{{ route('customer-package-speed-limit.edit', ['customer' => $customer->id]) }}">
            Edit Speed
        </a>
        <a class="dropdown-item"
            href="{{ route('customer-package-volume-limit.edit', ['customer' => $customer->id]) }}">
            Edit Volume
        </a>
        @endcan
        {{-- --}}
    </div>

</div>
