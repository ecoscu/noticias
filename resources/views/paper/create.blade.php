<style>
    .btn-hover:hover {
        background-color: #3f5468;
    }
</style>
<x-app-layout>

    <body>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ADD NEWSPAPER') }}
            </h2>
        </x-slot>
        <br>
        <form action="{{ route('paper.store') }}" method="post" class="flex justify-center">
            @csrf
            <input type="text" name="URL" placeholder="URL" class="mr-2">
            <input type="submit" value="AÑADIR"
                class="px-4 py-2 cursor-pointer font-bold border rounded text-white btn-hover">
        </form>
    </body>
</x-app-layout>
