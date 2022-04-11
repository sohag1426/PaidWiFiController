<ul class="list-group list-group-flush">

    <li class="list-group-item">
        <span class="font-weight-bold"> package Name: </span>
        {{ $invoice->get('package_name') }}
    </li>

    @if ($invoice->has('package_price'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Package Price: </span>
        {{ $invoice->get('package_price') }} {{ config('consumer.currency') }}
    </li>
    @endif

    @if ($invoice->has('customers_amount'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Customer's Amount: </span>
        {{ $invoice->get('customers_amount') }} {{ config('consumer.currency') }}
    </li>
    @endif

    @if ($invoice->has('discount'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Discount Amount: </span>
        {{ $invoice->get('discount') }} {{ config('consumer.currency') }}
    </li>
    @endif

    @if ($invoice->has('operators_amount'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Operator's Amount: </span>
        {{ $invoice->get('operators_amount') }} {{ config('consumer.currency') }}
    </li>
    @endif

    @if ($invoice->has('amount_due'))
    <li class="list-group-item">
        <span class="font-weight-bold">Amount Due: </span>
        {{ $invoice->get('amount_due') }} {{ config('consumer.currency') }}
    </li>
    @endif

    @if ($invoice->has('validity'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Validity: </span>
        {{ $invoice->get('validity') }} Days
    </li>
    @endif

    @if ($invoice->has('start_date'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Start Date: </span>
        {{ $invoice->get('start_date') }}
    </li>
    @endif

    @if ($invoice->has('stop_date'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Stop Date: </span>
        {{ $invoice->get('stop_date') }}
    </li>
    @endif

    @if ($invoice->has('billing_period'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Billing Period: </span>
        {{ $invoice->get('billing_period') }}
    </li>
    @endif

    @if ($invoice->has('next_payment_date'))
    <li class="list-group-item">
        <span class="font-weight-bold"> Next Payment Date: </span>
        {{ $invoice->get('next_payment_date') }}
    </li>
    @endif

</ul>
