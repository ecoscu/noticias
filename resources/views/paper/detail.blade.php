<style>
    .btn-hover:hover {
        background-color: #3f5468;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ ($paper->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div id='titularesData' class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- @foreach ($titulares as $titular)
                        <article class="text-left p-2 rounded btn-hover">
                            <a href="{{ $titular['href'] }}">
                                <h2 class="py-4 text-xl font-semibold">{{ $titular['titulo'] }}</h2>
                            </a>
                        </article>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>

<script>
    function transformJsonToStructuredArray(json) {
        return json.map(({ titulo, URL }) => ({ titulo, URL }));
    }

    // Utilizando Blade para imprimir el valor de $paper->slug
    var paperSlug = "{{ $paper->slug }}";

    fetch(`http://localhost:8000/api/TitularesPeriodico/${paperSlug}`)
        .then(response => response.json())
        .then(data => {
            const structuredData = transformJsonToStructuredArray(data);
            const dataContainer = document.getElementById('titularesData');

            structuredData.forEach(({ titulo, URL }) => {
                const titularContainer = document.createElement('article');
                titularContainer.classList.add('py-4', 'px-6', 'text-gray-900', 'dark:text-gray-100',
                    'btn-hover');

                const titularRute = document.createElement('a');
                titularRute.href = URL;
                titularContainer.appendChild(titularRute);

                const titularName = document.createElement('h2');
                titularName.textContent = titulo;
                titularRute.appendChild(titularName);

                dataContainer.appendChild(titularContainer);
            });
        })
        .catch(error => console.error('Error:', error));
</script>

</x-app-layout>