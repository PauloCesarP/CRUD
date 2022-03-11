<?php


namespace API\Models;


use CoffeeCode\DataLayer\DataLayer;

class Cidadao extends DataLayer
{
    public function __construct()
    {
        parent::__construct (
            'cidadao',
            [
                'nome',
                'sobrenome',
                'cpf'
            ],
            'id', false
        );
    }

    public function contato()
    {
        return (new Contato())->find('id_cidadao = :id', "id={$this->id}")->fetch(true);
    }

    public function  endereco()
    {
        return (new Endereco())->find('id_cidadao = :id', "id={$this->id}")->fetch(true);
    }
}
