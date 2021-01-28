<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    public $timestamps = false;

    protected $table = 'messages';
    protected $fillable = ['id', 'message','topic','client_id','created_at'];
    protected $primaryKey = 'id';

    public static function api($request)
    {
        $data = json_decode($request);

        messages::create(['message' => $data->message,'topic'=>$data->topic,'client_id'=>$data->client_id,'created_at'=>date("Y-m-d H:i:s")
        ]);
    }
}
