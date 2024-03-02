<style>
    .btn-hover:hover {
        background-color: #3f5468;
    }

    .with-margin {
        margin-right: 1rem;
        /* Ajusta el valor según tus necesidades */
    }

    .icon:hover {
        scale: 125%;
        color: rgb(125, 28, 28)
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
                <div id='periodicosData' class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- @foreach ($papers as $paper)
                        <article class="text-left p-2 rounded btn-hover">
                            <a href="{{ "/paper/{$paper->slug}" }}">
                                <h2 class="py-4 text-xl font-semibold">{{ $paper->name }}</h2>
                                <p class="text-m">{{ $paper->URL }}</p>
                            </a>
                            <br>
                            <div class="options flex justify-end">
                                <form action="{{ route('delete.paper', $paper->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"><i class="fas fa-trash-alt icon"></i></button>
                                </form>
                            </div>
                        </article>
                    @endforeach --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function transformJsonToStructuredArray(json) {
        return json.map(({
            name,
            slug,
            URL
        }) => ({
            name,
            slug,
            URL
        }));
    }

    fetch('http://localhost:8000/api/Periodicos')
        .then(response => response.json())
        .then(data => {
            const structuredData = transformJsonToStructuredArray(data);
            const dataContainer = document.getElementById('periodicosData');

            structuredData.forEach(({
                name,
                slug,
                URL
            }) => {
                const periodicoContainer = document.createElement('article');
                periodicoContainer.classList.add('py-4', 'px-6', 'text-gray-900', 'dark:text-gray-100',
                    'btn-hover');

                const periodicoRute = document.createElement('a');
                periodicoRute.href = `/paper/${slug}`;
                periodicoContainer.appendChild(periodicoRute);

                const periodicoName = document.createElement('h3');
                periodicoName.textContent = name;
                periodicoRute.appendChild(periodicoName);

                const periodicoURL = document.createElement('a');
                periodicoURL.textContent = URL;
                periodicoRute.appendChild(periodicoURL);

                dataContainer.appendChild(periodicoContainer);

                //delete form

                const optionsContainer = document.createElement('div');
                optionsContainer.classList.add('options', 'flex', 'justify-end');

                const deleteForm = document.createElement('form');
                deleteForm.action = `/delete/paper/${slug}`;
                deleteForm.method = 'post';

                const csrfTokenInput = document.createElement('input');
                csrfTokenInput.type = 'hidden';
                csrfTokenInput.name = '_token';
                csrfTokenInput.value =
                'YOUR_CSRF_TOKEN'; // Reemplaza 'YOUR_CSRF_TOKEN' con el valor adecuado

                const deleteButton = document.createElement('button');
                deleteButton.type = 'submit';

                const deleteIcon = document.createElement('i');
                deleteIcon.classList.add('fas', 'fa-trash-alt', 'icon');

                deleteButton.appendChild(deleteIcon);
                deleteForm.appendChild(csrfTokenInput);
                deleteForm.appendChild(deleteButton);
                optionsContainer.appendChild(deleteForm);
                periodicoContainer.appendChild(optionsContainer);

                dataContainer.appendChild(periodicoContainer);
            });
        })
        .catch(error => console.error('Error:', error));
</script>
