<?php

namespace App\Http\Controllers;

use App\Models\CategoryExpense;
use Illuminate\Http\Request;
use Auth;

class CategoryExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryExpense::get();
        return view('backend.expensses.category', compact('categories'));
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
        $data = array();
        $data['id_country'] = Auth::user()->country_id;
        $data['id_user'] = Auth::user()->id;
        $data['name'] = $request->category_name;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/category'), $filename);
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/public/uploads/category/'.$filename;
        }else{
            $data['image'] = 'https://' . request()->getHost() . '/public/uploads/category/default.png';
        }
        CategoryExpense::create($data);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryExpense  $categoryExpense
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryExpense $categoryExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryExpense  $categoryExpense
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryExpense $categoryExpense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryExpense  $categoryExpense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryExpense $categoryExpense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryExpense  $categoryExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryExpense $categoryExpense)
    {
        //
    }
}
