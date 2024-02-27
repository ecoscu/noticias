<style>
    .btn-hover:hover {
        background-color: #3f5468;
    }

    .with-margin {
        margin-right: 1rem;
        /* Ajusta el valor según tus necesidades */
    }

    .icon:hover{
        scale: 125%;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('PERIODICOS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($papers as $paper)
                        <article class="text-left p-2 rounded btn-hover">
                            <a href="{{ "/paper/{$paper->slug}" }}">
                                <h2 class="py-4 text-xl font-semibold">{{ $paper->name }}</h2>
                                <p class="text-m">{{ $paper->URL }}</p>
                            </a>
                            <br>
                            <div class="options flex justify-end">
                                <i></i>
                                <i class="far fa-edit icon with-margin"></i>
                                <i class="fas fa-trash-alt icon"></i>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
