<dl class="row">
    <dt class="col-sm-4">Payment ID</dt>
    <dd class="col-sm-8">{{ $transaction->id }}</dd>
</dl>

<hr>

<dl class="row">
    <dt class="col-sm-4">Payment Gateway</dt>
    <dd class="col-sm-8">{{ $transaction->payment_gateway_name }}</dd>
</dl>

<hr>

<dl class="row">
    <dt class="col-sm-4">Type</dt>
    <dd class="col-sm-8">{{ $transaction->type }}</dd>
</dl>

<hr>

<dl class="row">
    <dt class="col-sm-4">Pay Status</dt>
    <dd class="col-sm-8">{{ $transaction->pay_status }}</dd>
</dl>

<hr>

<dl class="row">
    <dt class="col-sm-4">Amount Paid</dt>
    <dd class="col-sm-8">{{ $transaction->amount_paid }}</dd>
</dl>

<hr>

<dl class="row">
    <dt class="col-sm-4">Store Amount</dt>
    <dd class="col-sm-8">{{ $transaction->store_amount }}</dd>
</dl>

<hr>

<dl class="row">
    <dt class="col-sm-4">Transaction Fee</dt>
    <dd class="col-sm-8">{{ $transaction->transaction_fee }}</dd>
</dl>
