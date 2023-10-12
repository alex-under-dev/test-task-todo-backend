<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCommentRequest;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function get(int $taskId)
    {
        return Comment::where('task_id', $taskId)->get()->toTree();
    }

    public function create(CreateCommentRequest $request)
    {
        $commentId = $request->commentId;
        if (!$commentId) {
            try {
                $data = [
                    'task_id' => $request->task_id,
                    'text' => $request->text
                ];
                $node = new Comment($data);
                $node->saveAsRoot();
                return ['Коментарий создан'];
            } catch (Exception $e) {
                return ['Не удалось создать комментарий' => $e->getMessage()];
            }
        }
        try {
            $parentComment = Comment::where('id', $request->commentId)->first();
            $childrenComment = [
                'task_id' => $request->task_id,
                'text' => $request->text,
                'parent_id' => $request->commentId
            ];
            $parentComment->children()->create($childrenComment);
            return 'Подкомментарий создан';
        } catch (Exception $e) {
            return ['Не удалось создать Подкомментарий' => $e->getMessage()];
        }
    }
    public function delete(Request $request)
    {
        try {
            $id = $request->commentId;
            Comment::find($id)->delete();
            return 'Комметнарий удалён успешно';
        } catch (Exception $e) {
            return ['Не удалось удалить' => $e->getMessage()];
        }
    }


    //not yet in use
    public function update(UpdateCommentRequest $request)
    {
        try {
            $data = [
                'text' => $request->request
            ];
            DB::table('comments')->where('id', $request->id)->update($data);
        } catch (Exception $e) {
            return ['Не удалось обновить комментарий' => $e->getMessage()];
        }
    }
}
