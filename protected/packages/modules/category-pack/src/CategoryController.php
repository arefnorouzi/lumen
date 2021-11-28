<?php

namespace Modules\CategoryPack;

use App\Http\Controllers\Controller;
use Modules\CategoryPack\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $category;
    private $content_type = 'json';
    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {
        $model = $this->category->records();
        return response()->json([
            'status' => true,
            'model' => $model
        ],200,['header'=> 'Content-Type', $this->content_type]);
    }


    /**
     * @param \Modules\CategoryPack\Category $id
     */
    public function show($id)
    {
        $model = $this->category->show($id);
        return response()->json([
            'status' => true,
            'model' => $model
        ],200,['header'=> 'Content-Type', $this->content_type]);
    }

    public function store(Request $request)
    {
        //validate
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:5|max:70',
            'slug' => 'required|string|min:3|max:150',
            'parent' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ],200,['header'=> 'Content-Type', $this->content_type]);
        }

        $this->category->cat_title = $request->title;
        $this->category->cat_slug = $request->slug;
        $this->category->parent_id = $request->parent;
        if ($this->category->save())
        {
            return response()->json([
                'status' => true,
                'model' => $this->category
            ],200,['header'=> 'Content-Type', $this->content_type]);
        }
        return response()->json([
            'status' => false,
            'message' => 'incorrect request',
        ],200,['header'=> 'Content-Type', $this->content_type]);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $model = $this->category->findWithTrashed($id);
        if (!$model)
        {
            return response()->json([
                'status' => false,
                'message' => 'not found'
            ],404,['header'=> 'Content-Type', $this->content_type]);
        }
        if ($model->deleted_at)
        {
            $model->restore();
            return response()->json([
                'status' => true,
                'message' => 'restore',
                'model' => $model
            ],200,['header'=> 'Content-Type', $this->content_type]);
        }
        $model->delete();
        return response()->json([
            'status' => true,
            'message' => 'delete',
            'model' => $model
        ],200,['header'=> 'Content-Type', $this->content_type]);
    }


}
