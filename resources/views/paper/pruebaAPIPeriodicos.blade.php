<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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
</body>
</html>