
@php
$crud = $data[1];
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



$widgets['before_content'][] = [
'type' => 'div',
'class' => 'row',
'content' => [ // widgets


[
          'type'        => 'Map',
          'metrics'       => $topicsArray,
]


]
];


@endphp




@section('content')
@endsection





