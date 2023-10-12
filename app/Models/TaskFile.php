<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'original_name', 'task_id'];
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
