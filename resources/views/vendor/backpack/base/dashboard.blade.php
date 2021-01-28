@extends(backpack_view('blank'))

@php
use Carbon\Carbon;

    $userCount = App\Models\Device::count();
    $Clients = App\Models\Client::count();
    $Devices = App\Models\Device::count();
    $Widgets = App\Models\Widget::count();

    $ClientLatest = App\Models\Client::whereDate('created_at', Carbon::today())->count();
    $requestsToday = App\Models\Topic::whereDate('created_at', Carbon::today())->count();
    $requestsTotal = App\Models\Topic::count();


    $widgets['before_content'][] =['type' => 'div',
  'class' => 'row',
  'content' => [
    [  'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2',
           'progressClass'	=> 'progress-bar bg-primary',
    'value'       => $Clients,
    'description' => 'Clients',
    'progress'    => 100, // integer
    // 'hint'        => 'Today\'s New Clients: '.$ClientLatest,
],
[
    'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2',
           'progressClass'	=> 'progress-bar bg-warning',
    'value'       => $requestsTotal,
    'description' => 'Requests',
    'progress'    => 100, // integer
    // 'hint'        => 'Today\'s New Requests: '.$requestsToday,




],
[
    'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2',
           'progressClass'	=> 'progress-bar bg-info',
    'value'       => $Devices,
    'description' => 'Device Schemas',
    'progress'    => 100, // integer
    // 'hint'        => '8544 more until next milestone.',




],
[
    'type'        	=> 'progress_white',
          'class'       	=> 'card mb-2 bg-white',
           'progressClass'	=> 'progress-bar bg-danger',
    'value'       => $Widgets,
    'description' => 'Widgets',
    'progress'    => 100, // integer
    //'hint'        => '8544 more until next milestone.',




  ]



  ]
];








    $widgets['before_content'][] = [
  'type'        => 'jumbotron',
  'wrapperClass'=> 'bg-white',
  'heading'     => 'Welcome!',
  'content'     =>'To get started, please connect your device to the following MQTT Broker:<br><br><strong> Host: </strong> hairdresser.cloudmqtt.com<br><strong> port:</strong>  15674<br><strong> Username:</strong>  nhslvltv<br><strong>Password:</strong> 5vJUELr8WG3a',
  'button_link' => backpack_url('device/create'),
  'button_text' => 'Add Device',

];






@endphp

@section('content')
@endsection
