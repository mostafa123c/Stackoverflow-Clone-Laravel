<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//      $this->middleware('auth')->except(['index' , 'show']);
//      $this->middleware('auth')->only(['index' , 'show']);
    }

    public function index()
    {
        $tags = Tag::all();
        $user = auth::user();
        return view('tags.index' , compact('tags' , 'user'));
    }

    public function create()
    {
        return view('tags.create' , [
                'tag' => new Tag(),
            ]);
    }

    public function store(TagRequest $request)
    {
//        $request->validate([
//            'name' => 'required|string|min:3|max:35|unique:tags,name',
//        ]);

//        $tag = new Tag();
//        $tag->name = $request->name;
//        $tag->slug = Str::slug($request->name);
//        $tag->save();
//
        //2
        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

//        $request->merge([
//            'slug' => Str::slug($request->name),
//        ]);
//        Tag::create($request->all());


        return redirect('/tags')->with('success' , 'Tag Created Successfully');

    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);  //in case of fail abort 404
        return view('tags.edit' , compact('tag'));
    }

    public function update(TagRequest $request , $id)
    {
//        $request->validate([
//            //|between:3,35
//            'name' => 'required|string|min:3|max:35|unique:tags,name,'.$id,
//        ]);

        $tag = Tag::findOrFail($id);
        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        Session::flash('success' , 'Tag Updated Successfully');
        return redirect('/tags');//->with('success' , 'Tag Updated Successfully');
    }

    public function destroy($id)
    {
        //1
//        Tag::destroy($id);

        //2
//        Tag::where('id' , $id)->delete();

        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect('/tags')->with('success' , 'Tag Deleted Successfully');
    }

}
