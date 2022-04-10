@if (session('success'))
<script type="text/javascript">
    $(function() {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 6000
            });

            Toast.fire({
                icon: 'success',
                title:  '{{ session('success') }}'
            })
        });

</script>
@endif

@if (session('error'))
<script type="text/javascript">
    $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 6000
            });

            Toast.fire({
                icon: 'error',
                title:  '{{ session('error') }}'
            })
        });

</script>
@endif

@if (Auth::user())

<script>
    $(document).ready(function () {
        if ( $( "#global-customer-search" ).length ) {
            $.ajax({
                url: "/admin/global-customer-search"
                }).done(function (result) {
                    let collections = jQuery.parseJSON(result);
                    $("#global-customer-search").autocomplete({
                    source: collections,
                    minLength: 2,
                    autoFocus: true,
                    position: { my : "top+20%", at: "center"}
                });
            });
        }
    });

    function globalSerachCustomer(query) {
        if (query.length > 1) {
            $("#global-search-modal-title").html("Customer Details");
            $("#GlobalSearchModalBody").html('<div class="overlay-wrapper"><div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>');
            $('#modal-global-search').modal('show');
            $.get( "/admin/global-customer-search/" + query, function( data ) {
                $("#GlobalSearchModalBody").html(data);
            });
        }
    }

</script>

@endif

<script>
    $('#data_table').DataTable( {
        responsive: {
            details: true
        },
        "searching": true,
        "lengthChange": true,
        "ordering": false,
        "autoWidth": false
    });

    $("#phpPaging").DataTable({
        "autoWidth": false,
        "info": false,
        "lengthChange": false,
        "ordering": false,
        "paging": false,
        "searching": false,
        responsive: {
            details: true
        }
    });

    function showWait()
    {
        $('#ModalShowWait').modal({
            backdrop: 'static',
            show: true
        });
        return true;
    }

    function modalDataTable()
    {
        $('#modal_table').DataTable( {
            responsive: {
                details: true
            },
            "searching": false,
            "lengthChange": false,
            "ordering": false,
            "autoWidth": false
        });
    }

    function callURL(url) {
        $.get(url, function(data) {
            Swal.fire({
                position: 'top-end',
                toast: false,
                icon: 'success',
                title: data,
                showConfirmButton: false,
                timer: 1000
            });
        });
    }

</script>
