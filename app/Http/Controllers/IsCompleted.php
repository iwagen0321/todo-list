<?php

namespace App\Http\Controllers;

use App\Models\todo_items;
use App\Models\User;
use Illuminate\Http\Request;



class IsCompleted extends Controller
{
    public function is_completed(todo_items $todo_item)
    {
        $todo_item->finished_date =  date("Y-m-d H:i:s"); 

        $todo_item->save();
        return redirect()->route('todo_items.index');
    }
}
