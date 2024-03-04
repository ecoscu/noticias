<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use App\Models\Periodico;
use App\Http\Requests\PeriodicoRequest;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function Periodicos()
    {
        $papers = Periodico::get();
        return response()->json($papers);
    }

    public function getAllTitulares()
    {
        $paperURLs = Periodico::pluck('URL');
        $titulares = [];

        foreach ($paperURLs as $paperURL) {

            $titularesPeriodico = $this->obtenerTitularesPeriodico($paperURL);
            $titulares = array_merge($titulares, $titularesPeriodico);
        }

        return response()->json($titulares);
    }


    private function obtenerTitularesPeriodico($paperURLs)
    {
        $pagina = HttpClient::create();
        $response = $pagina->request('GET', $paperURLs);
        $content = $response->getContent();
        $crawler = new Crawler($content);

        $titulares = [];

        $crawler->filter('h2')->each(function ($node) use (&$titulares) {

            $titulo = $node->text();

            // Obtener el href de la etiqueta <a> dentro del titular
            $href = '';
            $aTag = $node->filter('a');
            if ($aTag->count() > 0) {
                $href = $aTag->attr('href');

                // Solo los titulares con href se añadiran al array de titulares
                $titulares[] = [
                    'titulo' => $titulo,
                    'URL' => $href
                ];
            };
        });
        return $titulares;
    }

    public function TitularesPeriodicoJSON($slug)
    {
        $periodico = Periodico::where('slug', $slug)->first();
        $pagina = HttpClient::create();
        $response = $pagina->request('GET', $periodico->URL);
        $content = $response->getContent();
        $crawler = new Crawler($content);

        $titulares = [];

        $crawler->filter('h2')->each(function ($node) use (&$titulares) {

            $titulo = $node->text();

            // Obtener el href de la etiqueta <a> dentro del titular
            $href = '';
            $aTag = $node->filter('a');
            if ($aTag->count() > 0) {
                $href = $aTag->attr('href');

                // Solo los titulares con href se añadiran al array de titulares
                $titulares[] = [
                    'titulo' => $titulo,
                    'URL' => $href
                ];
            };
        });
        return response()->json($titulares);
    }

    public function checkPaperURL($url)
    {
        $exists = Periodico::where('URL', $url)->exists();
        return $exists;
    }

    function obtenerTituloDeURL($link)
    {
        $headers = @get_headers($link);

        if ($headers && strpos($headers[0], '200')) {

            $pagina = HttpClient::create();
            $response = $pagina->request('GET', $link);
            $content = $response->getContent();
            $crawler = new Crawler($content);
            $titulo = $crawler->filter('title')->text();

            return $titulo;

        } else {
            return false;
        }
    }

    public function getPaperId($url)
    {
        $paperId = Periodico::where('URL', $url)->select('id')->first();
        return $paperId;
    }

    public function storePaper(Request $request, $link)
    {
        //valida si el periodico existe en la base de datos
        $periodicoExistente = Periodico::where('url', $link)->first();
        if ($periodicoExistente) {
            return response()->json(['Error' => 'El periodico ya existe en la base de datos'], 400);
        }

        //validar que la URL sea valida
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            return response()->json(['Error' => 'URL no valida'], 400);
        }

        //crear el periodico verificando que la URL tenga contenido
        if ($this->obtenerTituloDeURL($link) !== false) {
            $paper = new Periodico();
            $paper->name = $this->obtenerTituloDeURL($link);
            $paper->URL = $link;
            $res = $paper->save();
        } else {
            return response()->json(['Error' => 'URL sin contenido'], 400);
        }

        //creado con exito
        if ($res) {
            return response()->json(['success' => 'Periodico creado con exito'], 201);
        }

        return response()->json(['Error' => 'Hubo un error guardando el periodico'], 400);
    }


    function delete($id)
    {
        $periodico = Periodico::where('id', $id)->first();
        if (!$periodico) {
            return response()->json(['Error' => 'El periodico no existe en la base de datos'], 400);
        }

        $periodico->usuarios()->detach();

        $res = $periodico->delete();

        if ($res) {
            return response()->json(['success' => 'El periodico ha sido eliminado correctamente'], 201);
        }
    }
}
