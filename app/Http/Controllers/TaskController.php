<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            //code...
            $user  =  Auth::user();
            $tasks = Task::where("user_id", $user->id)->get();

            if(is_null($tasks)){
                return response()->json([
                    "status"=>"fail",
                    "message"=>"No task found"
                ], 401);
            }


            return response()->json([
                "status"=>"success",
                "task"=>$tasks
            ], 200);


        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status"=>"fail",
                "message"=>$th->getMessage()
            ], 500);
        }
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
        //
        try {
            //code...
            $user  =  Auth::user();
            $validatedTask = Validator::make($request->all(), [
                "title"=>'required|String|unique:App\Models\Task,title',
                "description" => 'required|String',
                "expires_at" => 'required'
            ]);

            if($validatedTask->fails()){
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validatedTask -> errors()
                ], 401);
            }

            $task = $request->all();
            $task['user_id'] = $user->id;

            $newTask = Task::create($task);

            return response()->json([
                "status"=>"success",
                "message"=>"Task created successfully",
                "task"=>$newTask
            ], 201);





        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status"=>"fail",
                "message"=>$th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
