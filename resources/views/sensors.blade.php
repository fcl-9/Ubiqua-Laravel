@extends('layouts.inner_pages')

@section('inner-css')
    <style>
        .container-head{
            background-color: #c0e6e7;
        }
        .sensor-font{
            font-weight: bold;
            font-size: 20px;
        }
    </style>
@endsection


@section('inner-content')
    <div class="container-head">
        <img width="40" height="40" src="/img/g1.png">
        <span class="font-header"> Sensors </span>
    </div>
    <div style="margin-top:30px;"></div>
    <div class="row">
        <div class="col-md-4 text-center">
            <span class="sensor-font"> <i class="fa fa-lightbulb-o" aria-hidden="true"></i>   Luminosity</span><br>
            <div id="luminosity"></div>
        </div>
        <div class="col-md-4 text-center">
            <span class="sensor-font"> <i class="fa fa-balance-scale" aria-hidden="true"></i>   Weight</span><br>
            <div id="weight"></div>
        </div>
        <div class="col-md-4 text-center">
            <span class="sensor-font"> <i class="fa fa-bluetooth-b" aria-hidden="true"></i>   Beacons</span><br>
            <div id="beacons"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/loader.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages':['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawCharts);

            /// / Callback that creates and populates a locationData table,
            // instantiates the pie locationChart, passes in the locationData and
            // draws it.
            var maxDataPoints = 10;

            function drawCharts() {
                drawLuminosity();
                drawWeight();
                drawBeacons();
            }

            function drawBeacons() {
                var chart = new google.visualization.LineChart($('#beacons')[0]);

                var options = {
                    hAxis: {
                        title: 'Time'
                    },
                    vAxis: {
                        title: 'Number'
                    },
                    curveType: 'function',
                    animation: {
                        duration: 500,
                        easing: 'linear'
                    },
                    legend: {position: 'none'}
                };

                var data = google.visualization.arrayToDataTable([
                    ['Time', 'Number'],
                    [getTime(), 0]
                ]);
                $.get('http://shelf.local:8484/pi/sensors/beacons',function(result) {
                    if(typeof result.value !== "string") {
                        addDataPoint(result.value.length, chart, data, options);
                    }
                    else {
                        $("#beacons").text(result.value);
                    }
                })
                beaconSocketHandlers('ws://shelf.local:8484/pi/sensors/beacons', chart, data, options);
            }

            function drawWeight() {
                var chart = new google.visualization.LineChart($('#weight')[0]);

                var options = {
                    hAxis: {
                        title: 'Time'
                    },
                    vAxis: {
                        title: 'Weight'
                    },
                    curveType: 'function',
                    animation: {
                        duration: 500,
                        easing: 'linear'
                    },
                    legend: {position: 'none'}
                };

                var data = google.visualization.arrayToDataTable([
                    ['Time', 'Weight'],
                    [getTime(), 0]
                ]);

                socketHandlers('ws://shelf.local:8484/pi/sensors/weight', chart, data, options,"#weight");
            }

            function drawLuminosity() {
                var chart = new google.visualization.LineChart($('#luminosity')[0]);

                var options = {
                    hAxis: {
                        title: 'Time'
                    },
                    vAxis: {
                        title: 'Luminosity'
                    },
                    curveType: 'function',
                    animation: {
                        duration: 500,
                        easing: 'linear'
                    },
                    legend: {position: 'none'}
                };

                var data = google.visualization.arrayToDataTable([
                    ['Time', 'Luminosity'],
                    [getTime(), 0]
                ]);

                socketHandlers('ws://shelf.local:8484/pi/sensors/luminosity', chart, data, options, "#luminosity");
            }

            function beaconSocketHandlers(url, chart, data, options) {
                $("#beacons").text("Please wait until we get some information...");
                var socket = new WebSocket(url); //#A
                socket.onmessage = function (event) { //#B
                    var result = JSON.parse(event.data).value.length;
                    addDataPoint(result, chart, data, options);
                };

                socket.onerror = function (error) { //#C
                    $("#beacons").text("For some reason it's not possible to access this information right now.");
                    console.log('WebSocket error!');
                    console.log(error);
                };
            }

            function socketHandlers(url, chart, data, options, id) {
                $(id).text("Please wait until we get some information...");
                var socket = new WebSocket(url); //#A
                socket.onmessage = function (event) { //#B
                    var result = JSON.parse(event.data).value;
                    addDataPoint(result, chart, data, options);
                };

                socket.onerror = function (error) { //#C
                    $(id).text("For some reason it's not possible to access this information right now.");
                    console.log('WebSocket error!');
                    console.log(error);
                };
            }

            function addDataPoint(dataPoint, chart, data, options) {
                if (data.getNumberOfRows() > maxDataPoints) {
                    data.removeRow(0);
                }
                data.addRow([getTime(), dataPoint]);

                chart.draw(data, options);
            }

            function getTime() {
                var d = new Date();
                return d.toLocaleTimeString();
            }
        });
    </script>
@endsection