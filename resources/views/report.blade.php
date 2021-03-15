@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Case</h3>
            <div id="chart_div"></div>
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

        function getCase() {
            const username = $.cookie('username');
            $.ajax({
                type: "GET",
                url: "/api/report/" + username,
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

                            const timeElapsed = Date.now();
                            const today = new Date(timeElapsed);
                            const current = today.toISOString();
                            const currentDay = current.split('T')

                            let countDay = datediff(parseDate(currentDay[0]), parseDate(end[0]))
                            let percent = 100 / countDay;

                            data.addRow(
                                [
                                    element.id.toString(), element.name, element.projects
                                    .name,
                                    new Date(startDay[0], startDay[1], startDay[2]),
                                    new Date(endDay[0], endDay[1], endDay[2]),
                                    null, percent, null
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
                            'chart_div'));

                        chart.draw(data, options);

                    });
                },
                error: (error) => {
                    // console.error(error)
                    // Swal.fire({
                    //     title: 'Error!',
                    //     text: error.responseJSON.message,
                    //     icon: 'error',
                    // });
                }
            });
        }

        function parseDate(str) {
            var mdy = str.split('-');
            return new Date(mdy[1], mdy[0] - 1, mdy[2]);
        }

        function datediff(first, second) {
            // Take the difference between the dates and divide by milliseconds per day.
            // Round to nearest whole number to deal with DST.
            return Math.round((second - first) / (1000 * 60 * 60 * 24));
        }

    </script>
@endsection
