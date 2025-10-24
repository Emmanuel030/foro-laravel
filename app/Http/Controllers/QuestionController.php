<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados pueden crear o eliminar preguntas
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Muestra el formulario para crear una nueva pregunta.
     */
    public function create()
    {
        $categories = \App\Models\Category::all(); 
        return view('questions.create', compact('categories'));
    }

    /**
     * Guarda una nueva pregunta en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $question = Question::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,  // temporalmente si no estás usando categorías
        ]);

        return redirect()
            ->route('home') // 👈 asegúrate que diga 'questions.show'
            ->with('success', 'Tu pregunta se publicó correctamente ');
    }

    public function show(Question $question)
    {
        $question->load('answers', 'category', 'user');

        return view('questions.show', [
            'question' => $question,
        ]);
    }

    /**
     * Elimina una pregunta si pertenece al usuario autenticado.
     */
    public function destroy(Question $question)
    {
        if ($question->user_id !== Auth::id()) {
            abort(403, 'No puedes eliminar una pregunta que no te pertenece.');
        }

        $question->delete();

        return redirect()
            ->route('home')
            ->with('success', 'La pregunta fue eliminada correctamente.');
    }
    public function edit(Question $question)
{
    // Solo el autor puede editar
    if (auth()->id() !== $question->user_id) {
        abort(403, 'No tienes permiso para editar esta pregunta.');
    }

    $categories = \App\Models\Category::all();

    return view('questions.edit', compact('question', 'categories'));
}

public function update(Request $request, Question $question)
{
    if (auth()->id() !== $question->user_id) {
        abort(403, 'No tienes permiso para editar esta pregunta.');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $question->update([
        'title' => $request->title,
        'content' => $request->content,
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('questions.show', $question)->with('success', 'Pregunta actualizada correctamente.');
}

}
