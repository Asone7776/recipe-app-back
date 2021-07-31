<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $s = $request->get('search');

        if ($s != '') {
            $response = Category::where('name', 'like', '%' . $s . '%')->paginate(15);
//            $response->appends(array('search'=>$s));
        } else {
            $response = Category::paginate(15);
        }
        return response()->json($response, 200);
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
    public function store(CategoryRequest $request)
    {
        $new_item = Category::create($request->all());
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
        return response()->json(Category::findOrFail($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(Category::findOrFail($id), 200);
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
        $item_to_update = Category::findOrFail($id);
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
        $item_to_delete = Category::findOrFail($id);
        $item_to_delete->delete();
        return response()->json(['id' => $item_to_delete['id']], 200);
    }

    public function lookup(Request $request)
    {
        $s = $request->get('search');
        return response()->json(Category::where('name', 'like', '%%' . $s . "%%")->get(), 200);
    }
}
