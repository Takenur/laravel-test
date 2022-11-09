<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class PostController extends Controller
{
    public function index()
    {
        return Post::paginate(20);
    }

    public function single($id)
    {
        return Post::find($id);
    }

    public function create(PostRequest $request)
    {
        //Упрощенное создание
        $data=$request->validated();
        try{
            $path=null;
            if (isset($data['image'])){
                $name = now()->timestamp.".{$request->image->getClientOriginalName()}";
                $path = $request->file('image')->storeAs('files', $name, 'public');
            }
            $data['image']=$path;

            Post::create($data);

            return true;
        }catch(\Exception $e){
            return "error".$e;
        }
    }

    /*
     * Обновление новости
     * Сделал при помощи POST потому что не отображались данные через PUT/PATCH
     * https://stackoverflow.com/questions/47676134/laravel-request-all-is-empty-using-multipart-form-data
     */

    public function update(PostRequest $request,$id)
    {
        //Упрощенное создание
        $post=Post::find($id);
        $data=$request->validated();
        try{
            $path=$post->image;
            if (isset($data['image'])){
                $name = now()->timestamp.".{$request->image->getClientOriginalName()}";
                $path = $request->file('image')->storeAs('files', $name, 'public');
            }
            $data['image']=$path;

            $post->update($data);

            return true;
        }catch(\Exception $e){
            return "error".$e;
        }
    }

    /*
     * Удаление новости
     */

    public function delete($id)
    {
        $post=Post::find($id);
        if (!is_null($post)){
            $post->delete();
            return true;
        }
        abort(404);
    }
}
