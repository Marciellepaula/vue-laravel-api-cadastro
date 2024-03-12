<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroPessoa extends Model
{
    use HasFactory;

    protected $table = 'cadastro_pessoas';

    protected $fillable = [
        'nome', 'email', 'cpf', 'photo'
    ];

    protected $hidden = ['photo'];

    protected $appends = ['image'];


    public function Image(): Attribute
    {
        return new Attribute(
            get: fn () => $this->photo ? url("storage/{$this->photo}") : null
        );
    }

    public function upload()
    {
        return $this->hasMany(Upload::class);
    }
}