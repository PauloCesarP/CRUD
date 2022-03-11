<?php


namespace API\Models;


use CoffeeCode\DataLayer\DataLayer;

class Endereco extends DataLayer
{
    public function __construct()
    {
        parent::__construct (
            'endereco',
            [   'id_cidadao',
                'cep',
                'logradouro',
                'numero',
                'bairro',
                'cidade',
                'uf'
            ],
            'id', false
        );
    }
}