<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadastro_pessoa_id',
        'path',
    ];

    public function cadastroPessoa()
    {
        return $this->belongsTo(CadastroPessoa::class, 'cadastro_pessoa_id');
    }
}