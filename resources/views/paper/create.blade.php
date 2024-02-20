<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Paper</title>
</head>
<body>
    
    <a href="{{ route('home') }}">
        HOME
    </a>
    <br>
    <h2>ADD NEWSPAPER</h2>
    <form action="{{ route('paper.store') }}" method="post">
        @csrf
        <input type="text" name="URL" placeholder= "URL">
        <input type="submit" value="GUARDAR" class="px-4 py-2 bg-purple-300 cursor-pointer hover:bg-purple-500 font-bold w-full border rounded border-purple-400 hover:border-purple-700 text-white">
    </form>
</body>
</html>