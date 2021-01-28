<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessTopic;
use App\Models\Client;
use App\Models\Topic;
use App\Models\Device;

class TopicsApiController extends Controller
{
    public function index(Request $request){


        dispatch(new ProcessTopic($request->all()));
    }

}
