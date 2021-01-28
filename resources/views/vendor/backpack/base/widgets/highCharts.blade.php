<div class="{{ $widget['wrapperClass'] ?? '' }}">

<figure class="highcharts-figure">
<div class="card-header "> <div class="highcharts-title"> {{$widget['name']}} </div></div>
    <div class="pad-fix"id="<?php echo($widget['name']);?>"></div>

</figure>
</div>
<style>.highcharts-credits{display:none}</style>
<script>
    function initChart()
    {
let topic = '<?php echo($widget['topicToPost']); ?>';
let name = '<?php echo($widget['name']); ?>';
createChart(topic,name);
}
initChart();

</script>
<style>



 </style>
