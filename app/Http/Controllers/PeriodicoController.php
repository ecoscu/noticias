<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodicoRequest;
use App\Models\Periodico;
use App\Models\User_Periodico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class PeriodicoController extends Controller
{

    public function home()
    {
        return view('dashboard', [
            'papers' => Periodico::get(),
            
        ]);
    }

    public function create(Request $request)
    {
        abort_unless(Auth::check(), 401);
        return view('paper/create');
    }

    public function getPaperId($url){
        $paper = Periodico::where('URL', $url)->first();
        return $paper ? $paper->id : null;
    }

    function validarURL($url) {
        $valdiate = false;
        if (!preg_match('/^(https?:\/\/)/', $url)) {
            $url = 'http://' . $url;
            $valdiate = true;
        }
        return $valdiate;
    }

    public function store(PeriodicoRequest $request)
    {
        
        if(!filter_var($request->input('URL'), FILTER_VALIDATE_URL)){
            return back()->withErrors(['msg' => "URL no valida"]);
        }

        function obtenerTituloDeURL($url) {
            
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

        /*$IDpaper = $this->getPaperId($request->input('URL'));

        $userPeriodicoController = new User_PeriodicoController();
        $userPeriodicoController->create(Auth::user(), $IDpaper);*/

        if ($res) {
            return back()->with('status', 'Periodico creado con exito');
        }

        return back()->withErrors(['msg', 'There was an error saving the newspaper, please try again later']);
    }
}
