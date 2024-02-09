<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use Validator;

class SkillsController extends Controller
{

    public function getSkills($id)
    {
        $skills = Skill::where('pokemon_id', $id)->get();
        dd($skills);
        return response()->json([
            "success" => true,
            "message" => "Pokemon Skills List",
            "data" => $skills
        ]);
    }

    public function addSkill(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name_eng' => 'string|required',
            'name_rus' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        $skill = new Skill([
            'pokemon_id' => $id,
            'name_eng' => $request->get('name_eng'),
            'name_rus' => $request->get('name_rus'),
            'image' => $imageName,
        ]);
        $skill->save();

        return response()->json([
            "success" => true,
            "message" => "Skill created successfully.",
            "data" => $skill
        ]);
    }

    public function showSkill($id, $skill_id)
    {
        $skill = Skill::find($skill_id);

        if (is_null($skill)) {
            return $this->sendError('Pokemon skill not found.');
        }

        return response()->json([
            "success" => true,
            "message" => "Skill retrieved successfully.",
            "data" => $skill
        ]);
    }

    public function updateSkill(Request $request, $id, $skill_id)
    {
        $input = $request->all();

        if($request->image){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }else{
            $imageName = null;
        }

        $validator = Validator::make($input, [
            'name_eng' => 'string|required',
            'name_rus' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $skill = Skill::find($skill_id);
        $skill->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "Pokemon skill updated successfully.",
            "data" => $skill
        ]);
    }

    public function deleteSkill($id, $skill_id)
    {
        $skill = Skill::find($skill_id);
        $skill->delete();

        return response()->json([
            "success" => true,
            "message" => "Pokemon skill deleted successfully.",
            "data" => $skill
        ]);
    }
    public function getImage($id, $skill_id)
    {
        $skill = Skill::find($skill_id);
        if (is_null($skill)) {
            return $this->sendError('Pokemon not found.');
        }

        return response()->json([
            "success" => true,
            "message" => "Pokemon image retrieved successfully.",
            "data" => $skill->image
        ]);
    }
}
