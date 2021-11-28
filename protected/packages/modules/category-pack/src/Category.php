<?php

namespace Modules\CategoryPack;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['cat_title','cat_slug','parent_id'];

    public function __construct()
    {
        //
    }

    public function show($id)
    {
        return Category::find($id);
    }

    public function findWithTrashed($id)
    {
        return Category::withTrashed()->find($id);
    }

    public function records()
    {
        return Category::orderby('id','desc')->paginate(10,['id','cat_title','cat_slug']);
    }
}
