@section('contentTitle')
<h3>Dashboard</h3>
@endsection

@section('content')

<!-- Modal -->
<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCenterTitle">Welcome!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p> <i class="fas fa-exclamation-circle"></i> The minimum configuration is incomplete.</p>
                <p> <i class="far fa-play-circle"></i> Please Click on <span class="text-primary">Let's Start </span>
                    button to start configuration.</p>
                <a class="btn btn-primary" href="{{ route('configuration.next', ['operator' => Auth::user()->id]) }}"
                    role="button">Let's Start <i class="far fa-play-circle"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- /modal -->


@can('viewWidgets')
@include('admins.components.dashboard-widgets')
@endcan

<div class="card">
    <div class="card-body">
        <div class="chart">
            <canvas id="barChart"
                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
</div>

@endsection

@section('pageJs')

@can('viewWidgets')
@include('admins.components.dashboard-js')
@endcan

<script src="/themes/adminlte3x/plugins/chart.js/Chart.min.js"></script>

<script>
    $(function() {

        let ChartUrl = "{{ route('admin.dashboard.chart') }}";

        $.get(ChartUrl, function(data) {

            let chartData = jQuery.parseJSON(data);

            var barChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                        label: 'Cash In',
                        backgroundColor: 'rgba(40,167,69,0.9)',
                        data: [
                            chartData.in.January,
                            chartData.in.February,
                            chartData.in.March,
                            chartData.in.April,
                            chartData.in.May,
                            chartData.in.June,
                            chartData.in.July,
                            chartData.in.August,
                            chartData.in.September,
                            chartData.in.October,
                            chartData.in.November,
                            chartData.in.December
                        ]
                    },
                    {
                        label: 'Cash Out',
                        backgroundColor: 'rgb(255, 0, 0)',
                        data: [
                            chartData.out.January,
                            chartData.out.February,
                            chartData.out.March,
                            chartData.out.April,
                            chartData.out.May,
                            chartData.out.June,
                            chartData.out.July,
                            chartData.out.August,
                            chartData.out.September,
                            chartData.out.October,
                            chartData.out.November,
                            chartData.out.December
                        ]
                    }
                ]
            };

            var barChartCanvas = $('#barChart').get(0).getContext('2d');

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            };

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });

        });

    });

    $(document).ready(function () {
        let role = "{{ Auth::user()->role }}";
        let url = "{{ route('configuration.check', ['operator' => Auth::user()->id ]) }}";
        if(role == "group_admin" || role == 'operator'){
            $.get(url, function( data ) {
                if(data == 1){
                    $('#modal-default').modal({
                        backdrop: 'static',
                        show: true
                    });
                }
            });
        }
    });

</script>

@endsection
