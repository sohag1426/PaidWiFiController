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
        @if ($customer->payment_status == 'billed')
        <a class="dropdown-item" href="{{ route('customer_bills.index', ['customer_id' => $customer->id]) }}">
            Bills
        </a>
        @endif
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
        @can('editSuspendDate', $customer)
        <a class="dropdown-item" href="{{ route('customers.suspend_date.create', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Edit Suspend Date
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
        @can('changeOperator', $customer)
        <a class="dropdown-item" href="{{ route('customers.change_operator.create', ['customer' => $customer->id]) }}">
            Change Operator
        </a>
        @endcan
        {{-- --}}
        @can('generateBill', $customer)
        <a class="dropdown-item" href="{{ route('customers.customer_bills.create', ['customer' => $customer->id]) }}">
            Generate Bill
        </a>
        @endcan
        {{-- --}}
        @can('removeMacBind', $customer)
        <a class="dropdown-item" href="{{ route('mac-bind-destroy', ['customer' => $customer->id]) }}">
            Remove MAC Bind
        </a>
        @endcan
        {{-- --}}
        @can('sendSms', $customer)
        <a class="dropdown-item" href="{{ route('customers.sms_histories.create', ['customer' => $customer->id]) }}">
            Send SMS
        </a>
        @endcan
        {{-- --}}
        @can('sendLink', $customer)
        <a class="dropdown-item" href="{{ route('customer.send-payment-link.create', ['customer' => $customer->id]) }}">
            Send Payment Link
        </a>
        @endcan
        {{-- --}}
        @can('advancePayment', $customer)
        <a class="dropdown-item" href="{{ route('customers.advance_payment.create', ['customer' => $customer->id]) }}">
            Advance Payment
        </a>
        @endcan
        {{-- --}}
        @can('activateFup', $customer)
        <a class="dropdown-item" href="{{ route('activate-fup', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            activate FUP
        </a>
        @endcan
        {{-- --}}
        <a class="dropdown-item"
            href="{{ route('customers.customer_complains.create', ['customer' => $customer->id]) }}">
            Complaint
        </a>
        {{-- --}}
        <a class="dropdown-item" href="{{ route('customers.internet-history.create', ['customer' => $customer->id]) }}">
            <i class="fas fa-download"></i>
            Internet History
        </a>
        {{-- --}}
        @can('customPrice', $customer)
        <a class="dropdown-item" href="#"
            onclick="showSpecialPrice('{{ route('customers.custom_prices.index', ['customer' => $customer->id]) }}')">
            Special Price
        </a>
        @endcan
        {{-- --}}
        <a class="dropdown-item" href="{{ route('customers.others-payments.create', ['customer' => $customer->id]) }}">
            Other Payment
        </a>
        {{-- --}}
        @can('disconnect', $customer)
        <a class="dropdown-item" href="#"
            onclick="if(confirm('Are you sure?')) callURL('{{ route('customers.disconnect.create', ['customer' => $customer->id]) }}');">
            Disconnect
        </a>
        @endcan
        {{-- --}}
        @endif

    </div>

</div>
