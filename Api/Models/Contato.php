<?php


namespace API\Models;


use CoffeeCode\DataLayer\DataLayer;

class Contato extends DataLayer
{
    public function __construct()
    {
        parent::__construct (
            'contato',
            [   'id_cidadao',
                'email',
                'celular'
            ],
            'id', false
        );
    }
}