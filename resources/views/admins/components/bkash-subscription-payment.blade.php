@extends ('laraview.layouts.topNavLayout')

@section('title')
Bkash Subscription Payment
@endsection

@section('pageCss')
@endsection

@section('company')
{{ Auth::user()->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
@endsection

@section('content')

<div class="card">

    <!-- Modal Failed-->
    <div class="modal fade" id="ModalFailed" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="overlay-wrapper">
                        <p>
                            <i class="far fa-times-circle"></i>
                            <span class="text-danger"> Transaction Failed : </span>
                            <span id="Failed_Message"> </span>
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
            Bkash subscription Payment
        </div>

        <p class="card-text">Amount : {{ $subscription_payment->amount_paid }} TK</p>
        <p class="card-text">Month : {{ $subscription_payment->month }}</p>
        <p class="card-text">Year : {{ $subscription_payment->year }}</p>
        <p class="card-text">Payment Method: Bkash</p>

        <button id="bKash_button" type="button" class="btn btn-dark">Pay With Bkash</button>

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
          $( "#Failed_Message" ).html( message );
    }

    function callReconfigure(val){
        bKash.reconfigure(val);
    }

    function clickPayButton(){
        $("#bKash_button").trigger('click');
    }

$(document).ready(function () {

let subscription_payment = "{{ $subscription_payment->id }}";

let amount = "{{ $subscription_payment->amount_paid }}";


bKash.init({
    paymentMode: 'checkout', //fixed value ‘checkout’

    paymentRequest: {
        amount: amount,
        intent: 'sale'
    },

    createRequest: function (request) {
        $.ajax({
            url: "/bkash/subscription_payment/" + subscription_payment + "/create",
            method: 'GET',
            contentType: 'application/json',
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
            url: "/bkash/subscription_payment/" + subscription_payment + "/execute",
            method: 'GET',
            contentType: 'application/json',
            success: function (data) {
                data = JSON.parse(data);
                if (data && data.paymentID != null) {
                    if(data.transactionStatus == 'Initiated'){
                        window.location.href = "/bkash/subscription_payments/" + subscription_payment;
                    } else {
                        window.location.href = "/bkash/subscription_payment/" + subscription_payment + "/success";
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
