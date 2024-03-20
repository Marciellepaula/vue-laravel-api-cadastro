<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadastro_pessoa_id',
        'path',
    ];


    protected $hidden = ['path'];
    protected $appends = ['filepath'];


    // Define the accessor method for the filepath attribute
    public function Filepath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->path ? url("storage/{$this->path}") : null
        );
    }

    public function cadastroPessoa()
    {
        return $this->belongsTo(CadastroPessoa::class, 'cadastro_pessoa_id');
    }
}
