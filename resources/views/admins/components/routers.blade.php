@section('content')

<div class="card">

    <div class="card-body">

        <table id="data_table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" style="width: 2%">#</th>
                    <th scope="col">IP</th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($routers as $router )
                <tr>
                    <th scope="row">{{ $router->id }}</th>
                    <td>{{ $router->nasname }}</td>
                    <td>{{ $router->description }}</td>
                    <td>

                        <div class="btn-group" role="group">

                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>

                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                {{-- Configure --}}
                                <a class="dropdown-item"
                                    href="{{ route('routers.configuration.create', ['router' => $router->id]) }}">
                                    Configure
                                </a>
                                {{-- Configure --}}

                                {{-- Check API --}}
                                <a class="dropdown-item" href="{{ route('routers.show', ['router' => $router->id]) }}"
                                    onclick="showWait()">
                                    Check API
                                </a>
                                {{-- Check API --}}

                                {{-- Edit --}}
                                <a class="dropdown-item" href="{{ route('routers.edit', ['router' => $router->id]) }}">
                                    Edit
                                </a>
                                {{-- Edit --}}

                                {{-- Delete --}}
                                <form method="post" action="{{ route('routers.destroy', ['router' => $router->id]) }}"
                                    onsubmit="return confirm('Are you sure to Delete')">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item" type="submit">Delete</button>
                                </form>
                                {{-- Delete --}}

                            </div>

                        </div>

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

</div>

{{-- Notes --}}
<div class="card card-outline card-danger">
    <div class="card-header">
        Notes:
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            Please do not change the router's system identity, If the hotspot service is running on your router.
        </li>
        <li class="list-group-item">
            Please do not change the router's system identity, To disconnect suspended customers from software.
        </li>
        <li class="list-group-item">
            Router's system identity must not contain the "=" character.
        </li>
        <li class="list-group-item">
            Router's system identity must not contain the " " (Whitespace character) character.
        </li>
        <li class="list-group-item">
            If API Connection failed, Hotspot customer's authentication will be failed.
        </li>
    </ul>
</div>
{{-- Notes --}}

@endsection

@section('pageJs')
@endsection
