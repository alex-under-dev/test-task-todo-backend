<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateOrderOrStatusRequest;
use App\Http\Requests\UpdatTaskStatusRequeest;
use App\Models\Task;
use App\Models\TaskFile;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function get(Request $request)
    {
        $tasks = Task::where('project_id', $request->progectId)
            ->orderBy('order', 'ASC')
            ->get();
        return $tasks;
    }

    public function create(CreateTaskRequest $request)
    {
        $newTask = new Task(
            [
                'project_id' => $request->project_id,
                'header' => $request->header,
                'spetification' => $request->spetification,
                'priority' => $request->priority,
                'data' => $request->data,
                'created_at' => now(),
                'order' => Task::where('status', 'queue')->count() + 1
            ]
        );
        $newTask->save();
        return $newTask;
    }

    public function update(UpdateTaskRequest $request)
    {
        $data = [
            'header' => $request->header,
            'text' => $request->text,
            'priority' => $request->priority,
            'status' => $request->status,
        ];
        DB::table('tasks')->where('id', $request->id)->update($data);
        return ['Задача обновлена'];
    }

    public function delete(Request $request)
    {
        Task::find($request->taskId)->delete();
        return 'Заадча удалена успешно';
    }

    public function updateOrderOrStatus(UpdateOrderOrStatusRequest $request)
    {
        $targetId = $request->input('idTargetPosition');
        $idElement = $request->input('idElement');
        $targetStatus = $request->input('targetStatus');


        $items = Task::where('status', $targetStatus)
            ->where('id', '<>', $idElement)
            ->orderBy('order', 'ASC')
            ->get();

        $targetItem = Task::find($idElement);
        $order = 1;
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]->id == $targetId) {
                $targetItem->order = $order;
                $targetItem->save();
                $order++;
            }
            $items[$i]->order = $order;
            $order++;
            $items[$i]->save();
        }

        return 'Сортировка успешна';
    }

    public function updateStatus(UpdatTaskStatusRequeest $request)
    {
        $idElement = $request->input('idElement');
        $targetStatus = $request->input('targetStatus');

        $targetItem = Task::find($idElement);
        $targetItem->order = Task::where('status', $targetStatus)->count() + 1;
        $targetItem->status = $targetStatus;
        $targetItem->save();



        $items = Task::where('status', $targetStatus)
            ->orderBy('order', 'ASC')
            ->get();

        for ($i = 0; $i < count($items); $i++) {
            $items[$i]->order = $i + 1;
            $items[$i]->save();
        }
        return "Сортировка успешна";
    }

    public function getOneTask(Request $request)
    {
        $task = Task::where('id', $request->taskId)->with(['subTasks', 'files'])->first();

        $timeInWorkInSeconds = $task->created_at->diffInSeconds(Carbon::now());
        $days = floor($timeInWorkInSeconds / (3600 * 24));
        $hours = floor(($timeInWorkInSeconds - $days * (3600 * 24)) / 3600);
        $minutes = floor(($timeInWorkInSeconds - $days * (3600 * 24) - $hours * 3600) / 60);
        $timeInWorkFormatted = "$days д, $hours ч, $minutes м";
        $task->timesInWork = $timeInWorkFormatted;


        $carbonDate = Carbon::parse($task->created_at);
        $formattedDate = $carbonDate->format('d-m-Y');
        $task->created_at_format = $formattedDate;

        return $task;
    }

    public function uploadFile(Task $task, Request $request)
    {
        $file = $request->file('file');
        $name = $file->hashName();
        $originalName = $file->getClientOriginalName();
        $file->store();

        $file = new TaskFile([
            'file_name' => $name,
            'original_name' => $originalName,
            'task_id' => $task->id,
        ]);
        $file->save();
        return "Файл успешно загружен!";
    }
    public function deleteFile(Request $request)
    {
        return TaskFile::find($request->fileId)->delete();
    }
}
