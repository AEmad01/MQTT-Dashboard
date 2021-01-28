<span>
    @php
    $value=$column['name'];

    $client_id=$entry->client_id;
       $last_seen = App\Models\Client::where('client_id',$client_id)->pluck('last_seen');
       $diff_time=(strtotime(date("Y/m/d H:i:s"))-strtotime($last_seen[0]))/60;
if ($diff_time>2)
{
    echo('<span class="badge badge-danger">'.'Offline'.'</span>');

}
else {
    echo('<span class="badge badge-success">'.'Online'.'</span>');

}
    //echo($topicValue[0]['value']);
    $crud->query=0;
   @endphp
    </span>
