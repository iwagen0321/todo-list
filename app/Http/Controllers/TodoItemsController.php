<?php

namespace App\Http\Controllers;

use App\Models\todo_items;
use App\Models\User;
use Illuminate\Http\Request;

class TodoItemsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = todo_items::query();

        if(!empty($keyword)) {
            $todo_items = todo_items::whereHas('User',function($q) use ($keyword){
                $q->where('name', 'LIKE', "%{$keyword}%");
            })->orwhere('item_name', 'LIKE', "%{$keyword}%")
            ->orderBy('expire_date','asc')->paginate(5);
        } else {
            $todo_items = todo_items::orderBy('expire_date','asc')->paginate(5);
            $keyword = " ";
        }

        $user = auth()->user();
 
        return view('todo_items.index',compact('todo_items','user','keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('todo_items.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isset($request->finished_date)) {
            $request->merge(['finished_date'=>0]);
        }

        $input = $request->validate([
            'item_name'=>'required|max:100',
            'user_id'=>'required|exists:users,id',
            'expire_date'=>'required|date_format:Y-m-d',
            'finished_date'=>'in:0,1',
        ]);

        $todo_items = new todo_items();

        if($request->finished_date == 1) {
            $todo_items->finished_date =  date("Y-m-d H:i:s");
        } else {
            $todo_items->finished_date = null;
        }

        $todo_items->item_name = $request->item_name;
        $todo_items->user_id = $request->user_id;
        $todo_items->registration_date = date("Y-m-d H:i:s");
        $todo_items->expire_date = $request->expire_date;
        $todo_items->save();
        return redirect()->route('todo_items.index')->with('message','作業登録が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function show(todo_items $todo_item)
    {
        $users = User::all();
        return view('todo_items.show', compact('todo_item','users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function edit(todo_items $todo_item)
    {
        $users = User::all();
        return view('todo_items.edit', compact('todo_item','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, todo_items $todo_item)
    {
        if(!isset($request->finished_date)) {
            $request->merge(['finished_date'=>0]);
        }

        $input = $request->validate([
            'item_name'=>'required|max:100',
            'user_id'=>'required|exists:users,id',
            'expire_date'=>'required|date_format:Y-m-d',
            'finished_date'=>'in:0,1',
        ]);

        if($request->finished_date == 1) {
            $todo_item->finished_date =  date("Y-m-d H:i:s");
        } else {
            $todo_item->finished_date = null;
        }

        $todo_item->item_name = $request->item_name;
        $todo_item->user_id = $request->user_id;
        $todo_item->registration_date = date("Y-m-d H:i:s");
        $todo_item->expire_date = $request->expire_date;
        $todo_item->save();
        return redirect()->route('todo_items.index')->with('message','作業登録を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\todo_items  $todo_items
     * @return \Illuminate\Http\Response
     */
    public function destroy(todo_items $todo_item)
    {
        $todo_item->is_deleted = 1;
        $todo_item->save();
        return redirect()->route('todo_items.index')->with('message','作業登録を削除しました。');
    }

    public function is_completed(todo_items $todo_item)
    {
        
        $todo_item->finished_date =  date("Y-m-d H:i:s"); 

        $todo_item->save();
        return redirect()->route('todo_items.index');
    }

    
    
}
