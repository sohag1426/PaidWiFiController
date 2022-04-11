@extends ('laraview.layouts.topNavLayout')

@section('title')
bkash SMS Payment
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

    <!-- Modal Delete-->
    <div class="modal fade" id="ModalCancelAgreement" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you Sure you want to delete your saved bKash number?</p>

                    <form
                        action="{{ route('bkash_tokenized.sms_payment.cancel_agreement', ['sms_payment' => $sms_payment->id]) }}"
                        method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--/modal Delete-->

    <div class="card-body text-center">

        <div class="card-header bg-info">
            bkash SMS Payment
        </div>

        <p class="card-text">SMS Count: {{ $sms_payment->sms_count }}</p>

        <p class="card-text">Amount: {{ $sms_payment->amount_paid }} TK</p>

        <p class="card-text">Payment Method: Bkash</p>

        <form method="GET"
            action="{{ route('bkash_tokenized.sms_payment.create_payment', ['sms_payment' => $sms_payment->id]) }}"
            onsubmit="return showWait()">

            @if ($bkash_checkout_agreement)

            <h4>bKash number (Saved by bKash) :</h4>

            <div class="row">

                <div class="col">
                </div>

                {{-- bkash_number --}}
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="bkash_number" value="{{ $msisdn }}" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="#" role="button" onclick="showCancelAgreement()">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                {{-- bkash_number --}}

                <div class="col">
                </div>

            </div>

            {{-- Use saved bKash number --}}
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="use_saved_bkash_number"
                    name="use_saved_bkash_number" value="1" checked>
                <label class="form-check-label" for="use_saved_bkash_number">Use saved bKash number</label>
            </div>
            {{-- Use saved bKash number --}}

            @else

            <div class="form-row">

                <div class="col-md-4">
                </div>

                {{-- bkash_number --}}
                <div class="form-group col-md-4">
                    <label for="bkash_number" class="sr-only">bKash Number</label>
                    <input type="text" class="form-control text-center" id="bkash_number" name="bkash_number"
                        placeholder="bKash Number" required>
                </div>
                {{-- bkash_number --}}

                <div class="col-md-4">
                </div>

            </div>

            {{-- Save bKash number --}}
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="save_bkash_number" name="save_bkash_number"
                    value="1">
                <label class="form-check-label" for="save_bkash_number">Save bKash number for faster payment</label>
            </div>
            {{-- Save bKash number --}}

            @endif

            <button type="submit" class="btn">
                <img src="/storage/logo/bKash_Payment_logo.png" alt="Pay With bKash">
            </button>

        </form>

    </div>

</div>

@endsection

@section('pageJs')

<script>
    function showCancelAgreement() {
          $('#ModalCancelAgreement').modal({
            show: true
          });
    }
</script>

@endsection
