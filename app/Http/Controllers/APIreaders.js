

async function leerPeriodicos(url) {
    try {
        // Verificar que la URL no esté vacía
        if (!url) {
            throw new Error('Error: La URL no puede estar vacía.');
        }

        const response = await fetch(url);

        const data = await response.json();

        // Verificar si los datos son un array antes de devolverlos
        if (Array.isArray(data)) {
            console.log(data);
            return data;

        } else {
            throw new Error('Los datos recibidos no son un array.');
        }
    } catch (error) {
        throw error;
    }
}
