<div class="btn-group dropleft" role="group">

    <button id="btnGroupActionsOnCustomer" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Action
    </button>

    <div class="dropdown-menu" aria-labelledby="btnGroupActionsOnCustomer">

        @if (Auth::user()->subscription_status === 'suspended')

        <a class="dropdown-item" href="#">
            Subscription Suspended
        </a>

        @else

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
        @can('activate', $customer)
        <a class="dropdown-item" href="{{ route('customer-activate', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Activate
        </a>
        @elsecan('viewActivateOptions', $customer)
        <a class="dropdown-item" href="#"
            onclick="showActivateOptions('{{ route('customer-activate-options', ['id' => $customer->id ]) }}')">
            Activate
        </a>
        @endcan
        {{-- --}}
        @can('suspend', $customer)
        <a class="dropdown-item" href="{{ route('customer-suspend', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Suspend
        </a>
        @endcan
        {{-- --}}
        @can('disable', $customer)
        <a class="dropdown-item" href="{{ route('customer-disable', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Disable
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
        @can('changePackage', $customer)
        <a class="dropdown-item" href="{{ route('customer-package-change.edit', ['customer' => $customer->id]) }}">
            Extend/Change Package
        </a>
        @endcan
        {{-- --}}
        @endif

    </div>

</div>
