
<?php $v->layout("layout"); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>CPF</th>
        <th>Email</th>
        <th>Celular</th>
        <th>Cep</th>
        <th>Logradouro</th>
        <th>Numero</th>
        <th>Bairro</th>
        <th>Cidade</th>
        <th>UF</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($lista as $ind => $val){?>
        <tr>
            <td><?= $val['cidadao']->nome ?></td>
            <td><?= $val['cidadao']->sobrenome ?></td>
            <td><?= $val['cidadao']->cpf ?></td>
            <td><?= $val['contato'][0]->email ?></td>
            <td><?= $val['contato'][0]->celular ?></td>
            <td><?= $val['endereco'][0]->cep ?></td>
            <td><?= $val['endereco'][0]->logradouro ?></td>
            <td><?= $val['endereco'][0]->numero ?></td>
            <td><?= $val['endereco'][0]->bairro ?></td>
            <td><?= $val['endereco'][0]->cidade ?></td>
            <td><?= $val['endereco'][0]->uf ?></td>
            <td>
                <button class="btn btn-outline-info">
                    Alterar
                </button>
                <button class="btn btn-outline-danger">
                    Excluir
                </button>
            </td>
        </tr>
    <?php } ?>
    </tbody>

</table>
