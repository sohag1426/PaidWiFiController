@section('contentTitle')
<h3>Send SMS </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('sms_histories.store') }}" method="POST">
            @csrf
            <!--mobile-->
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
            </div>
            <!--/mobile-->
            <!--message-->
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" aria-describedby="length" rows="3"
                    onkeyup="charcountupdate(this.value)" required></textarea>
                <small id="length" class="form-text text-muted"></small>
            </div>
            <!--message-->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>

</div>

@endsection

@section('pageJs')

<script>
    function charcountupdate(str) {
        var lng = str.length;
        document.getElementById("length").innerHTML = lng + ' character';
    }
</script>

@endsection
