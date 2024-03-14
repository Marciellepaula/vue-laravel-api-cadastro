<?php

namespace App\Http\Controllers;

use App\Mail\trapEmail;
use App\Models\CadastroPessoa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{

    public function enviarEmail($cadastroId)
    {
        $cadastro = CadastroPessoa::find($cadastroId);
        $email =  $cadastro->email;
        $user = User::where('email', $email)->first();
        $email = $user->email;
        $password = $user->password;

        Mail::to($email)->send(new trapEmail($email, $password));
    }
}