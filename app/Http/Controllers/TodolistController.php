<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use Carbon\Carbon;
use Config;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ip = '134.0.218.66';
        // $ip = $request->ip();
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        $time =Config::set('app.timezone',$timezone ?? config('app.timezone'));
        
        $todolists=Todolist::orderBy('id','desc')->get();
        return view('todolist',compact('todolists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return Config::get('app.timezone');
        
        
        // return $request->ip();
         $ip = '134.0.218.66';
         //$ip = $request->ip();
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        $time =Config::set('app.timezone',$timezone ?? config('app.timezone'));
        
        // return $timezone;
        // echo date('Y/m/d H:i:s');
        $tdolist=new Todolist();
        $tdolist->task=$request->task;
        $tdolist->due_date=$request->date;
        $tdolist->time=$request->time;
        $tdolist->status=2;
        $tdolist->save();
        $todolists=Todolist::orderBy('id','desc')->get();
        return $todolists;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ip = $request->ip();
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        $time =Config::set('app.timezone',$timezone ?? config('app.timezone'));
        
        // For Filter
        $status=$request->status;
        if ($status=='0') {
            $todolists=Todolist::orderBy('id','desc')->get();
        } else {
            $todolists=Todolist::where('status',$status)->orderBy('id','desc')->get();
        }
        
        return $todolists;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $ip = $request->ip();
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        $time =Config::set('app.timezone',$timezone ?? config('app.timezone'));
        
        // return $request->all();
        $tdolist=Todolist::find($request->id);
        $tdolist->task=$request->task;
        $tdolist->save();
        $tdolists=Todolist::orderBy('id','desc')->get();
        return $tdolists;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function delete(Request $req)
    {
        $ip = $req->ip();
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        $time =Config::set('app.timezone',$timezone ?? config('app.timezone'));
        
        $tdolist=Todolist::find($req->id);
        $tdolist->delete();
        $tdolists=Todolist::orderBy('id','desc')->get();
        return $tdolists;
        
    }
    public function changeStatus(Request $req)
    {
        $ip = $req->ip();
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        $time =Config::set('app.timezone',$timezone ?? config('app.timezone'));
        
        $status='';
        $tdolist=Todolist::find($req->id);
        if ($tdolist->status==1) {
            $tdolist->status=2;
            $status='changed';
        }elseif ($tdolist->status==2) {
            $tdolist->status=1;
            $status='changed';
        }
        $tdolist->save();
        $tdolists=Todolist::orderBy('id','desc')->get();
        return response()->json(['status'=>$status,'data'=>$tdolists]);
    }

    public function checkHasDue(Request $request)
    {
        $ip = $request->ip();
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        $time =Config::set('app.timezone',$timezone ?? config('app.timezone'));
        
        $currentDate=Carbon::now()->format('Y-m-d');
        // return $currentDate;
        $checkTodolists=Todolist::where('status',2)->where('due_date','<',$currentDate)->get();
        foreach ($checkTodolists as $key => $task) {
            $task->status=3;
            $task->save();
        }
        $tdolists=Todolist::orderBy('id','desc')->get();
        return $tdolists;
    }
}
