<?php


namespace API\Controllers;

use API\Models\Cidadao;
use API\Models\Contato;
use API\Models\Endereco;


class Rest extends controle
{
    public function __construct($router)
    {
        parent::__construct ($router);
    }

    public function home(): void
    {
        $cidadao = (new Cidadao())->find ()->order('nome ASC')->fetch (true);
        foreach ($cidadao as $val) {
            $lista[] = [
                'cidadao' => $val,
                'contato' => $val->contato(),
                'endereco'=> $val->endereco()
            ];
        }
        echo $this->view->render("home", [
            'lista' => $lista
        ]);
    }

    /**
     * Exibir pagina de cadastro
     */
    public function cadastrar(): void
    {
        echo $this->view->render("cadastrar", []);
    }
    
    /**
     * Criação de Usuários
     */
    public function cadastrarCidadao(array $data)
    {

        $R['existe']=false;

        $cpf = preg_replace("/[^0-9]/", "",$data['cpf']);
        $celular = preg_replace("/[^0-9]/", "",$data['celular']);
        $cep = preg_replace("/[^0-9]/", "",$data['cep']);

        $cidadao = (new Cidadao())->find ('cpf = :cpf', "cpf={$cpf}")->fetch (true);

        if (!$cidadao) {
            $cidadao = new Cidadao();
            $cidadao->nome = filter_var ($data['nome'], FILTER_SANITIZE_STRIPPED);
            $cidadao->sobrenome = filter_var ($data['sobrenome'], FILTER_SANITIZE_STRIPPED);
            $cidadao->cpf = filter_var ($cpf, FILTER_SANITIZE_STRIPPED);
            $cidadao->save ();

            $contato = new Contato();
            $contato->id_cidadao = $cidadao->id;
            $contato->email = filter_var ($data['email'], FILTER_VALIDATE_EMAIL);
            $contato->celular = $celular;
            $contato->save ();

            $endereco = new Endereco();
            $endereco->id_cidadao = $cidadao->id;
            $endereco->cep = $cep;
            $endereco->logradouro = filter_var ($data['logradouro'], FILTER_SANITIZE_STRIPPED);
            $endereco->numero = filter_var ($data['numero'], FILTER_SANITIZE_STRIPPED);
            $endereco->bairro = filter_var ($data['bairro'], FILTER_SANITIZE_STRIPPED);
            $endereco->cidade = filter_var ($data['cidade'], FILTER_SANITIZE_STRIPPED);
            $endereco->uf = filter_var ($data['uf'], FILTER_SANITIZE_STRIPPED);
            $endereco->save ();


            $R['retorno'] = true;
        } else {
            $R['existe'] = true;
        }

        echo json_encode($R);

    }


    /**
     * Exibir Usuário individual (por CPF)
     */
    public function pesquisarCpf(array $data){

        $cidadao = (new \API\Models\Cidadao())->findById ($data['cpf']);
        if($cidadao) {
            echo json_encode ([
                $cidadao->id,
                $cidadao->name,
                $cidadao->sobrenome,
                $cidadao->cpf,
                $cidadao->email,
                $cidadao->celular,
                $cidadao->cep,
                $cidadao->logradouro,
                $cidadao->numero,
                $cidadao->bairro,
                $cidadao->cidade,
                $cidadao->estado,
            ]);
        }else{
            echo json_encode ('API Usuario - [ Usuário nao encontrado! ]');
        }
    }


    /**
     * Lista todos os Usuários cadastrados
     */
    public function listarCidadao()
    {
        $cidadao = (new Cidadao())->find ()->order('nome ASC')->fetch (true);
        foreach ($cidadao as $val) {
            $lista[] = [
                'cidadao' => $val,
                'contato' => $val->contato(),
                'endereco'=> $val->endereco()
            ];
        }
        echo $this->view->render("listar", [
            'lista' => $lista
        ]);


    }


    /**
     * Alteração de Usuário (por CPF)
     */
    public function atualizarCidadao(array $data)
    {
        $put = array();
        parse_raw_http_request($put);

        $cidadao = (new Cidadao())->findById($data['cpf']);
        $cidadao->name = filter_var ($put['name'], FILTER_SANITIZE_STRIPPED);
        $cidadao->sobrenome = filter_var ($put['sobrenome'], FILTER_SANITIZE_STRIPPED);
        $cidadao->cpf = filter_var ($put['cpf'], FILTER_SANITIZE_STRIPPED);
        $cidadao->email = filter_var ($put['email'], FILTER_VALIDATE_EMAIL);
        $cidadao->celular = filter_var ($put['celular'], FILTER_SANITIZE_STRIPPED);
        $cidadao->cep = filter_var ($put['cep'], FILTER_SANITIZE_STRIPPED);
        $cidadao->logradouro = filter_var ($put['logradouro'], FILTER_SANITIZE_STRIPPED);
        $cidadao->numero = filter_var ($put['numero'], FILTER_SANITIZE_STRIPPED);
        $cidadao->bairro = filter_var ($put['bairro'], FILTER_SANITIZE_STRIPPED);
        $cidadao->cidade = filter_var ($put['cidade'], FILTER_SANITIZE_STRIPPED);
        $cidadao->uf = filter_var ($put['uf'], FILTER_SANITIZE_STRIPPED);
        $cidadao->save();

        echo json_encode ('API Drinks - [ Cidadao alterado com sucesso! ]');
    }


    /**
     * Exclusão de Usuário (por CPF)
     */
    public function excluirCidadao(array $data)
    {

        $cidadao = (new Cidadao())->findById($data['cpf']);
        $cidadao->destroy();

        echo json_encode ('API Drinks - [ Cidadao excluido com sucesso! ]');
    }



    /**
     * Página não encontrada
     */
    public function error()
    {
        echo json_encode ('Pagina não encontrada!!! - [ Error 400 ]');
    }
}