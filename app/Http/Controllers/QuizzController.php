<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizzController extends Controller
{
    // create quiz
    public function create(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            "class_id" => "nullable",
            "title" => "required",
            "description" => "nullable",
            "category" => "required|exists:categories,id",
            "duration" => "nullable",
            "passing_grade" => "required|min:0|max:100",
            "quizz_start" => "required|after:now",
            "quizz_end" => "required|after:quizz_start",
            "visibility" => "required|in:public,private",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first());
        }

        $quizz = new Quizz();
        $quizz->title = $request->title;
        $quizz->description = $request->description;
        $quizz->questions = $request->questions;
        $quizz->save();

        return redirect()->route('quizz.create')
            ->with('success', 'Quizz created successfully.');
    }
}
