<x-forum.layouts.home>
    <h1 class="text-3xl font-bold text-center mt-10">Foro Laravel funcionando 🚀</h1>

    @if(isset($questions) && count($questions))
        <div class="mt-6 max-w-3xl mx-auto">
            @foreach($questions as $question)
                <div class="bg-gray-800 p-4 rounded-lg mb-3">
                    <h2 class="text-xl font-semibold text-white">{{ $question->title }}</h2>
                    <p class="text-gray-400">{{ $question->content }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-400 mt-6">No hay preguntas todavía 💤</p>
    @endif
</x-forum.layouts.home>
