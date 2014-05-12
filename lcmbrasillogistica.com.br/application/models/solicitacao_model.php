<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solicitacao_model extends CI_Model {

    public function do_insert($dados=NULL, $redir=TRUE){
        if ($dados != NULL):
            $this->db->insert('tbl_solicitacao', $dados);
            if ($this->db->affected_rows()>0):
                //auditoria('Inclusão de usuários', 'Usuário "'.$dados['login'].'" cadastrado no sistema');
                set_msg('msgok', 'Cadastro efetuado com sucesso', 'sucesso');
            else:
                set_msg('msgerro', 'Erro ao inserir dados', 'erro');
            endif;
            if ($redir) redirect(current_url());
        endif;
    }

    public function do_update($dados=NULL, $condicao=NULL, $redir=TRUE){
        if ($dados != NULL && is_array($condicao)):
            $solicitacao = $this->usuarios->get_byid_solicitacao($condicao['id_solicitacao'])->row()->id_solicitacao;
            $this->db->update('tbl_solicitacao', $dados, $condicao);
            if ($this->db->affected_rows()>0):
                //auditoria('Alteração de usuários', 'Alterado cadastro do usuário "'.$usuario.'"');
                set_msg('msgok', 'Alteração efetuada com sucesso', 'sucesso');
            else:
                set_msg('msgerro', 'Erro ao atualizar dados', 'erro');
            endif;
            if ($redir) redirect(current_url());
        endif;
    }

    public function do_delete($condicao=NULL, $redir=TRUE){
        if ($condicao != NULL && is_array($condicao)):
            $solicitacao = $this->solicitacao->get_byid($condicao['id_solicitacao'])->row()->id_solicitacao;
            $this->db->delete('tbl_solicitacao', $condicao);
            if ($this->db->affected_rows()>0):
                //auditoria('Exclusão de usuários', 'Excluído cadastro do usuário "'.$usuario.'"');
                set_msg('msgok', 'Registro excluído com sucesso', 'sucesso');
            else:
                set_msg('msgerro', 'Erro ao excluir registro', 'erro');
            endif;
            if ($redir) redirect(current_url());
        endif;
    }

    public function get_byid($id=NULL){
        if ($id != NULL):
            $this->db->where('id_solicitacao', $id);
            $this->db->limit(1);
            return $this->db->get('tbl_solicitacao');
        else:
            return FALSE;
        endif;
    }

    public function get_all(){
        return $this->db->get('tbl_solicitacao');
    }

}

/* End of file solicitacao_model.php */
/* Location: ./application/models/solicitacao_model.php */