<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $s = $request->get('search');
        return response()->json(Recipe::where('name', 'like', '%%' . $s . "%%")->with('level')->with('tags')->with('details')->paginate(15), 200);
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
    public function store(RecipeRequest $request)
    {
        $data = $request->only('tags', 'categories', 'details');
        $new_recipe = Recipe::create($request->only('name', 'description', 'level_id', 'time_to_complete'));
        if ($request->has('tags') && count($data['tags']) > 0) {
            $new_recipe->tags()->attach($data['tags']);
        }
        if ($request->has('categories') && count($data['categories']) > 0) {
            $new_recipe->categories()->attach($data['categories']);
        }
        if ($request->has('details') && count($data['details']) > 0) {
            $details = [];
            foreach ($request->get('details') as $detail) {
                array_push($details, [
                    'name' => $detail['name'],
                    'description' => $detail['description'],
                ]);
            }
            $new_recipe->details()->createMany($details);
        }
//        if ($request->has('ingredients') && count($data['ingredients']) > 0) {
//            $new_recipe->ingredients()->attach($data['ingredients']);
//        }
        return response()->json($new_recipe, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Recipe::with('tags')->with('categories')->with('ingredients')->findOrFail($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe_to_delete = Recipe::findOrFail($id);
        $recipe_to_delete->delete();
        return response()->json(['id' => $id], 200);
    }

    public function lookup(Request $request)
    {
        $s = $request->get('search');
        $response = Recipe::select('id', 'name')->where('name', 'like', '%' . $s . '%')->get();
        return response()->json($response, 200);
    }
}
