<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <H1>NOTICIAS</H1>
    <a href="{{ route('paper.create') }}" title="Admin">
        <i class="fas fa-user-shield"></i>
    </a>
    <ul class="flex justify-between px-4 py-2" style="width:130px">
        <li>
            <a class="hover:text-purple-900 font-semibold" href="{{ route('paper.create') }}">
                ADD NEWSPAPER
            </a>
        </li>
    </ul>
</body>
</html>