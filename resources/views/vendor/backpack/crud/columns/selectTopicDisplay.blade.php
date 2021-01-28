<span>
@php
$value=$column['name'];

$client_id=$entry->client_id;
    $topicValue=App\Models\Topic::where('message',$value)->where('client_id', $client_id)->latest('id')->limit(1)->get();
//echo($topicValue[0]['value']);
$crud->query=0;
try {
 echo($topicValue[0]['value']);
} catch (Exception $e) {
    echo 'none';
}@endphp
</span>
