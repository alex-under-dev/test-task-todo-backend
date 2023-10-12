<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use HasFactory;
    use NodeTrait;


    protected $fillable = ['task_id', 'text'];

    public $timestamps = false;
}
