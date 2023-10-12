<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;

    protected $table = 'subTasks';

    public function getUpdatedAtColumn()
    {
        return null;
    }
    public $timestamps = false;
}
