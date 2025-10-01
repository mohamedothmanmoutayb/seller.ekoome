<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, SubCategory};
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            // Get all categories
            $categories = Category::paginate(10);
            $subcategories = SubCategory::paginate(10);
            // Load the view and pass the categories
            return view('backend.categories.index', compact('categories', 'subcategories'));
               
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subcategoriesStore(Request $request)
    {
        //
        $request->validate([
            'sub_name' => 'required',
            'category_id' => 'required',
        ]);

        $subcategory = new SubCategory();
        $subcategory->name = $request->sub_name;
        $subcategory->id_category = $request->category_id;
        $subcategory->save();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
