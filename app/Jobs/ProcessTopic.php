<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Client;
use App\Models\Device;

class ProcessTopic implements ShouldQueue
{
    private $req;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct( $request)
    {
        $this->req=$request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//id device message value

$topic = new Topic;
$data=$this->req;
$device_id=Device::where('name',explode("/",$data['topic'])[0])->get()->pluck('id');

$topic->value = $data['message'];
if(!is_string($data['message'])){
    $topic->value = intval($data['message']);

}

$topic->device_id =$device_id[0];
$topic->message = $data['topic'];
$topic->client_id = $data['client_id'];
$client = Client::firstOrNew(['client_id' =>$data['client_id'],'device_id'=>$device_id[0]]);
$client->save();
Client::where('client_id',$data['client_id'])->update(['last_seen'=>date("Y-m-d H:i:s")
]);
$topic->save();

    }
}
