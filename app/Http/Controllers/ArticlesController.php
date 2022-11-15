<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;
use Exception;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // show all join order by id desc
        $articles = Articles::with('categories', 'user')->orderBy('id', 'desc')->get();
        // $articles = Articles::all();
        return response()->json($articles, 200);
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

    // paginate
    public function paginate($content = 1)
    {
        $articles = Articles::with('categories', 'user')->orderBy('id', 'desc')->paginate($content);
        return response()->json($articles, 200);
    }
    // {
    //     $articles = Articles::with('categories', 'user')->orderBy('id', 'desc')->paginate(5, ['*'], 'page', $page);
    //     return response()->json($articles, 200);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //validate
            $this->validate($request, [
                'title' => 'required',
                'content' => 'required',
                // image
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'categories_id' => 'required'
            ]);

            // save image
            $image = $request->image;

            // random name
            $image_new_name = time().'.'.$image->getClientOriginalExtension();
            // $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/articles', $image_new_name);

            // user_id is the foreign key in the articles table
            $article = Articles::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => 'uploads/articles/'.$image_new_name,
                'categories_id' => $request->categories_id,
                'users_id' => auth()->user()->id
            ]);

            $response = [
                'article' => $article
            ];

            return response()->json($response, 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        $article = Articles::with('categories', 'user')->find($id);
        return response()->json($article, 200);
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
        try{
            //validate
            $this->validate($request, [
                'title' => 'required',
                'content' => 'required',
                'categories_id' => 'required'
            ]);

            $article = Articles::find($id);

            if($request->hasFile('image')){
                // if exixt delete
                if(file_exists($article->image)){
                    unlink($article->image);
                }
                // save image
                $image = $request->image;
                // random name
                $image_new_name = time().'.'.$image->getClientOriginalExtension();
                // $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/articles', $image_new_name);

                $article->image = 'uploads/articles/'.$image_new_name;

            }

            $article->title = $request->title;
            $article->content = $request->content;
            $article->categories_id = $request->categories_id;
            $article->save();

            $response = [
                'article' => $article
            ];

            return response()->json($response, 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
        try{
            $article = Articles::find($id);
            if(file_exists($article->image)){
                unlink($article->image);
            }
            $article->delete();

            $response = [
                'article' => $article
            ];

            return response()->json($response, 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
