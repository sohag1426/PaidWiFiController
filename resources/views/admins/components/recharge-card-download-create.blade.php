@section('contentTitle')
<h3>Recharge Card Download</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <div class="row">
            <div class="col-sm-6">
                <form id="quickForm" method="POST" action="{{ route('recharge_cards_download.store') }}"
                    autocomplete="off">
                    @csrf

                    <!-- card_distributor_id -->
                    <div class="form-group">
                        <label for="card_distributor_id"><span class="text-danger">*</span>Distributor</label>
                        <select name="card_distributor_id" id="card_distributor_id" class="form-control" required>
                            <option value="">please select...</option>
                            @foreach ($distributors as $distributor)
                            <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <!--/card_distributor_id -->

                    <!--File format-->
                    <div class="form-group">
                        <label for="file_format"><span class="text-danger">*</span>File Format</label>
                        <select class="form-control" id="file_format" name="file_format" required>
                            <option value="">Please select...</option>
                            <option value="PDF">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <!--/File format-->

                    <!-- status -->
                    <div class="form-group">
                        <label for="status">Status (optional)</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">please select...</option>
                            <option value="used">used</option>
                            <option value="unused">unused</option>
                        </select>
                    </div>
                    <!--/status -->

                    <!-- package_id -->
                    <div class="form-group">
                        <label for="package_id">Package (optional)</label>
                        <select name="package_id" id="package_id" class="form-control">
                            <option value="">please select...</option>
                            @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <!--/package_id -->

                    <!--from_date-->
                    <div class='form-group'>
                        <label for='from_date'>
                            From Date of Generate/Used (optional)
                        </label>
                        <input type='text' name='from_date' id='from_date' class='form-control'>
                    </div>
                    <!--/from_date-->

                    <!--to_date-->
                    <div class='form-group'>
                        <label for='to_date'>
                            To Date of Generate/Used (optional)
                        </label>
                        <input type='text' name='to_date' id='to_date' class='form-control'>
                    </div>
                    <!--/to_date-->

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
		$('#from_date').datepicker({
			autoclose: !0
		});
	});

    $(function() {
    	$('#to_date').datepicker({
    		autoclose: !0
    	});
    });
</script>

@endsection
