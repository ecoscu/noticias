<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodicoRequest;
use App\Models\Periodico;
use App\Models\User_Periodico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class PeriodicoController extends Controller
{

    public function home()
    {
        return view('dashboard', [
            'papers' => Periodico::get()

        ]);
    }

    public function papers()
    {
        abort_unless(Auth::check(), 401);

        return view('paper/periodicos', [
            'papers' => Periodico::get()

        ]);
    }

    public function create(Request $request)
    {
        abort_unless(Auth::check(), 401);
        return view('paper/create');
    }

    public function getPaperId($url)
    {
        $paperId = Periodico::where('URL', $url)->select('id')->first();
        return $paperId;
    }

    public function getPapersURLs()
    {
        $papers = Periodico::pluck('URL');
        return $papers;
    }

    public function checkPaperURL($url)
    {

        $exists = Periodico::where('URL', $url)->exists();
        return $exists;
    }

    public function store(PeriodicoRequest $request)
    {

        if (!filter_var($request->input('URL'), FILTER_VALIDATE_URL)) {
            return back()->withErrors(['msg' => "URL no valida"]);
        }

        if ($this->checkPaperURL($request->input('URL')) == false) {

            function obtenerTituloDeURL($url)
            {

                $pagina = HttpClient::create();
                $response = $pagina->request('GET', $url);
                $content = $response->getContent();
                $crawler = new Crawler($content);
                $titulo = $crawler->filter('title')->text();

                return $titulo;
            }

            $paper = new Periodico();
            $paper->name = obtenerTituloDeURL($request->input('URL'));
            $paper->URL = $request->input('URL');
            $res = $paper->save();

            $IDpaper = $this->getPaperId($request->input('URL'));

            $userPeriodicoController = new User_PeriodicoController();
            $userPeriodicoController->create(Auth::user(), $IDpaper);
        } else {
            return back()->withErrors(['msg' => "URL ya existente"]);
        }

        if ($res) {
            return back()->with('status', 'Periodico creado con exito');
        }

        return back()->withErrors(['msg', 'There was an error saving the newspaper, please try again later']);
    }


    private function obtenerTitularesPeriodico($paperURL)
    {
        $pagina = HttpClient::create();
        $response = $pagina->request('GET', $paperURL);
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
                    'href' => $href
                ];
            };
        });

        return $titulares;
    }


    public function getAllTitulares()
    {
        $paperURLs = $this->getPapersURLs();
        $titulares = [];

        foreach ($paperURLs as $paperURL) {

            $titularesPeriodico = $this->obtenerTitularesPeriodico($paperURL);
            $titulares = array_merge($titulares, $titularesPeriodico);
        }

        return view('dashboard', [
            'papers' => $titulares

        ]);
    }

    public function detail($slug)
    {
        $periodico = Periodico::where('slug', $slug)->first();
        abort_unless($periodico, 404);

        $titularesPeriodico = $this->obtenerTitularesPeriodico($periodico->URL);

        return view('paper.detail', [
            'paper' => $periodico,
            'titulares' => $titularesPeriodico
        ]);
    }

    public function deletePeriodico($id){
        abort_unless(Auth::check(), 404);
        $periodico = Periodico::where('id', $id)->first();
        $periodico->delete();
    }


}
