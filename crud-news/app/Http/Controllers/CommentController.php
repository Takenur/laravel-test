<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommentSet;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::paginate(20);
    }

    public function single($id)
    {
        return Comment::find($id);
    }

    public function create(CommentRequest $request)
    {
        //Упрощенное создание
        $data=$request->validated();
        $post_id=$data['post_id'];
        unset($data['post_id']);
        try{
            DB::beginTransaction();
            $comment=Comment::create($data);
            CommentSet::create(
              [
                'post_id'=>$post_id,
                'comment_id'=>$comment->id,
              ]
            );

        }catch(\Exception $e){
            DB::rollBack();
            return "error".$e;
        }
        DB::commit();
        return true;
    }

    public function update(CommentRequest $request,$id)
    {
        //Упрощенное Обновление
        $data=$request->validated();
        $comment=Comment::find($id);
        unset($data['post_id']);
        try{
            DB::beginTransaction();
            $comment->update($data);

        }catch(\Exception $e){
            DB::rollBack();
            return "error".$e;
        }
        DB::commit();
        return true;
    }

    /*
     * Удаление комментария
     */

    public function delete($id)
    {
        $Comment=Comment::find($id);
        if (!is_null($Comment)){
            $Comment->delete();
            return true;
        }
        abort(404);
    }
}
