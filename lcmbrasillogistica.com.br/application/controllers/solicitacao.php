<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solicitacao extends CI_Controller {

    public function __construct(){
        parent::__construct();
        init_painel();
        esta_logado();
        $this->load->model('solicitacao_model', 'solicitacao');
        $this->load->model('empresa_model', 'empresa');
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function cadastrar(){
        esta_logado();
        $this->form_validation->set_message('is_unique', 'Este %s já está cadastrado no sistema');
        $this->form_validation->set_rules('tp_solicitacao', 'TIPO', 'trim|required');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|is_unique[usuarios.email]|strtolower');
        $this->form_validation->set_rules('login', 'LOGIN', 'trim|required|min_length[4]|is_unique[usuarios.login]|strtolower');
        if ($this->form_validation->run()==TRUE):
            $dados = elements(array('nome', 'email', 'login'), $this->input->post());
            $this->usuarios->do_insert($dados);
        endif;
        set_tema('titulo', 'Cadastro de solicitação');
        set_tema('conteudo', load_modulo('solicitacao', 'cadastrar'));
        load_template();
    }

    public function gerenciar(){
        esta_logado();
        set_tema('footerinc', load_js(array('data-table', 'table')), FALSE);
        set_tema('titulo', 'Consulta de solicitação');
        set_tema('conteudo', load_modulo('solicitacao', 'gerenciar'));
        load_template();
    }

    public function editar(){
        esta_logado();
        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|ucwords');
        if ($this->form_validation->run()==TRUE):
            $dados['nome'] = $this->input->post('nome');
            $dados['ativo'] = ($this->input->post('ativo')==1 ? 1 : 0);
            if (is_admin(FALSE)) $dados['adm'] = ($this->input->post('adm')==1) ? 1 : 0;
            $this->usuarios->do_update($dados, array('id'=>$this->input->post('idusuario')));
        endif;
        set_tema('titulo', 'Atualização de solicitação');
        set_tema('conteudo', load_modulo('solicitacao', 'editar'));
        load_template();
    }

    public function excluir(){
        esta_logado();
        if (is_admin(TRUE)):
            $iduser = $this->uri->segment(3);
            if ($iduser != NULL):
                $query = $this->usuarios->get_byid($iduser);
                if ($query->num_rows()==1):
                    $query = $query->row();
                    if ($query->id != 1):
                        $this->usuarios->do_delete(array('id'=>$query->id), FALSE);
                    else:
                        set_msg('msgerro', 'Este usuário não pode ser excluído', 'erro');
                    endif;
                else:
                    set_msg('msgerro', 'Usuário não encontrado para exclusão', 'erro');
                endif;
            else:
                set_msg('msgerro', 'Escolha um usuário para excluir', 'erro');
            endif;
        endif;
        redirect('solicitacao/gerenciar');
    }
}

/* End of file solicitacao.php */
/* Location: ./application/controllers/solicitacao.php */