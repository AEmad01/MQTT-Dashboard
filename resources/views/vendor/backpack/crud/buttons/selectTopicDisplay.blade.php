
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

@php
        $topicsListen = App\Models\Device::pluck('topics');
        $topicsArray=array();
        if(isset($topicsListen))
        foreach($topicsListen as $topicCategory)
        for ($i = 0; $i < count(json_decode($topicCategory)); $i++) {
            $topicsArray[] = json_decode($topicCategory)[$i]->topic;
        }
$topicsView = App\Models\clientView::all()->pluck('topicDisplay')->toArray();
        @endphp









@if ($crud->hasAccess('update'))
<select id="selectTopics" class="dropdown-menu" style="width: 100%;" name="states[]" multiple="multiple">
@if(isset($topicsArray))
    @foreach($topicsArray as $topic)
    @if (in_array($topic,$topicsView))
    <option selected="selected"value="{{$topic}}">{{$topic}}</option>



    @else

    <option value="{{$topic}}">{{$topic}}</option>


    @endif

    @endforeach
    @endif
  </select>
@endif

<script>

  $(document).ready(async function() {
   await $.ajax({
  type: "GET",
  url: "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js",
  dataType: "script"
});
$('#selectTopics').select2({
    placeholder: "Select Metrics to Display",
});
$('#selectTopics').on("select2:select", function(e) {
    var items= $(this).val();
    console.log(items);
    items.forEach(function(item,index) {
        $.ajax({
  type: "POST",
  async:true,
  url:"/api/addcolumn?name="+item
});
window.location.reload(false);

console.log(item);
    });


});
$('#selectTopics').on("select2:unselect", function(e) {
    var items= $(this).val();


        $.ajax({
  type: "POST",
  async:true,
  url:"/api/removecolumn?name="+e.params.data["id"]

    });
    window.location.reload(false);


});
});

</script>
