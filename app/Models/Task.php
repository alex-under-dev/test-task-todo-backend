<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'header', 'text', 'priority', 'status', 'order'];
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'task_id');
    }
    public function getUpdatedAtColumn()
    {
        return null;
    }
    public function subTasks()
    {
        return $this->hasMany('App\Models\subTask', 'task_id');
    }

    public function files()
    {
        return $this->hasMany('App\Models\TaskFile');
    }
}
