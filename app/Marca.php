<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model {

    protected $fillable = ['codigo', 'nome'];

    public function getRules() {
        return Array(
            'codigo' => 'required|numeric',
            'nome'   => 'required|min:3|max:150'
        );
    }

    public function getMessageValidate() {
        return Array(
            'codigo.required' => 'O código é de preenchimento obrigatório',
            'codigo.numeric'  => 'O código deve ser número',
            'nome.required'   => 'O nome é de preenchimento obrigatório',
            'nome.min'        => 'O nome deve ter ao menos 3 caracteres',
            'nome.max'        => 'O nome deve ter no máximo 150 caracteres'
        );
    }

}
