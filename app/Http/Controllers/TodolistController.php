<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use Carbon\Carbon;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $tdolist=new Todolist();
        $tdolist->task=$request->task;
        $tdolist->due_date=$request->date;
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
        $tdolist=Todolist::find($req->id);
        $tdolist->delete();
        $tdolists=Todolist::orderBy('id','desc')->get();
        return $tdolists;
        
    }
    public function changeStatus(Request $req)
    {
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
}
