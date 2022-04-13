@section('contentTitle')

<ul class="nav flex-column flex-sm-row ml-4">
    <!--New Operator-->
    <li class="nav-item">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('card_distributors.create') }}">
            <i class="fas fa-plus"></i>
            New Distributor
        </a>
    </li>
    <!--/New Operator-->
</ul>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <table id="data_table" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Amount Due</th>
                    <th scope="col">Store Name</th>
                    <th scope="col">Store Address</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($card_distributors as $card_distributor)
                <tr>
                    <td scope="row">{{ $card_distributor->id }}</td>
                    <td>{{ $card_distributor->name }}</td>
                    <td>{{ $card_distributor->mobile }}</td>
                    <td>{{ $card_distributor->amount_due }}</td>
                    <td>{{ $card_distributor->store_name }}</td>
                    <td>{{ $card_distributor->store_address }}</td>

                    <td>

                        <div class="btn-group" role="group">

                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>

                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                <a class="dropdown-item"
                                    href="{{ route('card_distributors.edit', ['card_distributor' => $card_distributor->id]) }}">
                                    Edit
                                </a>

                                <form method="post"
                                    action="{{ route('card_distributors.destroy', ['card_distributor' => $card_distributor->id]) }}"
                                    onsubmit="return confirm('Are you sure to Delete')">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item" type="submit">Delete</button>
                                </form>

                            </div>

                        </div>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <!--/card body-->

</div>

@endsection

@section('pageJs')
@endsection
