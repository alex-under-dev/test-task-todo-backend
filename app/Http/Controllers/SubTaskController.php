<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubTaskRequest;
use App\Http\Requests\UpdateSubTaskStatusRequest;
use App\Models\SubTask;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    public function create(CreateSubTaskRequest $request)
    {
        $subTask = new SubTask();
        $subTask->text = $request->text;
        $subTask->task_id = $request->taskId;
        $subTask->save();
        return 'Подзадача создана';
    }

    public function updateStatus(UpdateSubTaskStatusRequest $request)
    {
        $subTask = SubTask::find($request->id);
        $subTask->is_completed = !$subTask->is_completed;
        $subTask->save();

        return 'Статус подзадачи обновлён';
    }

    public function delete(Request $request)
    {
        SubTask::where('id', $request->subTaskId)->delete();

        return 'Подзадача удалена';
    }
}
