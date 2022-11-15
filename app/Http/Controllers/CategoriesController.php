<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // show all
        $categories = Categories::with('user')->orderBy('id', 'desc')->get();
        return response()->json($categories, 200);
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
        //validate
        $this->validate($request, [
            'name' => 'required'
        ]);

        // user_id is the foreign key in the categories table
        $category = Categories::create([
            'name' => $request->name,
            'users_id' => auth()->user()->id
        ]);
 
        $response = [
            'category' => $category
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // show
        $category = Categories::with('user')->find($id);
        $response = [
            'category' => $category
        ];
        return response()->json($response, 200);
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
        // update
        //validate
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Categories::find($id);
        if($category){
            $category->name = $request->name;
            $category->save();
            $response = [
                'category' => $category
            ];
            return response()->json($response, 200);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        // check if isset
        $category = Categories::with('articles', 'user')->find($id);
        if($category) {
            $category->delete();
            $response = [
                'message' => 'Category deleted'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Category not found'
            ];
            return response()->json($response, 404);
        }
    }
}
