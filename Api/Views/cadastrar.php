    <?php $v->layout("layout"); ?>

        <form id="formCadastro">
            <div class="text-center font-weight-bold h2 m-4">
                Cadastro de Cidadão
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label  class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" required >
                </div>

                <div class="col mb-3">
                    <label  class="form-label">Sobrenome</label>
                    <input type="text" class="form-control" name="sobrenome" required >
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label  class="form-label">CPF</label>
                    <input type="text" class="form-control" name="cpf" maxlength="14" required >
                </div>

                <div class="col mb-3">
                    <label  class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required placeholder="name@example.com">
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label  class="form-label">Celular</label>
                    <input type="text" class="form-control" name="celular" maxlength="15" required >
                </div>

                <div class="col mb-3">
                    <label  class="form-label">CEP</label>
                    <input type="text" class="form-control" name="cep" maxlength="10" required >
                </div>
            </div>

            <div class="row">
                <div class="col-8 mb-3">
                    <label  class="form-label">Logradouro</label>
                    <input type="text" class="form-control" name="logradouro" required  >
                </div>

                <div class="col-4 mb-3">
                    <label  class="form-label">Numero</label>
                    <input type="text" class="form-control" name="numero" maxlength="7" required >
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label  class="form-label">Bairro</label>
                    <input type="text" class="form-control" name="bairro" required >
                </div>

                <div class="col-5 mb-3">
                    <label  class="form-label">Cidade</label>
                    <input type="text" class="form-control" name="cidade" required >
                </div>

                <div class="col-1 mb-3">
                    <label  class="form-label">UF</label>
                    <input type="text" class="form-control" name="uf" maxlength="2" required >
                </div>
            </div>

            <div class="text-end w-100">
                <button type="submit" class="btn btn-primary" style="width: 120px">
                    Salvar
                </button>
            </div>
        </form>

        <?php $v->start('script'); ?>
            <script>
                $(document).ready(function(){
                   $('input[name="cep"]').mask('00.000-000');
                   $('input[name="cpf"]').mask('000.000.000-00');
                   $('input[name="celular"]').mask('(00) 00000-0000');
                });

                $(document).on('change', 'input[name="cep"]', function (e){
                   e.preventDefault();

                    $.ajax({
                        url: 'https://viacep.com.br/ws/'+$(this).val().replace(/[^0-9]+/g, "")+'/json/',
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('input[name="logradouro"]').val(data.logradouro);
                            $('input[name="bairro"]').val(data.bairro);
                            $('input[name="cidade"]').val(data.localidade);
                            $('input[name="uf"]').val(data.uf);
                            $('input[name="numero"]').focus();
                        }
                    })
                });

                $(document).on('submit', '#formCadastro', function (e){
                    e.preventDefault();
                    $.ajax({
                        url: '<?= $router->route('rest.cadastrarCidadao'); ?>',
                        type: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function (data) {
                            if(data.existe){
                                alert('CPF ja cadastrado em nossa base de dados!!!');
                                return;
                            }
                            if(data.retorno){
                                alert('Cidadão cadastrado com sucesso!!!');
                                window.location.reload();
                            }
                        }
                    })
                })
            </script>
        <?php $v->end(); ?>