<nav class="flex items-center justify-between h-16">
                <div>
                    <a href="{{ route('home') }}">
                       <x-forum.logo />
                    </a>
                </div>
                
                <div class="flex gap-4">
                    <a href="#" class="text-sm font-semibold">Foro</a>
                    <a href="#" class="text-sm font-semibold">Blog</a>
                </div>
                
                <div>
                    @auth
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-semibold text-indigo-500">
                                {{ Auth::user()->name }}
                            </span>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-indigo-500">
                            Log in &rarr;
                        </a>
                    @endauth
                </div>
 </nav>