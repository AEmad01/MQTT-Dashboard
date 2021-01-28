<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speed;
use Illuminate\Http\Request;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ChartsApiController extends Controller
{

    public function getTopics()
    {
    }
    public function store(Request $request)
    {





        //
    }
    public function index(Request $request)
    {
        $topic =  $request->all()['topic'];
        $from =  $request->all()['from'];
        $to =  $request->all()['to'];
        $clients= (array)$request->all()['clients'];
        $speeds = DB::table('topics')->select('*', DB::raw('UNIX_TIMESTAMP(created_at)*1000 AS created_at'))->whereBetween('created_at', [$from, $to])->where('message', $topic)->whereIn('client_id',$clients)->latest('created_at')->limit(100)->get();
        $speedsArray=Array();
        foreach ($speeds as $company)
        {$kappa2=(float)($company->created_at);
         $kappa3=intval($company->value);
         $kappa=Array();
            array_push($kappa,$kappa2);
            array_push($kappa,$kappa3);
            array_push ($speedsArray, $kappa);

        }
        return response()->json($speedsArray);



    }
    public function latest(Request $request)
    {
        $topic =  $request->all()['topic'];
        $clients= (array)$request->all()['clients'];
        $latest = DB::table('topics')->where('message', $topic)->whereIn('client_id',$clients)->latest('id')->limit(1)->get()->pluck('value');


        $kappa=Array();
        array_push($kappa,$latest);
        return response()->json($latest);



    }
    public function latestWithTime(Request $request)
    {
        $topic =  $request->all()['topic'];
        $clients= (array)$request->all()['clients'];
        //$latest = DB::table('topics')->where('message', $topic)->whereIn('client_id',$clients)->latest('id')->limit(1)->get()->pluck('value');
        $latest = DB::table('topics')->select('*', DB::raw('UNIX_TIMESTAMP(created_at)*1000 AS created_at'))->where('message', $topic)->whereIn('client_id',$clients)->latest('id')->limit(1)->get();


        $kappa=Array();
        array_push($kappa,$latest);
        return response()->json($latest);



    }
    public function latest20(Request $request)
    {
        $topic =  $request->all()['topic'];
        $clients= (array)$request->all()['clients'];
        //$latest = DB::table('topics')->where('message', $topic)->whereIn('client_id',$clients)->latest('id')->limit(1)->get()->pluck('value');
        $speeds = DB::table('topics')->select('*', DB::raw('UNIX_TIMESTAMP(created_at)*1000 AS created_at'))->where('message', $topic)->whereIn('client_id',$clients)->latest()->take(20)->get();

        $speedsArray=Array();
        foreach ($speeds as $company)
        {$kappa2=(float)($company->created_at);
         $kappa3=intval($company->value);
         $kappa=Array();
            array_push($kappa,$kappa2);
            array_push($kappa,$kappa3);
            array_push ($speedsArray, $kappa);

        }
        return response()->json($speedsArray);




    }
    public function getUnit(Request $request)
    {
        $topic =  $request->all()['topic'];

    }
    public function percentage(Request $request)
    {
        $topic =  $request->all()['topic'];
        //$clients= (array)$request->all()['clients'];
        $total =DB::table('topics')->where('message',$topic)
        ->count();
      //  $table=DB::table('topics');
      $maxValue =DB::table('topics')->where('message',$topic)->max('value');
      $minValue =DB::table('topics')->where('message',$topic)->min('value');


        $checkAlpha=ctype_alpha($maxValue);
        if(!$checkAlpha)
       {
        $increment = $maxValue/1;
        $ranges[]=floor($minValue);
        $count=1;
if ($increment>100)
{
    $increment=100;
    $count=$maxValue/$increment;
}
        for($i=1;$i<$count+1;$i++)
        {

            $ranges[]=ceil($minValue+($increment*$i));
        }//0

        $i=0;
        $percentage=array();
        $table=DB::table('topics')->where('message',$topic);
        for ($i=0;$i<$count;$i++)
        {
            $table2=clone $table;
            $name=$ranges[$i]."-".$ranges[$i+1];

            $search=($table2->whereBetween('value', [(int)$ranges[$i], (int)$ranges[$i+1]])->count());
            if ($search>0)
           {
            $value =($search)*100.0/$total;
            if ($value>0.1)
            $percentage[] = array('name'=>$name, 'y'=>$value);
           }
        }



        return response()->json($percentage);
    }
    else
    {

        $i=0;
        $table=DB::table('topics')->where('message',$topic)->select( DB::raw('DISTINCT(value)'))->get();//unique countries
        $table3=DB::table('topics')->where('message',$topic)->get();//all location entries
        $total=sizeof($table3->toArray());

        // for ($i=0;$i<sizeof($table)-1;$i++)
        // {

        //     $name=$ranges[$i]."-".$ranges[$i+1];
        //     $search=($table2->whereBetween('value', [$ranges[$i], $ranges[$i+1]])->count());
        //     $percentage[] = array('name'=>$name, 'y'=>($search)*100.0/$total);

        // }
        foreach($table as $record)
        {
            $records=clone $table3;

            $test=DB::table('topics')->select(DB::raw('DISTINCT(client_id)'))->where('value',strval($record->value))->get()->count();
            //$search=(DB::table('topics')->where('message',$topic)->where('value', $record->value)->count());
            $percentage[] = array('name'=>$record->value, 'y'=>$test*100.0/$total);
        }



        return response()->json($percentage);
    }


    }


    public function pyramid(Request $request)
    {
        $checkAlpha=ctype_alpha($maxValue);
        if(!$checkAlpha)
       {
        $topic =  $request->all()['topic'];
        //$clients= (array)$request->all()['clients'];
        $total =DB::table('topics')->where('message',$topic)
        ->count();
        $maxValue =DB::table('topics')->where('message',$topic)->max('value');
        $minValue =DB::table('topics')->where('message',$topic)->min('value');
        $increment = $maxValue/10;
        $ranges[]=floor($minValue);
        for($i=1;$i<11;$i++)
        {

            $ranges[]=ceil($minValue+($increment*$i));
        }//0

        $i=0;
        for ($i=0;$i<10;$i++)
        {
            $name=$ranges[$i]."-".$ranges[$i+1];
            if ((DB::table('topics')->where('message',$topic)->whereBetween('value', [$ranges[$i], $ranges[$i+1]])->count())>0)
            $percentage[] = array($name, (DB::table('topics')->where('message',$topic)->whereBetween('value', [$ranges[$i], $ranges[$i+1]])->count())*100.0/$total);

        }


        usort($percentage, function ($a, $b) {
            return $b[1] <=>$a[1] ;
        });
        return response()->json($percentage);

    }

    }
       public function clients()
    {

        $client = DB::table('clients')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as clients'))
        ->groupBy('date')
        ->get();
        $speedsArray=Array();
        foreach ($speeds as $company)
        {$kappa2=$company->created_at;
         $kappa3=intval($company->value);
         $kappa=Array();
            array_push($kappa,$kappa2);
            array_push($kappa,$kappa3);
            array_push ($speedsArray, $kappa);

        }
        return response()->json($speedsArray);



    }
    public function vi()
    {
        return view('lineChartView');
    }

    public function showClients()
{
// show a form that does something
}
}
