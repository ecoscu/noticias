<style>
    .btn-hover:hover {
        background-color: #3f5468;
    }
</style>
<x-app-layout>

    <body>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('NUEVO PERIODICO') }}
            </h2>
        </x-slot>
        
        @if (session('status'))
            <div class="alert alert-success text-center my-2 flex justify-center p-2 text-white" style="background-color: rgb(42, 182, 72)">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="w-full bg-red-500 p-2 text-center my-2 text-white">
                {{ $errors->first() }}
            </div>
        @endif

        <br><br>

        <form action="{{ route('paper.store') }}" method="post" class="flex justify-center">
            @csrf
            <input type="text" name="URL" placeholder="URL" class="mr-2 border rounded" style="width: 400px">
            <input type="submit" value="AÑADIR"
                class="px-4 py-2 cursor-pointer font-bold border rounded text-white btn-hover">
        </form>
        
    </body>
</x-app-layout>
