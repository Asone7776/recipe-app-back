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
        $data = $request->only('tags', 'categories', 'details', 'ingredients');
        $new_recipe = Recipe::create($request->only('name', 'description', 'level_id', 'time_to_complete'));
        if ($request->has('tags') && count($data['tags']) > 0) {
            $new_recipe->tags()->attach($data['tags']);
        }
        if ($request->has('categories') && count($data['categories']) > 0) {
            $new_recipe->categories()->attach($data['categories']);
        }
        if ($request->has('details') && count($data['details']) > 0) {
            $new_recipe->details()->createMany($data['details']);
        }
        if ($request->has('ingredients') && count($data['ingredients']) > 0) {
            $new_recipe->ingredients()->attach($data['ingredients']);
        }
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
        return response()->json(Recipe::with('tags')->with('categories')->with('ingredients')->with('details')->findOrFail($id), 200);
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
    public function update(RecipeRequest $request, $id)
    {
        $data = $request->only('tags', 'categories', 'details', 'ingredients');
        $recipe_to_update = Recipe::findOrFail($id);
        $recipe_to_update->update($request->only('name', 'description', 'level_id', 'time_to_complete'));
        if ($data && $data['tags']) {
            $recipe_to_update->tags()->sync($data['tags']);
        }
        if ($data && $data['categories']) {
            $recipe_to_update->categories()->sync($data['categories']);
        }

        if ($data && $data['ingredients']) {
            $recipe_to_update->ingredients()->sync($data['ingredients']);
        }

        if (isset($data['details'])) {
            if (empty($data['details'])) {
                $recipe_to_update->details()->delete();
            } else {
                //Delete existing details
                $recipe_to_update->details()->whereNotIn('id', $data['details'])->delete();

                foreach ($data['details'] as $detail) {
                    $recipe_to_update->details()->updateOrCreate([
                        'id' => isset($detail['id']) ? $detail['id'] : null,
                    ], [
                        'name' => $detail['name'],
                        'description' => $detail['description']
                    ]);
                }
            }
        }
        return response()->json($recipe_to_update, 200);
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
