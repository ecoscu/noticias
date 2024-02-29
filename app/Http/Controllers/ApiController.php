<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use App\Models\Periodico;

class ApiController extends Controller
{
    public function Periodicos()
    {
        $papers = Periodico::get();
        return response()-> json($papers);
    }

    public function getAllTitulares()
    {   
        $paperURLs = Periodico::pluck('URL');
        $titulares = [];

        foreach ($paperURLs as $paperURL) {

            $titularesPeriodico = $this->obtenerTitularesPeriodico($paperURL);
            $titulares = array_merge($titulares, $titularesPeriodico);
        }

        return response()-> json($titulares);
    }


    private function obtenerTitularesPeriodico($paperID)
    {
        $periodico = Periodico::select('url')->where('id', $paperID)->first();
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

        return response()-> json($titulares);
    }
}
