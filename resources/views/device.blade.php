@extends(backpack_view('blank'))


@php
$crud = $data[2];
@endphp

@php
$id = $data[0];
    $device = App\Models\Device::where('id',$id)->get();
    $name = $device->pluck('name');
    $topicsListen = App\Models\Device::where('id',$id)->pluck('topics');
    $topicsArray=array();
    $topicsCount = count(json_decode($topicsListen[0]));



    for($i=0;$i<count(json_decode($topicsListen[0]));$i++)
    {
        $topicsArray[]=json_decode($topicsListen[0])[$i]->topic;
    }
    $content;
    $index=0;
    $categories=array();
    $widgets['after_content'][1] = [

'type' => 'div',
'class' => '',];

$devicetypeid=$id;
$client_id=$data[3];
$client_topics=App\Models\Device::where('name',$name)->pluck('topics');
$requestsFromClient=App\Models\Topic::where('client_id',$client_id)->count();
$widgets['before_content'][] = [
'type' => 'div',
'class' => 'row',
'content' => [ // widgets


      [
        'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2 bg-white',
           'progressClass'	=> 'progress-bar bg-primary',
          'value'       	=> $client_id[0],
          'description' 	=> 'Device ID',
          'progress'    	=> 100, // integer
      ],


[
    'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2 bg-white',
           'progressClass'	=> 'progress-bar bg-info',
          'value'       => $requestsFromClient,
          'description' => 'Requests.',
          'progress'    => 100, // integer
      ],
      [
        'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2 bg-white',
           'progressClass'	=> 'progress-bar bg-warning',
          'value'       => $topicsCount,
          'description' => 'Metrics.',
          'progress'    => 100, // integer
      ],
      [
        'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2 bg-white',
           'progressClass'	=> 'progress-bar bg-danger',
          'value'       => 0,
          'description' => 'Errors.',
          'progress'    => 100, // integer
],
['type' => 'addChart',
'client_id'=>$client_id[0]


],
[
          'type'        => 'Options',
          'crud' => $crud,
          'metrics'       => $topicsArray,
          'topicToPost' =>''



],



]
];



@endphp




@section('content')
@endsection



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
<script src="https://code.highcharts.com/highcharts.js" type="text/javascript" ></script>
<script src="https://code.highcharts.com/highcharts-more.js" type="text/javascript" ></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/funnel.js"  type="text/javascript"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js" type="text/javascript" ></script>
<script src="https://code.highcharts.com/modules/exporting.js"  type="text/javascript"></script>
<script src="https://code.highcharts.com/modules/export-data.js"  type="text/javascript"></script>

<script>



  </script>
<script>

var chart;
var from = "2019-03-14 01:01:00";
var to = "2020-09-30 2:00:00";
var graphed = [];
var type = 'spline';
var clientId = '<?php echo $client_id[0];?>';


window.addEventListener('load', (event) => {

    $('form[id="test"]').appendTo('#collapseExample');

    $('select[name ="typePicker"]').change(function() {
        type = $(this).val();
        changetype(type);
        console.log('changed');


    });
});

function setDate(from, to) {
    from = from;
    to = to;
    console.log(to);
    chart.destroy();
    graphed.forEach(function(item, index) {
        createChart(item, item.split("/")[2], from, to, type);
        if (index == 0) {} else {
            $.getJSON(
                '/api/charts?topic=' + item + '&from=' + from + '&to=' + to + '&clients=' + clientId,
                function(data) {
                    chart.addSeries({
                        name: item.replace('-', ' ').toLowerCase().replace(/\b[a-z]/g, function(letter) {
                            return letter.toUpperCase();
                        }),
                        data: data
                    });
                    console.log('adding' + item);
                });
        }
    }); //from=2019-03-14%2001:01:00
    //to=2019-04-30%202:00:00



}

function changetype(intype) {
    type = intype;
    chart.destroy();
    graphed.forEach(function(item, index) {
        createChart(item, item.split("/")[2], from, to, type);
        if (index == 0) {} else {
            $.getJSON(
                '/api/charts?topic=' + item + '&from=' + from + '&to=' + to + '&clients=' + clientId,
                function(data) {
                    chart.addSeries({
                        name: item.split("/")[2],
                        data: data
                    });
                    console.log('adding' + item);
                });
        }
    }); //from=2019-03-14%2001:01:00
    //to=2019-04-30%202:00:00


}


function bpFieldInitDateRangeElement(element) {
    var $fake = element,
        $start = $fake.parents('.form-group').find('.datepicker-range-start'),
        $end = $fake.parents('.form-group').find('.datepicker-range-end'),
        $customConfig = $.extend({
            format: 'dd/mm/yyyy',
            autoApply: true,
            startDate: moment($start.val()),
            endDate: moment($end.val())
        }, $fake.data('bs-daterangepicker'));

    $fake.daterangepicker($customConfig);
    $picker = $fake.data('daterangepicker');

    $fake.on('keydown', function(e) {
        e.preventDefault();
        return false;
    });

    $fake.on('apply.daterangepicker hide.daterangepicker', function(e, picker) {
        $start.val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
        $end.val(picker.endDate.format('YYYY-MM-DD H:mm:ss'));
        from = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
        to = picker.endDate.format('YYYY-MM-DD H:mm:ss');
        setDate(from, to);
    });
}

function createChart(topic, name, infrom, into, intype) {
    console.log(topic);
    if (infrom != undefined) {
        from = infrom;
    }
    if (into != undefined) {
        to = into;

    }
    if (intype != undefined) {
        type = intype;

    }
    var index = graphed.findIndex(x => x == topic)
    // here you can check specific property for an object whether it exist in your array or not

    if (index === -1) {
        graphed.push(topic);
    }
    $.getJSON(
        '/api/charts?topic=' + topic + '&from=' + from + '&to=' + to + '&clients=' + clientId,
        function(data) {

            // Create a timer

            // Create the chart
            console.log(type + 'type');
            chart = Highcharts.chart('container', {
                chart: {
                    zoomType: 'x',

                     type: type,
                    events: {}
                },
                title: {
                    text: 'History Graph'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' : 'Select Metrics on the left to add them'
                },
                xAxis: {
                    type: 'datetime',
                    minRange: 1,
                },
                plotOptions: {
        series: {
            pointInterval: 24 * 3600 * 1000 // one day
        }
    },
                series: [{
                    name: name,
                    lineWidth: 0.5,
                    data: data
                }]
            }, function(chart) {
                let seriesIndex = chart.series.findIndex(x => x.name === 'Series 1');
                chart.series[seriesIndex].remove();
            });
        }
    );

}
var offset=0;
function addData(name, topic) {
    graphed.push(topic);
    console.log(graphed);
    console.log('gr');
    $.getJSON(
        '/api/charts?topic=' + topic + '&from=' + from + '&to=' + to + '&clients=' + clientId,
        function(data) {
             seriestoadd = chart.addSeries({
                connectNulls: true,
                pointInterval: 10000,
                name: name.replace('-', ' ').toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                }),
                data: data.reverse()

            });
            //realtime
            var len=chart.series.length-1;
            var storedLen=chart.series.length;
            let ser=chart.series[len];

            setInterval(function() {
                $.getJSON(
                    '/api/latestWithTime?topic=' + topic + '&clients=' + clientId,
                    function(data) {
                        let x = parseInt(data[0]['created_at']); // current time
                        let y = parseInt(data[0]['value']);
{if (len==chart.series.length-1)
    {ser.addPoint([x, y], true, true);
    console.log('here')}
                        else
                        ser.addPoint([x, y], false, true);

}
                    });
            }, 1000);
        });

}

function removeData(name, topic) {
    offset--;
    graphed.pop(topic);
    let seriesIndex = chart.series.findIndex(x => x.name === name.replace('-', ' ').toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    }));
    chart.series[seriesIndex].remove();
    console.log('test')

}

        </script>
