<!DOCTYPE html>
<html>
<head>
    <title>Financial Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="bg-light p-4">

<div class="container-fluid">
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Total AR</h6>
                <h4>${{ number_format($ar) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Total AP</h6>
                <h4 class="text-danger">${{ number_format($ap) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Equity Ratio</h6>
                <h4>{{ $equity_ratio }}%</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Debt Equity</h6>
                <h4>{{ $debt_equity }}%</h4>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card p-3">
                <div id="dso"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <div id="dpo"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <div id="dsi"></div>
            </div>
        </div>
    </div>

    <div class="card mt-4 p-3">
        <div id="workingCapital"></div>
    </div>
</div>

<script>
function radialChart(id, value, label, color) {
    new ApexCharts(document.querySelector(id), {
        chart: { type: 'radialBar', height: 250 },
        series: [value],
        labels: [label],
        colors: [color]
    }).render();
}

radialChart("#dso", {{ $dso }}, "DSO (Days)", "#FF4560");
radialChart("#dpo", {{ $dpo }}, "DPO (Days)", "#00E396");
radialChart("#dsi", {{ $dsi }}, "DSI (Days)", "#FEB019");

new ApexCharts(document.querySelector("#workingCapital"), {
    chart: { type: 'line', height: 300 },
    series: [{
        name: 'Working Capital',
        data: @json($working_capital)
    }],
    xaxis: {
        categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
    }
}).render();
</script>

</body>
</html>
