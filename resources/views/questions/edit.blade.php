<x-forum.layouts.home>
    <div class="max-w-3xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Editar pregunta</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('questions.update', $question) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Categoría --}}
            <div>
                <label for="category_id" class="block font-semibold text-gray-700 mb-1">Categoría</label>
                <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded p-2 text-black">
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $question->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Título --}}
            <div>
                <label class="block font-semibold mb-1">Título</label>
                <input type="text" name="title" value="{{ old('title', $question->title) }}" required
                       class="w-full rounded border border-gray-300 text-black p-2">
            </div>

            {{-- Contenido --}}
            <div>
                <label class="block font-semibold mb-1">Contenido</label>
                <textarea name="content" rows="6" required
                          class="w-full rounded border border-gray-300 text-black p-2">{{ old('content', $question->content) }}</textarea>
            </div>

            {{-- Botón --}}
            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Guardar cambios
            </button>
        </form>
    </div>
</x-forum.layouts.home>
