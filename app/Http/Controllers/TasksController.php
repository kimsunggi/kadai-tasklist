<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
    
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
        }else {
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::check()) {
            $task = new Task;
            
            return view('tasks.create',[
                'task' => $task,
                ]);
                
        }else {
            return redirect('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::check()) {
            $this->validate($request, [
                'status' => 'required|max:10',
                'content' => 'required|max:191',
                ]);
                
            $request->user()->tasks()->create([
                'status' => $request->status,
                'content' => $request->content,
            ]);
            
            return redirect('/');
        
        }else {
            return redirect('login');
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
        if (\Auth::check()) {
            $task = Task::find($id);
                
                if (\Auth::id() == $task->user_id) {
                    return view('tasks.show', [
                        'task' => $task,
                        ]);
                } else {
                    return redirect('/');
                }
            
        }else {
            return redirect('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::check()) {
            $task = Task::find($id);
            
                if(\Auth::id() == $task->user_id) {
                    return view('tasks.edit', [
                        'task' => $task,
                     ]);
                } else {
                    return redirect('/');
                }
                
        } else {
            return redirect('login');
        }
        
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
        if (\Auth::check()) {
            $task = Task::find($id);
            if(\Auth::id() == $task->user_id) {
                $this->validate($request, [
                    'status' => 'required|max:10',
                    'content' => 'required|max:191',
                    ]);
                
                $request->user()->tasks()->update([
                'status' => $request->status,
                'content' => $request->content,
                ]);
                
                return redirect('/');
            } else {
                return redirect('/');
            }
            
        } else {
            return redirect('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::check()) {
            $task = Task::find($id);
            if (\Auth::id() == $task->user_id) {
                $task->delete();
                return redirect('/');
            } else {
                return redirect('/');
            }
                
        } else {
            return redirect('login');
        }
    }
}
