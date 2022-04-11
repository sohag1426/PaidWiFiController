@section('contentTitle')
<h3>Distributors Payments Download</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <div class="row">
            <div class="col-sm-6">
                <form id="quickForm" method="POST" action="{{ route('distributor_payments_download.store') }}">
                    @csrf

                    <!-- card_distributor_id -->
                    <div class="form-group">
                        <label for="card_distributor_id">Distributor</label>
                        <select name="card_distributor_id" id="card_distributor_id" class="form-control">
                            <option value="">please select...</option>
                            @foreach ($distributors as $distributor)
                            <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <!--/card_distributor_id -->

                    {{-- year --}}
                    <div class="form-group">
                        <label for="year">Year</label>
                        <select name="year" id="year" class="form-control">
                            <option value=''>year...</option>
                            @php
                            $start = date(config('app.year_format'));
                            $stop = $start - 5;
                            @endphp
                            @for($i = $start; $i >= $stop; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    {{--year --}}

                    {{-- month --}}
                    <div class="form-group">
                        <label for="month">Month</label>
                        <select name="month" id="month" class="form-control">
                            <option value=''>month...</option>
                            <option value='January'>January</option>
                            <option value='February'>February</option>
                            <option value='March'>March</option>
                            <option value='April'>April</option>
                            <option value='May'>May</option>
                            <option value='June'>June</option>
                            <option value='July'>July</option>
                            <option value='August'>August</option>
                            <option value='September'>September</option>
                            <option value='October'>October</option>
                            <option value='November'>November</option>
                            <option value='December'>December</option>
                        </select>
                    </div>
                    {{--month --}}

                    <!--date-->
                    <div class='form-group'>
                        <label for='datepicker'>Date</label>
                        <input type='text' name='date' id='datepicker' class='form-control'>
                    </div>
                    <!--/date-->

                    <button type="submit" class="btn btn-dark">Submit</button>

                </form>

            </div>
            <!--/col-sm-6-->

        </div>
        <!--/row-->

    </div>
    <!--/card-body-->

</div>

@endsection

@section('pageJs')

<script>
    $(function() {
        $('#datepicker').datepicker({
            autoclose: !0
        });
    });
</script>

@endsection
