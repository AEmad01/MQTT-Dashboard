<div class="col-sm-12">
    <div class="card">
      <div class="card-header">History Graph</div>
      <div class="card-body">
        <div class="{{ $widget['wrapperClass'] ?? '' }}">

            <figure class="highcharts-figure">
                <div class="pad-fix"id="container"></div>

            </figure>
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
