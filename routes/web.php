<?php   

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

// Página principal
Route::get('/', [PageController::class, 'index'])->name('home');

// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {

    // Crear una nueva pregunta
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

    // Editar una pregunta
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');

    // Eliminar una pregunta
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});

// Ver una pregunta
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

// Enviar una respuesta
Route::post('/answers/{question}', [AnswerController::class, 'store'])->name('answers.store');

// Dashboard (Laravel Breeze / Jetstream)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Configuración de usuario
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Autenticación (login, registro, etc.)
require __DIR__.'/auth.php';
