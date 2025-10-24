<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question){
        
        $request->validate([
            'content' => 'required|string|max:1900',
        ]);

        $question->answers()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('questions.show', $question->id)
            ->with('success', 'Tu respuesta se publicó correctamente 🎉');
    }
}
