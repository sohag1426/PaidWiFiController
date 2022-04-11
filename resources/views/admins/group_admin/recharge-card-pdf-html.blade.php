<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Recharge Card</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--particles-js-->
    <link rel="stylesheet" href="/jsPlugins/bootstrap-4.5.3-dist/css/bootstrap.min.css">
</head>

<body class="mt-5">

    <div class="container">

        @foreach ($rows as $row)

        <div class="d-flex flex-row">

            @foreach ($row as $card)

            <div style="width: 20rem;">

                <div class="card mb-3" style="max-width: 18rem;">

                    <h6 style="text-align:center;"> Package: {{ $package->name  }}</h6>

                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Price: {{ $package->price }} {{ config('consumer.currency') }}</li>
                            <li class="list-group-item">Data Limit: {{ $package->volume_limit }}
                                {{ $package->volume_unit }}</li>
                            <li class="list-group-item">PIN: {{ $card->pin }}</li>
                        </ul>

                    </div>

                    <h6 style="text-align:center; font-style: italic;"> Powered By: {{ $user->company }}</h6>

                </div>

            </div>

            @endforeach

        </div>

        @endforeach

    </div>

</body>

</html>
