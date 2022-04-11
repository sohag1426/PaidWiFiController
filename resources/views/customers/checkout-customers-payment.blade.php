@extends('laraview.layouts.topNavLayout')

@section('title')
bKash Payment
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
@include('customers.logout-nav')
@endsection

@section('content')

<div class="card">

    <!-- Modal Failed-->
    <div class="modal fade" id="ModalFailed" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="overlay-wrapper">
                        <p id="FailedMessage">
                            <i class="far fa-times-circle"></i>
                            <span class="text-danger"> Transaction Failed : </span>
                            <span id="FailedMessageBody"></span>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--/modal Failed-->


    <div class="card-body text-center">

        <div class="card-header bg-info">
            Pay With bKash
        </div>

        <p class="card-text">Customer: {{ $customer->mobile }}</p>

        <p class="card-text">Package Name: {{ $package->name }}</p>

        @if ($package->rate_limit)
        <p class="card-text">Speed Limit: {{ $package->master_package->rate_limit }}
            {{ $package->master_package->readable_rate_unit }}</p>
        @else
        <p class="card-text">Speed Limit: Unlimited</p>
        @endif

        @if ($package->volume_limit)
        <p class="card-text">MB Limit: {{ $package->master_package->volume_limit }}
            {{ $package->master_package->volume_unit }}</p>
        @else
        <p class="card-text">MB Limit: Unlimited MB</p>
        @endif

        <p class="card-text">Validity: {{ $package->master_package->validity }} Days</p>

        <p class="card-text">Amount: {{ $package->price }} {{ config('consumer.currency') }}</p>

        <p class="card-text">Payment Method: bKash</p>

        <button id="bKash_button" type="button"><img src="/storage/logo/bKash_Payment_logo.png"
                alt="Pay With bKash"></button>

    </div>

</div>

@endsection

@section('pageJs')

<script src="{{ $bkash_script_url }}"></script>

<script>
    function showFailedMessage( message ) {
          $('#ModalFailed').modal({
            show: true
          });
          $( "#FailedMessageBody" ).html( message );
    }

    function callReconfigure(val){
        bKash.reconfigure(val);
    }

    function clickPayButton(){
        $("#bKash_button").trigger('click');
    }

$(document).ready(function () {

let customer_payment = "{{ $customer_payment->id }}";

let amount = "{{ $customer_payment->amount_paid }}";

let token = "{{ $payment_token }}";

bKash.init({
    paymentMode: 'checkout', //fixed value ‘checkout’

    paymentRequest: {
        amount: amount,
        intent: 'sale'
    },

    createRequest: function (request) {
        $.ajax({
            method: 'GET',
            url: "/bkash/customer_payment/" + customer_payment + "/create?token=" + token,
            success: function (data) {
                data = JSON.parse(data);
                if (data && data.paymentID != null) {
                    bKash.create().onSuccess(data);
                } else {
                    showFailedMessage(data.errorMessage);
                    bKash.create().onError();
                }
            },
            error: function () {
                bKash.create().onError();
            }
        });
    },
    executeRequestOnAuthorization: function () {
        $.ajax({
            method: 'GET',
            url: "/bkash/customer_payment/" + customer_payment + "/execute?token=" + token,
            success: function (data) {
                data = JSON.parse(data);
                if (data && data.paymentID != null) {
                    if(data.transactionStatus == 'Initiated'){
                        window.location.href = "/bkash/customer_payments/" + customer_payment;
                    } else {
                        window.location.href = "/bkash/customer_payment/" + customer_payment + "/success";
                    }
                } else {
                    showFailedMessage(data.errorMessage);
                    bKash.execute().onError();
                }
            },
            error: function () {
                bKash.execute().onError();
            }
        });
    },
    onClose : function () {
        location.reload();

    }
});

});

</script>

@endsection
