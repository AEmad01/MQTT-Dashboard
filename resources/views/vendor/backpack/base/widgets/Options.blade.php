<div class="col-sm-12">
    <div class="card">
        <p>

          </p>
          <div id="mainGraph">




      <div id ="cardbody" class="card-body">
        <div class="{{ $widget['wrapperClass'] ?? '' }}">

            <figure class="highcharts-figure">
                <div class="pad-fix"id="container"></div>

            </figure>
<div>

@php
$metrics = $widget['metrics'];


@endphp




<div class="col-sm-6">

        <p>
            <a class="btn btn-outline-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              Options
            </a>
          </p>

          <div class="custom-control custom-checkbox">


        </div>
          <div class="collapse col-sm-12" id="collapseExample">
            <div class="custom-control custom-checkbox">

        </div>

        @php
            $levels=array();
        @endphp
        @foreach ($metrics as $metric)
@php
$tempMetric=$metric;

$level = explode("/",$tempMetric)[1];
if(!in_array($level,$levels))
{
    $levels[]=$level;
}
@endphp
@endforeach
@foreach($levels as $level)
<p>
    <a class="btn btn-primary" data-toggle="collapse" href="#{{ucwords($level)}}" role="button" aria-expanded="false" aria-controls="{{ucwords($level)}}">
      {{ucwords($level)}}
    </a>

  </p>
  <div class="collapse" id="{{ucwords($level)}}">
    <div class="card card-body">

@foreach($metrics as $metric)

@php
$tempMetric=$metric;

$metricid = str_replace('/','-',$tempMetric);
$metric =  ucwords(str_replace(explode("/",$metric)[0],"",str_replace('/',' ',$metric)));

@endphp
{{-- @if (strtolower (explode("/",$tempMetric)[1])!=$level)
{
    @break
}
@endif --}}

@if (strtolower (explode("/",$tempMetric)[1])==$level)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="{{$metricid}}">
            <label class="custom-control-label" for="{{$metricid}}">{{$metric}}</label>

        </div>
        @endif
@endforeach
</div>
</div>

@endforeach
    </div>    </div>
</div>
            </div>
            <style>.highcharts-credits{display:none}</style>

            <style>



             </style>


    </div>    </div></div>
    <script>
        var from;
        var to;
        function initChart(from,to)
        {

    let topic = '<?php echo($widget['topicToPost']); ?>';
    let name =topic.split("/")[2];
    createChart(topic,name);
    }

    initChart();


    </script>



<script>

var metrics = <?php echo json_encode($metrics);?>;
metrics.forEach(function(item, index) {
    console.log(item);

    let metric = item.split('/').join('-');

    console.log(metric);
console.log('kappa');

    $(`#${metric}`).change(function() {
        if ($(this).prop('checked')) {
            console.log(item);
            addData(metric,item);
        } else {
            removeData(metric,item);
        }
    })
});
// $('#realtime').change(function() {
//     var real=$('#realtime').prop('checked');



// })

 </script>




@php
 $widget['crud']->removeAllFields();
            // $widget['crud']->addField(
            // [   // date_range
            //     'name' => ['created_at', 'created_at    '], // db columns for start_date & end_date
            //     'label' => 'Date and Time Range',
            //     'type' => 'date_range',
            //     // OPTIONALS
            //     'default' => ['2020-03-28 01:01', '2020-04-05 02:00'], // default values for start_date & end_date
            //     'date_range_options' => [
            //         // options sent to daterangepicker.js
            //         'timePicker' => true,
            //         'locale' => ['format' => 'DD/MM/YYYY HH:mm']
            //     ]
            // ]);
//             $widget['crud']->addField(
//                 [   // select_from_array
//     'name' => 'typePicker',
//     'label' => "Chart Type",
//     'type' => 'select_from_array',
//     'options' => ['line' => 'line', 'column' => 'column','pie'=>'pie'],
//     'allows_null' => false,
//     'default' => 'Line',
//     // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
// ]);




@endphp


@php

@endphp


