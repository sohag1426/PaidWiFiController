@section('content')

<!--modal -->
<div class="modal fade" id="modal-master" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /modal -->

<div class="card card-outline card-danger">

    <div class="card-header">
        <h3 class="card-title font-weight-bold">Operator/Reseller: {{ $operator->name }}</h3>
    </div>

</div>

{{-- Hotspot Packages --}}
<div class="card card-outline card-secondary">

    <div class="card-header">
        <h3 class="card-title">Hotspot Packages</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive-sm">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th scope="col" style="width: 2%">#</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Operator Price</th>
                        <th scope="col">Customer Price</th>
                        <th scope="col">Customer Count</th>
                        <th scope="col">Visibility</th>
                        <th scope="col"></th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($packages->where('connection_type', 'Hotspot')->sortBy('name') as $package)

                    <tr>
                        <td>{{ $package->id }}</td>
                        <td>
                            <a href="#"
                                onclick="showMasterPackage('{{ route('master_packages.show', ['master_package' => $package->mpid]) }}')">
                                {{ $package->name }}
                            </a>
                        </td>
                        <td>{{ $package->operator_price }}</td>
                        <td>{{ $package->price }}</td>
                        <td>{{ $package->customer_count }}</td>
                        <td>{{ $package->visibility }}</td>

                        <td>

                            <div class="btn-group dropleft" role="group">

                                <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>

                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">

                                    {{-- Edit --}}
                                    @can('update', $package)
                                    <a class="dropdown-item"
                                        href="{{ route('packages.edit', ['package' => $package->id]) }}">
                                        Edit
                                    </a>
                                    @endcan
                                    {{-- Edit --}}

                                    {{-- replace --}}
                                    @can('replace', $package)
                                    <a class="dropdown-item"
                                        href="{{ route('packages.replace.create', ['package' => $package->id]) }}">
                                        Replace
                                    </a>
                                    @endcan
                                    {{-- replace --}}

                                    {{-- delete --}}
                                    @can('delete', $package)
                                    <form method="post"
                                        action="{{ route('packages.destroy', ['package' => $package->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                                    </form>
                                    @endcan
                                    {{-- delete --}}

                                </div>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
{{-- Hotspot Packages --}}

@endsection

@section('pageJs')

<script>
    function showMasterPackage(url)
    {
        $("#modal-title").html("Package Details");
        $("#ModalBody").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Loading...</div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Please Wait</div>');
        $('#modal-master').modal('show');
        $.get( url, function( data ) {
            $("#ModalBody").html(data);
        });
    }
</script>

@endsection
