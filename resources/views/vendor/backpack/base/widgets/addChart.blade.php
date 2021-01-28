
@php
    $widgets =  App\Models\Widget::all()->toArray();
    $client=$widget['client_id'];
    $deviceID=App\Models\Client::where('client_id','=',$client)->get()->pluck('device_id');
    $device = App\Models\Device::where('id',$deviceID[0])->get()->pluck('name')[0];
@endphp


<script>
var array = <?php echo json_encode($widgets); ?>;

$('div[aria-label="Chart menu"]').append('<button style="margin-top:30px;" id="injectButton" type="button" class="btn btn-primary">Add</button>');
$('div[class="container-fluid animated fadeIn"]').append('    <div id="container"class="row row-cols-2"> </div>');
array.sort((a, b) => (a["lft"] > b["lft"]) ? 1 : -1)

array.forEach(function(item,index) {
    var device = "<?php echo $device ?>"; // "A string here"

if (item['device']==device)
  {  $('#container').append(
    ` <div class=\"col-sm-${item['size']}\">\r\n      \r\n    <div class=\"card\">\r\n     \r\n      <div class=\"card-body\">\r\n        <figure class=\"highcharts-figure\">\r\n            <div id=\"${item['id']+item['topic'].split("/").join("")}\">\r\n\r\n\r\n\r\n            <\/div>\r\n          \r\n          <\/figure>\r\n        \r\n      <\/div>      <\/div>      <\/div>      <\/div>`
);
  }else {
      return;
  }
var clientId = "<?php echo $client ?>"; // "A string here"

var name=item['topic'].split("/").join(" ");
    name = name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();});
    console.log(item['device']);
if (item['type']=='gauge')
{
    var chart;
    var name=item['topic'].split("/").join(" ");
    name = name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();});


    $.getJSON(
    '/api/latest?topic='+item['topic']+'&clients='+clientId,
    function (data) {
 chart = Highcharts.chart( item['id']+item['topic'].split("/").join(""),  {

chart: {
    type: 'gauge',
    plotBackgroundColor: null,
    plotBackgroundImage: null,
    plotBorderWidth: 0,
    plotShadow: false
},

title: {
    text: name
},

pane: {
    startAngle: -150,
    endAngle: 150,
    background: [{
        backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
                [0, '#FFF'],
                [1, '#333']
            ]
        },
        borderWidth: 0,
        outerRadius: '109%'
    }, {
        backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
                [0, '#333'],
                [1, '#FFF']
            ]
        },
        borderWidth: 1,
        outerRadius: '107%'
    }, {
        // default background
    }, {
        backgroundColor: '#DDD',
        borderWidth: 0,
        outerRadius: '105%',
        innerRadius: '103%'
    }]
},

// the value axis
yAxis: {
    min: item['min'],
    max: item['max'],

    minorTickInterval: 'auto',
    minorTickWidth: 1,
    minorTickLength: 10,
    minorTickPosition: 'inside',
    minorTickColor: '#666',

    tickPixelInterval: 30,
    tickWidth: 2,
    tickPosition: 'inside',
    tickLength: 10,
    tickColor: '#666',
    labels: {
        step: 2,
        rotation: 'auto'
    },
    title: {
        text: item['unit']
    },
    plotBands: [{
        from: 0,
        to: 0.6*item['max'],
        color: '#55BF3B' // green
    }, {
        from: 0.6*item['max'],
        to: 0.8*item['max'],
        color: '#DDDF0D' // yellow
    }, {
        from: 0.8*item['max'],
        to: item['max'],
        color: '#DF5353' // red
    }]
},

series: [{
    name: name,
    data:[parseInt(data)],
    tooltip: {
        valueSuffix: item['unit'],

    }
}]

},function (chart) { // on complete
        var i = 0;
        chart.renderer.button('<div src="https://image.flaticon.com/icons/svg/565/565722.svg">Edit</div>',00, 00)
            .attr({
                zIndex: 34
            })
            .on('click', function () {
                location.href=`/admin/widget/${item['id']}/edit`;
            })
            .add();
            $('rect[class="highcharts-button-box"]').remove();
    });;});

setInterval(function() {

    $.getJSON(
    '/api/latest?topic='+item['topic']+'&clients='+clientId,
    function (data) {

        chart.series[0].setData([parseInt(data)]);
    });

},1000)


}//endif

if(item['type']=='solidgauge')
{

    var gaugeOptions = {
    chart: {
        type: 'solidgauge',

    },
    title: {
    text: name
},

    pane: {
        center: ['50%', '85%'],
        size: '100%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    exporting: {
        enabled: true
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -180
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};
var svg;
    svg = document.getElementsByTagName('svg');
    if (svg.length > 0) {
        var path = svg[0].getElementsByTagName('path');
        if (path.length > 1) {
            // First path is gauge background
            path[0].setAttributeNS(null, 'stroke-linejoin', 'round');
            // Second path is gauge value
            path[1].setAttributeNS(null, 'stroke-linejoin', 'round');
        }
    }
    var chart;
    $.getJSON(
'/api/latest?topic='+item['topic']+'&clients='+clientId,
function (data) {
    chart = Highcharts.chart( item['id']+item['topic'].split("/").join(""), Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: item['min'],
    max: item['max'],
        // title: {
        //     text: name
        // }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: name,
        data: [parseInt(data)],
        dataLabels: {
            format:
                '<div style="text-align:center">' +
                '<span style="font-size:25px">{y}</span><br/>' +
               `<span style="font-size:12px;opacity:0.4">${item['unit']}</span>` +
                '</div>'
        },
        tooltip: {
            valueSuffix: '',
        enabled:false
        }
    }]

}),function (chart) { // on complete
        var i = 0;

        chart.renderer.button('<img src="https://image.flaticon.com/icons/svg/565/565722.svg">Edit</img>',00, 00)
            .attr({
                zIndex: 3
            })
            .on('click', function () {
                location.href=`/admin/widget/${item['id']}/edit`;
            })
            .add();
            $('rect[class="highcharts-button-box"]').remove();
    } );});

setInterval(function() {

$.getJSON(
'/api/latest?topic='+item['topic']+'&clients='+clientId,
function (data) {

    chart.series[0].setData([parseInt(data)]);
});

},5000)
}

if (item['type']=='pie')
{
    $.getJSON(
'/api/percentage?topic='+item['topic'],
function (data) {
    chart = Highcharts.chart(item['id']+item['topic'].split("/").join(""), {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'

    },
    title: {
        text: name
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}% of Total Devices</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b> {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: name,
        colorByPoint: true,
        data: data
    }]
},function (chart) { // on complete
        var i = 0;

        chart.renderer.button('<img src="https://image.flaticon.com/icons/svg/565/565722.svg">Edit</img>',00, 00)
            .attr({
                zIndex: 3
            })
            .on('click', function () {
                location.href=`/admin/widget/${item['id']}/edit`;
            })
            .add();
            $('rect[class="highcharts-button-box"]').remove();
    });
})}
if (item['type']=='pyramid')
{
    $.getJSON(
'/api/pyramid?topic='+item['topic'],
function (data) {
    chart = Highcharts.chart(item['id']+item['topic'].split("/").join(""), { chart: {
        type: 'pyramid'
    },
    title: {
        text: name,
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b> ({point.y:,.0f})',
                softConnector: true
            },
            center: ['50%', '50%'],
            width: '75%'
        }
    },
    legend: {
        enabled: false
    },
    series: [{
        name: name,
        data: data,


    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                plotOptions: {
                    series: {
                        dataLabels: {
                            inside: true
                        },
                        center: ['50%', '50%'],
                        width: '75%',
                    }
                }
            }
        }]
    }},function (chart) { // on complete
        var i = 0;

        chart.renderer.button('<img src="https://image.flaticon.com/icons/svg/565/565722.svg">Edit</img>',00, 00)
            .attr({
                zIndex: 3
            })
            .on('click', function () {
                location.href=`/admin/widget/${item['id']}/edit`;
            })
            .add();
            $('rect[class="highcharts-button-box"]').remove();
    });

})
}
 if (item['type']=='counter') {
    $.getJSON(
    '/api/latest?topic='+item['topic']+'&clients='+clientId,
    function (data) {
$('#'+item['id']+item['topic'].split("/").join("")).append(`<div class=\"card mb-2 bg-white\">\r\n    <div class=\"card-body\">\r\n            <div class=\"text-value\">${data}<\/div>\r\n      \r\n            <div>${name}<\/div>\r\n            \r\n            <div class=\"progress progress-xs my-2\">\r\n        <div class=\"progress-bar bg-primary\" role=\"progressbar\" style=\"width: 100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\"><\/div>\r\n      <\/div>\r\n            \r\n          <\/div>\r\n\r\n      <\/div>

`);});
 }

// if (item['type']=='line')
// {
//     $.getJSON(
// '    '/api/charts?topic='+item+'&from='+from+'&to='+to+'&clients='+clientId,
// function (data) {
//     chart = Highcharts.chart(item['id']+item['topic'].split("/").join(""), {





//     })})}

})





    </script>
