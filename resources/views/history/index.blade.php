@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'Radar')">能力雷達</button>
                <button class="tablinks" onclick="openCity(event, 'Line')">歷史得分</button>
                </div>

                <div id="Radar" class="tabcontent">
                   <br/>
                   <div id="radar"></div>
                </div>
                
                <div id="Line" class="tabcontent">
                    <select>
                        <option></option>
                    @foreach($tags_all as $tag)
                        <option value="{{ $tag }}">{{ $tag }}</option>
                    @endforeach
                    </select>
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>

                <br/>

                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>代號</th>
                            <th>測試時間</th>
                            <th>答題時長</th>
                            <th>題量</th>
                            <th>範圍</th>
                            <th>類型</th>
                            <th>分數</th>
                            <th>詳情</th>
                        </tr>
                    </thead>
                </table>
                
                

            </div>
        </div>
    </div>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
@endsection

@section('footer')
    <style type="text/css">
        ${demo.css}
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js">
    <script src="/assets/highcharts/sand-signika.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(function () {
            openCity(event, 'Radar');
            Highcharts.chart('radar', {

                chart: {
                  polar: true,
                  type: 'area'
                },
              
                title: {
                  text: '能力雷達'
                },
              
                pane: {
                  size: '100%'
                },
              
                xAxis: {
                  categories: {!! $tags_all !!},
                  tickmarkPlacement: 'on',
                  lineWidth: 0
                },
              
                yAxis: {
                  gridLineInterpolation: 'polygon'
                },
              
                tooltip: {
                  shared: true,
                  pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
                },

                series: [{
                  name: '最後 10 次平均分數',
                  data: {!! $testsavg !!},
                  pointPlacement: 'on'
                }]
              
            });


            $('#container').highcharts({
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: '歷史得分'
                }
            });
        });
        
    </script>

    <script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "data": {!! json_encode($tests) !!},
            "pageLength": 5,
            "scrollX": true,
            "columns": [
                { "data": "id", "name": "id" },
                { "data": "created_at", "name": "created_at" },
                { "data": "ended_at", "name": "ended_at" },
                { "data": "totalnumber", "name": "totalnumber" },
                { "data": "tagtype", "name": "tagtype" },
                { "data": "testtype", "name": "testtype" },
                { "data": "point", "name": "point" },
                { "data": "link", "name": "link" }
            ],
            "order": [[ 1, "desc" ]]
        } );
    } );
    </script>

    <script>
        var chart = $('#container').highcharts();
        $('select').on({
            "focus": function() {
                this.selectedIndex = -1;
            },
            "change": function() {
                choice = $(this).val();
                setTimeout(function() {
                    filtered_data = $.grep( {!! json_encode($tests) !!}, function( n, i ) {
                        if (choice==="") return false;
                        return n.tagtype===choice;
                    });
                    var processed_json = new Array();
                    for (i = 0; i < filtered_data.length; i++) {
                        processed_json.push([filtered_data[i].id, filtered_data[i].point]);
                    }

                    var xaxis = processed_json;
                    console.log(processed_json);
                    
                    $('#container').highcharts({
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '歷史得分'
                        },
                        xAxis: {
                            categories: xaxis
                        },
                        yAxis: {
                            title: {
                                text: 'Point '
                            },
                            tickPositions: [0, 20,40,60,80,100]
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            }
                        },
                        series: [{
                            name: "points",
                            data: processed_json
                        }]
                    });
                }, 0);
            }
        });
    </script>

    @endsection

