
@php


$crud=$widget['test'];
$index=$widget['index'];

@endphp

<div class="{{ $widget['wrapperClass'] ?? '' }}">
    <div class="content">
    <div class="card-header">
       {!!$widget['name']!!}
       <div class="card-header-actions">
          <div class="card-header-action" target="_blank">
             <small class="text-muted">
                <select class="card-header-actions" id="<?php echo($widget['name']); ?>time">
                   <option class="dropdown-item" value="50000">60 Seconds</option>
                   <option class="dropdown-item"value="50000">10 Seconds</option>
                </select>
                <select class="card-header-actions" id="<?php echo($widget['name']); ?>type">
                   <option value="line">Line</option>
                   <option value="bar">Bar</option>
                   <option value="pie">Pie</option>
                   <option value="radar">Radar</option>

                </select>
             </small>
            </div>
       </div>
    </div>
    <div class="card-body fix-bottom">
       <div class="chart-wrapper">

          <canvas id="<?php echo($widget['name']); ?>" width="686" height="342" class="chartjs-render-monitor"></canvas>
		            </div>
          <div class="card-footer">
             <div class="card-header-actions">
                   <button class="btn btn-block btn-info" role="button" id="<?php echo($widget['name']);?>reset">Reset Zoom</button>
             </div>
             <p>
                <button id = "<?php echo($widget['name']);?>button" class="btn btn-primary" role="button" data-toggle="collapse" data-target="" aria-expanded="true" aria-controls="">
                  Add Data
                </button>
              </p>
              <div class="collapse" id="<?php echo($widget['name']);?>collapsebutton">
                        <!-- Default box -->
                        </select>
                          <form id="<?php echo($widget['name']);?>Form"method="post"
                                  action="submit"
                                  >
                              {!! csrf_field() !!}
                                  @include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
                                  <input type="submit" value="Submit">

                          </form>
              </div>

          </div>
       </div>
    </div>
	    </div>

<script>

                function bpFieldInitSelect2FromArrayElement(element) {
                    let topicArr = "<?php echo($widget['topicToPost']); ?>";
  topic = topicArr;
            if (!element.hasClass("select2-hidden-accessible"))
                {
                    element.select2({
                        theme: "bootstrap"
                    }).on('select2:unselect', function(e) {
                        if ($(this).attr('multiple') && $(this).val().length == 0) {
                            $(this).val(null).trigger('change');
                        }
                    });
                    element.select2({
                        theme: "bootstrap"
                    }).on('select2:select', function(e) {
                        selectedGraph = element[0]['form'].id;
                        selectedGraph = selectedGraph.replace('Form','');
                        selectedArrays = $(this).val();
                        var selectedTopics=[];
                        var AllTopics = <?php echo json_encode($widget['topics']); ?>;
                        selectedArrays.forEach(function(item,index) {
                            selectedTopics.push(AllTopics[item]);
                        })

console.log(topicArr);
                        selectedTopics.push(AllTopics[0].split("/")[0]+"/"+AllTopics[0].split("/")[1]+"/"+selectedGraph);
                         console.log(selectedTopics);
                         let labelName = selectedGraph;

                         let dataMap = {
        'line': {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label:labelName,
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }

                ]
            },
            options: {

                title: {
    display: false
  },
  legend: {
    display: false
  },
  scales: {
    xAxes: [{
      type: 'time',
      distribution: 'series',
      ticks: {
							major: {
								enabled: true,
								fontStyle: 'bold'
							},
							source: 'data',
							autoSkip: true,
							autoSkipPadding: 75,
							maxRotation: 0,
							sampleSize: 100
      },
      time: {
        minUnit: 'day',
        displayFormats: {
          day: 'MMM D',
          week: 'MMM YYYY',
          month: 'MMM YYYY',
          quarter: 	'MMM YYYY'
        }
      }
    }]
  },        plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    enabled: false,
                    mode: 'xy'
                },

                zoom: {
                    enabled: true,
                    drag:true,
                    mode: 'x',
                }
            }
        }

            }

        },
        'bar': {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }]
            },
            options: {


                scales: {
                    xAxes: [{
                        ticks: {

                        }
                    }],
                    yAxes: [{
                        ticks: {

                            beginAtZero: true,
                            min: 0, //dynamic
                            max: 100 //dynamic
                        }
                    }]
                }
            }
        },
        'pie': {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }]
            },
            options: {


                scales: {
                    xAxes: [{
                        ticks: {

                        }
                    }],
                    yAxes: [{
                        ticks: {

                            beginAtZero: true,
                            min: 0, //dynamic
                            max: 100 //dynamic
                        }
                    }]
                }
            }
        },
        'radar': {
            type: 'radar',
            data: {
                labels: [],
                datasets: [{
                    label: labelName, //dynamic
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }]
            },
            options: {


                scales: {
                    xAxes: [{
                        ticks: {

                        }
                    }],
                    yAxes: [{
                        ticks: {

                            beginAtZero: true,
                            min: 0, //dynamic
                            max: 100 //dynamic
                        }
                    }]
                }
            }
        }

    };
    let chartName="<?php echo($widget['name']); ?>";
    let determineChart = $('#'+chartName+'type').val();
    let params = dataMap[determineChart];
    let options = {  'options': {

title: {
display: false
},
legend: {
display: true
},
scales: {
xAxes: [{
type: 'time',
distribution: 'series',
ticks: {
            major: {
                enabled: true,
                fontStyle: 'bold'
            },
            source: 'data',
            autoSkip: true,
            autoSkipPadding: 75,
            maxRotation: 0,
            sampleSize: 100
},
time: {
Unit: 'day',
displayFormats: {
day: 'MMM D',
week: 'MMM YYYY',
month: 'MMM YYYY',
quarter: 	'MMM YYYY'
}
}
}]
},        plugins: {
zoom: {
// Container for pan options
pan: {
    // Boolean to enable panning
    enabled: false,

    // Panning directions. Remove the appropriate direction to disable
    // Eg. 'y' would only allow panning in the y direction
    mode: 'xy'
},

// Container for zoom options
zoom: {
    // Boolean to enable zooming
    enabled: true,
    drag:true,

    // Zooming directions. Remove the appropriate direction to disable
    // Eg. 'y' would only allow zooming in the y direction
    mode: 'x',
}
}
}

}}

                         addLabel(selectedGraph,selectedTopics,chartName,determineChart,params,options,topic,null);
                    });
                }
        }
       mapOptions = '<option value="custom/world.js">' + searchText + '</option>' + mapOptions;
   $("#mapDropdown").append(mapOptions).combobox();

window.paceOptions = {
    ajax: false,
    restartOnRequestAfter: false,
};



function test()
{

let chartName="<?php echo($widget['name']); ?>";
let ctx = document.getElementById(chartName).getContext("2d");
let kappa = '#<?php echo($widget['name']);?>button';
let kappa2 = '#<?php echo($widget['name']);?>collapsebutton';
let labelName = '<?php echo($widget['name']); ?>';
let minValue = 0;
let maxValue = 100;
let resetButton='<?php echo($widget['name']); ?>'+'reset';
let topicArr = "<?php echo($widget['topicToPost']); ?>";
let topic = topicArr;
let determineChart = $('#'+chartName+'type').val();
let updateTime = $('#'+chartName+'time').val();

let options = {  'options': {

title: {
display: false
},
legend: {
display: true
},
scales: {
xAxes: [{
type: 'time',
distribution: 'series',
ticks: {
            major: {
                enabled: true,
                fontStyle: 'bold'
            },
            source: 'data',
            autoSkip: true,
            autoSkipPadding: 75,
            maxRotation: 0,
            sampleSize: 100
},
time: {
Unit: 'day',
displayFormats: {
day: 'MMM D',
week: 'MMM YYYY',
month: 'MMM YYYY',
quarter: 	'MMM YYYY'
}
}
}]
},        plugins: {
zoom: {
// Container for pan options
pan: {
    // Boolean to enable panning
    enabled: false,

    // Panning directions. Remove the appropriate direction to disable
    // Eg. 'y' would only allow panning in the y direction
    mode: 'xy'
},

// Container for zoom options
zoom: {
    // Boolean to enable zooming
    enabled: true,
    drag:true,

    // Zooming directions. Remove the appropriate direction to disable
    // Eg. 'y' would only allow zooming in the y direction
    mode: 'x',
}
}
}

}}
let dataMap = {
        'line': {
            type: 'line',
            data: {
                datasets: [{
                    label: labelName, //dynamic
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }

                ]
            },
            options: {

                title: {
    display: false
  },
  legend: {
    display: false
  },
  scales: {
    xAxes: [{
      type: 'time',
      distribution: 'series',
      ticks: {
							major: {
								enabled: true,
								fontStyle: 'bold'
							},
							source: 'data',
							autoSkip: true,
							autoSkipPadding: 75,
							maxRotation: 0,
							sampleSize: 100
      },
      time: {
        minUnit: 'day',
        displayFormats: {
          day: 'MMM D',
          week: 'MMM YYYY',
          month: 'MMM YYYY',
          quarter: 	'MMM YYYY'
        }
      }
    }]
  },        plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    // Boolean to enable panning
                    enabled: false,

                    // Panning directions. Remove the appropriate direction to disable
                    // Eg. 'y' would only allow panning in the y direction
                    mode: 'xy'
                },

                // Container for zoom options
                zoom: {
                    // Boolean to enable zooming
                    enabled: true,
                    drag:true,

                    // Zooming directions. Remove the appropriate direction to disable
                    // Eg. 'y' would only allow zooming in the y direction
                    mode: 'x',
                }
            }
        }

            }

        },
        'bar': {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: labelName, //dynamic
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }]
            },
            options: {


                scales: {
                    xAxes: [{
                        ticks: {

                        }
                    }],
                    yAxes: [{
                        ticks: {

                            beginAtZero: true,
                            min: minValue, //dynamic
                            max: maxValue //dynamic
                        }
                    }]
                }
            }
        },
        'pie': {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    label: labelName, //dynamic
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }]
            },
            options: {


                scales: {
                    xAxes: [{
                        ticks: {

                        }
                    }],
                    yAxes: [{
                        ticks: {

                            beginAtZero: true,
                            min: minValue, //dynamic
                            max: maxValue //dynamic
                        }
                    }]
                }
            }
        },
        'radar': {
            type: 'radar',
            data: {
                labels: [],
                datasets: [{
                    label: labelName, //dynamic
                    backgroundColor: 'rgba(151, 187, 205, 0.2)',
                    borderColor: 'rgba(151, 187, 205, 1)',
                    pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                    pointBorderColor: '#fff',
                    data: [],
                    borderWidth: 2
                }]
            },
            options: {


                scales: {
                    xAxes: [{
                        ticks: {

                        }
                    }],
                    yAxes: [{
                        ticks: {

                            beginAtZero: true,
                            min: minValue, //dynamic
                            max: maxValue //dynamic
                        }
                    }]
                }
            }
        }

    };


    let params = dataMap[determineChart];


let myChart;




    init(options,myChart,kappa,kappa2,labelName,minValue,maxValue,topicArr,topic,chartName,ctx,determineChart,updateTime,dataMap,myChart,params,resetButton);
}

test();


</script>

<style>
.fix-bottom {
    padding-bottom:0;
} </style>

