@extends('layouts.master')

@section('content')
    <div class="row-12">
        <div class="col">
            <h3>Project</h3>
            <div id="chart_div"></div>
        </div>

        <div class="col">
            <div class="mt-3">
                <h3>Case</h3>
                <div id="chart_div_1"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //let token = $.cookie('token');

            google.charts.load('current', {
                'packages': ['gantt']
            });

            getCase()
        });

        function getProject() {
            $.ajax({
                type: "GET",
                url: "/api/report/" + 1,
                success: function(response) {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Task ID');
                    data.addColumn('string', 'Task Name');
                    data.addColumn('string', 'Resource');
                    data.addColumn('date', 'Start Date');
                    data.addColumn('date', 'End Date');
                    data.addColumn('number', 'Duration');
                    data.addColumn('number', 'Percent Complete');
                    data.addColumn('string', 'Dependencies');

                    // console.log(response.data)
                    google.charts.setOnLoadCallback(function() {
                        response.data.forEach(element => {
                            /*
                            ['CRUD', 'CRUD', null, new Date(2021, 2, 22), new Date(2021, 5, 20), null, 50, null]

                            start_case_time: "2021-03-14 00:00:00"

                            end_case_time: "2021-03-20 23:59:59"
                            */

                            let start = element.start_case_time.split(" ");
                            let startDay = start[0].split("-");

                            let end = element.end_case_time.split(" ");
                            let endDay = end[0].split("-");

                            data.addRow(
                                [
                                    element.id.toString(), element.name, null,
                                    new Date(startDay[0],
                                        startDay[1],
                                        startDay[2]),
                                    new Date(endDay[0], endDay[1], endDay[2]), null,
                                    element.id, null
                                ]
                            );
                        });

                        var options = {
                            height: 400,
                            gantt: {
                                trackHeight: 30
                            }
                        };

                        var chart = new google.visualization.Gantt(document.getElementById(
                            'chart'));

                        chart.draw(data, options);

                    });

                    // var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

                    // chart.draw(data, options);
                }
            });
        }

        function getCase() {
            $.ajax({
                type: "GET",
                url: "/api/report/" + 1,
                success: function(response) {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Task ID');
                    data.addColumn('string', 'Task Name');
                    data.addColumn('string', 'Resource');
                    data.addColumn('date', 'Start Date');
                    data.addColumn('date', 'End Date');
                    data.addColumn('number', 'Duration');
                    data.addColumn('number', 'Percent Complete');
                    data.addColumn('string', 'Dependencies');

                    // console.log(response.data)
                    google.charts.setOnLoadCallback(function() {
                        response.data.forEach(element => {
                            /*
                            ['CRUD', 'CRUD', null, new Date(2021, 2, 22), new Date(2021, 5, 20), null, 50, null]

                            start_case_time: "2021-03-14 00:00:00"

                            end_case_time: "2021-03-20 23:59:59"
                            */

                            let start = element.start_case_time.split(" ");
                            let startDay = start[0].split("-");

                            let end = element.end_case_time.split(" ");
                            let endDay = end[0].split("-");

                            data.addRow(
                                [
                                    element.id.toString(), element.name, null,
                                    new Date(startDay[0],
                                        startDay[1],
                                        startDay[2]),
                                    new Date(endDay[0], endDay[1], endDay[2]), null,
                                    element.id, null
                                ]
                            );
                        });

                        var options = {
                            height: 400,
                            gantt: {
                                trackHeight: 30
                            }
                        };

                        var chart_1 = new google.visualization.Gantt(document.getElementById(
                            'chart_div_1'));

                        chart_1.draw(data, options);

                    });

                    // var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

                    // chart.draw(data, options);
                }
            });
        }

    </script>
@endsection
