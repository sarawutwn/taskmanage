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

            $.ajax({
                type: "GET",
                url: "/api/report/" + 2,
                success: function(response) {
                    console.log(response)
                }
            });
        });

        google.charts.load('current', {
            'packages': ['gantt']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Task ID');
            data.addColumn('string', 'Task Name');
            data.addColumn('string', 'Resource');
            data.addColumn('date', 'Start Date');
            data.addColumn('date', 'End Date');
            data.addColumn('number', 'Duration');
            data.addColumn('number', 'Percent Complete');
            data.addColumn('string', 'Dependencies');

            data.addRows([
                ['CRUD', 'CRUD', null,
                    new Date(2021, 2, 22), new Date(2021, 5, 20), null, 50, null
                ],
                ['Project', 'Project 2020', null,
                    new Date(2021, 1, 21), new Date(2021, 3, 20), null, 80, null
                ],
                ['Task', 'Task 2020', null,
                    new Date(2020, 12, 21), new Date(2021, 2, 20), null, 70, null
                ],
                ['2014Winter', 'Winter 2014', 'winter',
                    new Date(2014, 11, 21), new Date(2015, 2, 21), null, 100, null
                ],
                ['2015Spring', 'Spring 2015', 'spring',
                    new Date(2015, 2, 22), new Date(2015, 5, 20), null, 50, null
                ],
                ['2015Summer', 'Summer 2015', 'summer',
                    new Date(2015, 5, 21), new Date(2015, 8, 20), null, 0, null
                ],
                ['2015Autumn', 'Autumn 2015', 'autumn',
                    new Date(2015, 8, 21), new Date(2015, 11, 20), null, 0, null
                ],
                ['2015Winter', 'Winter 2015', 'winter',
                    new Date(2015, 11, 21), new Date(2016, 2, 21), null, 0, null
                ],
                ['Football', 'Football Season', 'sports',
                    new Date(2014, 8, 4), new Date(2015, 1, 1), null, 100, null
                ],
                ['Baseball', 'Baseball Season', 'sports',
                    new Date(2015, 2, 31), new Date(2015, 9, 20), null, 14, null
                ],
                ['Basketball', 'Basketball Season', 'sports',
                    new Date(2014, 9, 28), new Date(2015, 5, 20), null, 86, null
                ],
                ['Hockey', 'Hockey Season', 'sports',
                    new Date(2014, 9, 8), new Date(2015, 5, 21), null, 89, null
                ]
            ]);

            var options = {
                height: 400,
                gantt: {
                    trackHeight: 30
                }
            };

            var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

            chart.draw(data, options);

            var chart_1 = new google.visualization.Gantt(document.getElementById('chart_div_1'));

            chart_1.draw(data, options);
        }

    </script>
@endsection
