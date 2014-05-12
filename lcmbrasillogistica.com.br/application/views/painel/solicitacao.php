<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
switch ($tela):
    case 'cadastrar':
        echo '<div class="twelve columns">';
        echo breadcrumb();
        erros_validacao();
        get_msg('msgok');
        echo form_open('solicitacao/cadastrar', array('class'=>'custom'));
        echo form_fieldset('Cadastrar novo usuário');
        echo form_label('Nome completo');
        echo form_input(array('name'=>'nome', 'class'=>'five'), set_value('nome'), 'autofocus');
        echo form_label('Email');
        echo form_input(array('name'=>'email', 'class'=>'five'), set_value('email'));
        echo form_label('Login');
        echo form_input(array('name'=>'login', 'class'=>'three'), set_value('login'));
        echo form_label('Senha');
        echo form_password(array('name'=>'senha', 'class'=>'three'), set_value('senha'));
        echo form_label('Repita a senha');
        echo form_password(array('name'=>'senha2', 'class'=>'three'), set_value('senha2'));
        echo form_checkbox(array('name'=>'adm'), '1').' Dar poderes administrativos a este usuário<br /><br />';
        echo anchor('solicitacao/gerenciar', 'Cancelar', array('class'=>'button radius alert espaco'));
        echo form_submit(array('name'=>'cadastrar', 'class'=>'button radius'), 'Salvar Dados');
        echo form_fieldset_close();
        echo form_close();
        echo '</div>';
        break;
    case 'gerenciar':
        ?>
        <script type="text/javascript">
            $(function(){
                $('.deletareg').click(function(){
                    if (confirm("Deseja realmente excluir este registro?\nEsta operação não poderá ser desfeita!")) return true; else return false;
                });
            });
        </script>
        <div class="twelve columns">
            <?php
            echo breadcrumb();
            get_msg('msgok');
            get_msg('msgerro');
            ?>

            <table class="twelve data-table">

                <thead>
                    <p class="text-right">
                        <?php echo anchor('solicitacao/cadastrar','Cadastrar','class="button radius"'); ?>
                    </p>
                    <tr>
                        <th>Solicitação</th>
                        <th>Tipo Solicitação</th>
                        <th>Booking / DI</th>
                        <th>Cliente</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $this->solicitacao->get_all()->result();
                    foreach ($query as $linha):
                        $empresa = $this->empresa->get_byid($linha->id_cliente)->row();
                        echo '<tr>';
                        printf('<td>%s</td>', $linha->id_solicitacao);
                        printf('<td>%s</td>', ($linha->tp_solicitacao == 'I') ? 'IMPORTAÇÃO' : 'EXPORTAÇÃO');
                        printf('<td>%s</td>', $linha->ds_documento);
                        printf('<td>%s</td>', $empresa->nome_fantasia);
                        printf('<td class="text-center">%s%s</td>', anchor("solicitacao/editar/$linha->id_solicitacao", ' ', array('class'=>'table-actions table-edit', 'title'=>'Editar')), anchor("solicitacao/excluir/$linha->id_solicitacao", ' ', array('class'=>'table-actions table-delete deletareg', 'title'=>'Excluir')));
                        echo '</tr>';
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        break;
    case 'editar':
        $idsolicitacao = $this->uri->segment(3);
        if ($idsolicitacao==NULL):
            set_msg('msgerro', 'Escolha uma solicitação para alterar', 'erro');
            redirect('solicitacao/gerenciar');
        endif; ?>
        <div class="twelve columns">
            <?php
            echo breadcrumb();

            $query = $this->solicitacao->get_byid($idsolicitacao)->row();
            erros_validacao();
            get_msg('msgok');
            echo form_open(current_url(), array('class'=>'custom'));
            echo form_fieldset('Alterar solicitação');
            echo form_label('Nome completo');
            echo form_input(array('name'=>'nome', 'class'=>'five'), set_value('nome', $query->nome), 'autofocus');
            echo form_label('Email');
            echo form_input(array('name'=>'email', 'class'=>'five', 'disabled'=>'disabled'), set_value('email', $query->email));
            echo form_label('Login');
            echo form_input(array('name'=>'login', 'class'=>'three', 'disabled'=>'disabled'), set_value('login', $query->login));
            echo form_checkbox(array('name'=>'ativo'), '1', ($query->ativo==1) ? TRUE : FALSE).' Permitir o acesso deste usuário ao sistema<br /><br />';
            echo form_checkbox(array('name'=>'adm'), '1', ($query->adm==1) ? TRUE : FALSE).' Dar poderes administrativos a este usuário<br /><br />';
            echo anchor('solicitacao/gerenciar', 'Cancelar', array('class'=>'button radius alert espaco'));
            echo form_submit(array('name'=>'editar', 'class'=>'button radius'), 'Salvar Dados');
            echo form_hidden('id_solicitacao', $idsolicitacao);
            echo form_fieldset_close();
            echo form_close(); ?>
        </div>
        <?php
        break;
    default:
        echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
        break;
endswitch;