<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo_items extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'user_id',
        'expire_date',
        'finished_date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }


}
