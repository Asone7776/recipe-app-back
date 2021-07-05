<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Comment::with('user')->with('recipe')->paginate(15), 200);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_item = Comment::create($request->all());
        return response()->json($new_item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Comment::findOrFail($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(Comment::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item_to_update = Comment::findOrFail($id);
        $item_to_update->update($request->all());
        return response()->json($item_to_update, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item_to_delete = Comment::findOrFail($id);
        $item_to_delete->delete();
        return response()->json(['id' => $item_to_delete['id']], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $recipe_id
     * @return \Illuminate\Http\Response
     */

    public function addCommentForRecipe(Request $request, $recipe_id)
    {
        $recipe = Recipe::findOrFail($recipe_id);

        $data = $request->only('message');
        $data['user_id'] = $request->user()->id;

        $comment = $recipe->comments()->create($data);
        return response()->json(['id' => $comment->id], 201);
    }

}
