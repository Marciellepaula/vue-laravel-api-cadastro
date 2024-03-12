<?php

namespace App\Http\Controllers;

use App\Mail\trapEmail;
use App\Models\CadastroPessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{

    public function enviarEmail($cadastroId)
    {
        $cadastro = CadastroPessoa::find($cadastroId);
        $email =  $cadastro->email;

        Mail::to($email)->send(new trapEmail());
    }
}