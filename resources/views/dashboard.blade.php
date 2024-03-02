<style>
    .btn-hover:hover {
        background-color: #3f5468;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('TITULARES') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div id="titularesData" class="p-6 text-gray-900 dark:text-gray-100">
                   <!--Recogida de datos de la API-->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function transformJsonToStructuredArray(json) {
        return json.map(({
            titulo,
            URL,

        }) => ({
            titulo,
            URL,
        }));
    }

    fetch('http://localhost:8000/api/Titulares')
        .then(response => response.json())
        .then(data => {
            const structuredData = transformJsonToStructuredArray(data);
            const dataContainer = document.getElementById('titularesData');

            structuredData.forEach(({
                titulo,
                URL,
            }) => {
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
