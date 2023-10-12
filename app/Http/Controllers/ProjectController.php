<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function get()
    {
        return Project::all();
    }

    public function getOneProject(Project $project)
    {
        return $project;
    }

    public function create(CreateProjectRequest $request)
    {
        try {
            $data = [
                'title' => $request->title
            ];
            DB::table('projects')->insert($data);
            return ['Проект создан'];
        } catch (Exception $e) {
            return ['Не удалось создать проект' => $e->getMessage()];
        }
    }

    public function update(UpdateProjectRequest $request)
    {
        try {
            $data = [
                'title' => $request->title
            ];
            DB::table('projects')->where('id', $request->id)->update($data);
            return 'Изменён успешно';
        } catch (Exception $e) {
            return ['Не удалось обновить проект' => $e->getMessage()];
        }
    }
    public function delete(Request $request)
    {
        try {
            Project::find($request->projectId)->delete();
            return 'Проект удалён успешно';
        } catch (Exception $e) {
            return ['Не удалось удалить' => $e->getMessage()];
        }
    }
}
