<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;
use Validator;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('parent_id','<>',0)->get();
        return view('subcategory.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat_data = Category::with(['parentCategory'])->get();
        return view('subcategory.create',compact('cat_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50|min:3',
            'parent_id' => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); 
        }
        $parent_slug = Category::where('id',$request->parent_id)->first()->slug;
        $userDataInsert = Category::create([ 
            'parent_id'=>$request->parent_id,
            'name' => $request->name, 
            'slug' => $parent_slug . '/' . \Str::slug($request->name, '-'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $request->session()->flash('success', "Subcategory created successfully");
        return redirect()->route('subcategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $cat_data = Category::with(['parentCategory'])->get();
        return view('subcategory.edit',compact('category','cat_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:50|min:3',
            'parent_id' => 'required',
        ];
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); 
        }
        $previous_data = Category::where('id',$id)->first();
        $previous_slug = \Str::slug($previous_data->name, '-');
        $current_slug = \Str::slug($request->name, '-');
        $main = Category::all()->pluck('id')->all();
        foreach ($main as $key => $value) {
            $data = Category::where('id', $value)->first();
            $data_slug = collect(explode('/',$data->slug));
            $replace_slug = $data_slug->map(function ($item, $key)use($previous_slug,$current_slug) {
                if($item == $previous_slug){
                    return $current_slug;
                }else{
                    return $item;
                }
            });
            $replace_slug->all();
            $new_slug = $replace_slug->implode('/');

            Category::where('id', (int)$value)
                ->update([
                    'slug' => $new_slug,
                    'updated_at' => now(),
                ]);
        }



        $parent_slug = Category::where('id',$request->parent_id)->first()->slug;
        Category::where('id', (int)$id)
        ->update([
            'name' => $request->name,
            'parent_id'=>$request->parent_id,
            'slug' => $parent_slug . '/' . \Str::slug($request->name, '-'),
            'updated_at' => now(),
        ]);

        $request->session()->flash('success', "Subcategory updated successfully");
        return redirect()->route('subcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    { 
        $cat = category::where('parent_id', (int)$id)->count();
                
        if ($cat > 0) {
            $request->session()->flash('error', "This category can't be deleted. Category is used as parent for subcategory");
            return redirect()->back();
        }
        $delete = Category::where('id', (int)$id)->delete();

        if ($delete) {
            $msg = "Subcategory successfully deleted";
            $request->session()->flash('success', $msg);
        } else {
            $msg = "Failed to delete";
            $request->session()->flash('error', $msg);
        }
        return redirect()->back();
    }
}
