<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodicoRequest;
use App\Models\Periodico;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class PeriodicoController extends Controller
{

    public function home()
    {
        return view('paper/home', [
            'paper' => Periodico::get()
        ]);
    }

    public function create(Request $request)
    {
        //abort_unless(Auth::check(), 404);
        return view('paper/create');
    }


    public function store(PeriodicoRequest $request)
    {
        //$user = Auth::user();

        function obtenerTituloDeURL($url)
        {
            // Obtener el contenido de la página web
            $contenido = file_get_contents($url);

            // Buscar la etiqueta <title> dentro del contenido
            preg_match("/<title>(.*?)<\/title>/i", $contenido, $matches);

            // Si se encontró la etiqueta <title>, devolver su contenido, de lo contrario devolver null
            if (isset($matches[1])) {
                return $matches[1];
            } else {
                return null;
            }
        }

        $titulo = obtenerTituloDeURL($request);

        $paper = new Periodico();
        $paper->name = $titulo;
        $paper->URL = $request->input('URL');
        $res = $paper->save();


        /*
        if ($request->successful()) {
            
            $htmlContent = $request->body();
        
            $crawler = new Crawler($htmlContent);
            
            $h2Elements = $crawler->filter('h2');
        
            $h2Titles = [];
            foreach ($h2Elements as $h2) {
                
                $h2Text = trim($h2->nodeValue);
                
                
                $h2Titles[] = $h2Text;
            }
        
            foreach ($h2Titles as $title) {
                echo $title . PHP_EOL;
            }
        } else {
            // Manejar el caso en el que la solicitud no fue exitosa
            echo "La solicitud no fue exitosa. Código de estado: " . $request->status();
        }*/

        if ($res) {
            return back()->with('status', 'Paper has been created sucessfully');
        }
    }
}