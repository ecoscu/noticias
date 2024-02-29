<?php

namespace App\Http\Controllers;

use App\Models\User_Periodico;
use Illuminate\Http\Request;

class User_PeriodicoController extends Controller
{
    function create($user, $paper){
        
        $userPeriodico = new User_Periodico();
        $userPeriodico->user_id = $user->id;
        $userPeriodico->periodico_id = $paper->id;
        $res = $userPeriodico->save();
    }

    function delete($paper){
        $deletepaper = User_Periodico::where('id', $paper->id)->first();
        $deletepaper->delete();
    }
}
