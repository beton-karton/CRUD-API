<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Pokemon;

use Illuminate\Http\Request;

use Validator;

class PokemonController extends Controller
{

    public function index()
    {
        $pokemons = Pokemon::orderBy('sort')->with('skills')->get();

        return response()->json([
            "success" => true,
            "message" => "Pokemon List",
            "data" => $pokemons
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'sort' => 'integer',
            'name' => 'string|required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'shape' => 'string',
            'location' => 'string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if($request->image){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }else{
            $imageName = null;
        }

        $pokemon = new Pokemon([
            'sort' => $request->get('sort'),
            'name' => $request->get('name'),
            'image' => $imageName,
            'shape' => $request->get('shape'),
            'location' => $request->get('location'),
        ]);
        $pokemon->save();

        return response()->json([
            "success" => true,
            "message" => "Product created successfully.",
            "data" => $pokemon
        ]);

    }

    public function show($id)
    {
        $pokemon = Pokemon::where('id', $id)->with('skills')->first();

        if (is_null($pokemon)) {
            return $this->sendError('Pokemon not found.');
        }

        return response()->json([
            "success" => true,
            "message" => "Pokemon retrieved successfully.",
            "data" => $pokemon
        ]);
    }


    public function update(Request $request, Pokemon $pokemon)
    {
        $input = $request->all();

        if($request->image){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }else{
            $imageName = null;
        }

        $validator = Validator::make($input, [
            'sort'=> 'integer',
            'name' => 'string|required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'shape' => 'string',
            'location' => 'string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $pokemon = Pokemon::find($pokemon->id);
        $pokemon->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Pokemon updated successfully.",
            "data" => $pokemon
        ]);
    }

    public function destroy(Pokemon $pokemon)
    {
        $pokemon->delete();

        return response()->json([
            "success" => true,
            "message" => "Pokemon deleted successfully.",
            "data" => $pokemon
        ]);
    }
    public function getImage($id)
    {
        $pokemon = Pokemon::find($id);

        if (is_null($pokemon)) {
            return $this->sendError('Pokemon not found.');
        }

        return response()->json([
            "success" => true,
            "message" => "Pokemon image retrieved successfully.",
            "data" => $pokemon->image
        ]);
    }
}
