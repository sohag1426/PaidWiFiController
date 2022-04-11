@section('contentTitle')
<h3>Payments Download </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-sm-6">

                <form method="POST" action="{{ route('customer-payments-download.store') }}">

                    @csrf

                    <!--operator_id-->
                    @if (Auth::user()->role == 'group_admin' || Auth::user()->role == 'super_admin')
                    <div class="form-group">
                        <label for="operator_id">Operator</label>
                        <select class="form-control" id="operator_id" name="operator_id" required>
                            <option value="">Please select...</option>
                            @foreach ($operators as $operator)
                            <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <!--/operator_id-->

                    <!--cash_collector_id-->
                    <div class="form-group">
                        <label for="cash_collector_id">Cash Collector</label>
                        <select class="form-control" id="cash_collector_id" name="cash_collector_id">
                            <option value="">Please select...</option>
                            @foreach (Auth::user()->operators->where('role', 'manager')->push(Auth::user()) as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/cash_collector_id-->

                    {{-- type --}}
                    @if (Auth::user()->role !== 'super_admin')
                    <div class="form-group">
                        <label for="type">Payment type</label>
                        <select name="type" id="type" class="form-control">
                            <option value=''>please select...</option>
                            <option value='Cash'>Cash</option>
                            <option value='Online'>Online</option>
                            <option value='RechargeCard'>RechargeCard</option>
                        </select>
                    </div>
                    @endif
                    {{--type --}}

                    <!--date-->
                    <div class='form-group'>
                        <label for='datepicker'>Date</label>
                        <input type='text' name='date' id='datepicker' class='form-control'>
                    </div>
                    <!--/date-->

                    <!--note-->
                    <div class='form-group'>
                        <label for='note'>Note</label>
                        <input type='text' name='note' id='note' class='form-control'>
                    </div>
                    <!--/note-->

                    {{-- year --}}
                    <div class="form-group">
                        <label for="year">year</label>
                        <select name="year" id="year" class="form-control">
                            <option value=''>please select...</option>
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
                            <option value=''>please select...</option>
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

                    <button type="submit" class="btn btn-dark">Download</button>

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
