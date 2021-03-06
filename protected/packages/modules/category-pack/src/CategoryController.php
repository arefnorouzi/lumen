<?php

namespace Modules\CategoryPack;

use App\Http\Controllers\Controller;
use Modules\CategoryPack\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $category;
    private $content_type = 'application/json';
    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {
        $model = $this->category->records();
        return $this->returnData(true, $model);
    }


    /**
     * @param \Modules\CategoryPack\Category $id
     */
    public function show($id)
    {
        $model = $this->category->find($id);
        if ($model)
        {
            return $this->returnData(true, $model);
        }
        return $this->returnData(false, [],'not found',404);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        //validate
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:5|max:70',
            'slug' => 'required|string|min:3|max:150',
            'parent' => 'numeric',
        ]);
        if ($validator->fails()) {
            return $this->returnData(false, [],$validator->errors(), 500);
        }

        $this->category->cat_title = $request->title;
        $this->category->cat_slug = $request->slug;
        $this->category->parent_id = $request->parent;
        if ($this->category->save())
        {
            return $this->returnData(true, $this->category,'success store');
        }
        return $this->returnData(false, [],'incorrect request', 500);

    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $model = $this->category->findWithTrashed($id);
        if ($model)
        {
            return $this->returnData(true, $model);
        }
        return $this->returnData(false, [],'not found',404);
    }

    public function update(Request $request, $id)
    {
        //validate
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:5|max:70',
            'slug' => 'required|string|min:3|max:150',
            'parent' => 'numeric',
        ]);

        if ($validator->fails()) {
            return $this->returnData(false, [],$validator->errors(), 500);
        }
        $model = $this->category->find($id);
        if (!$model)
        {
            return $this->returnData(false, [],'not found',404);
        }

        $model->cat_title = $request->title;
        $model->cat_slug = $request->slug;
        $model->parent_id = $request->parent;
        if ($model->update())
        {
            return $this->returnData(true, $model,'success update');
        }
        return $this->returnData(false, [],'incorrect request', 500);

    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $model = $this->category->find($id);
        if (!$model)
        {
            return $this->returnData(false, [],'not found',404);
        }
        if ($model->deleted_at)
        {
            $model->restore();
            return $this->returnData(true, $model,'success restore');
        }
        $model->delete();
        return $this->returnData(true, $model,'success delete');
    }


    /**
     * @param $status
     * @param $model
     * @param null $message
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnData($status, $model, $message = null, $status_code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'model' => $model
        ],$status_code,['header'=> 'Content-Type', $this->content_type]);
    }


}
