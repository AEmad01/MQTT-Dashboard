

@php
$metrics = $widget['metrics'];


@endphp




<div class="col-sm-3">
    <div class="card">
      <div class="card-header">Available Metrics</div>
      <div class="card-body">
        @foreach ($metrics as $metric)
@php

$metric = ucwords(str_replace('/','-',$this->storeName));

@endphp
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="{{$metric}}">
            <label class="custom-control-label" for="{{$metric}}">{{$metric}}</label>

        </div>

@endforeach

    </div>    </div>
</div>

<script>

var metrics = <?php echo json_encode($metrics);?>;
metrics.forEach(function(item, index) {
    let metric = item.split("/")[0];
    $(`#${metric}`).change(function() {
        if ($(this).prop('checked')) {
            addData(metric,item);
        } else {
            removeData(metric,item);
        }
    })
});


 </script>
