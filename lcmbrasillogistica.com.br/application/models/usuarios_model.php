<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    public function do_insert($dados=NULL, $redir=TRUE){
        if ($dados != NULL):
            $this->db->insert('tbl_usuarios', $dados);
            if ($this->db->affected_rows()>0):
                auditoria('Inclusão de usuários', 'Usuário "'.$dados['login'].'" cadastrado no sistema');
                set_msg('msgok', 'Cadastro efetuado com sucesso', 'sucesso');
            else:
                set_msg('msgerro', 'Erro ao inserir dados', 'erro');
            endif;
            if ($redir) redirect(current_url());
        endif;
    }

    public function do_update($dados=NULL, $condicao=NULL, $redir=TRUE){
        if ($dados != NULL && is_array($condicao)):
            $usuario = $this->usuarios->get_byusucod($condicao['usucod'])->row()->login;
            $this->db->update('tbl_usuarios', $dados, $condicao);
            if ($this->db->affected_rows()>0):
                auditoria('Alteração de usuários', 'Alterado cadastro do usuário "'.$usuario.'"');
                set_msg('msgok', 'Alteração efetuada com sucesso', 'sucesso');
            else:
                set_msg('msgerro', 'Erro ao atualizar dados', 'erro');
            endif;
            if ($redir) redirect(current_url());
        endif;
    }

    public function do_delete($condicao=NULL, $redir=TRUE){
        if ($condicao != NULL && is_array($condicao)):
            $usuario = $this->usuarios->get_byusucod($condicao['usucod'])->row()->login;
            $this->db->delete('tbl_usuarios', $condicao);
            if ($this->db->affected_rows()>0):
                auditoria('Exclusão de usuários', 'Excluído cadastro do usuário "'.$usuario.'"');
                set_msg('msgok', 'Registro excluído com sucesso', 'sucesso');
            else:
                set_msg('msgerro', 'Erro ao excluir registro', 'erro');
            endif;
            if ($redir) redirect(current_url());
        endif;
    }

    public function do_login($usuario=NULL,$senha=NULL){
        if($usuario && $senha):
            $this->db->where('usulogin', $usuario);
            $this->db->where('ususenha', $senha);
            $query = $this->db->get('tbl_usuarios');
            if ($query->num_rows == 1):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            return FALSE;
        endif;
    }

    public function get_bylogin($login=NULL){
        if ($login != NULL):
            $this->db->where('usulogin', $login);
            $this->db->limit(1);
            return $this->db->get('tbl_usuarios');
        else:
            return FALSE;
        endif;
    }

    public function get_byemail($email=NULL){
        if ($email != NULL):
            $this->db->where('usuemail', $email);
            $this->db->limit(1);
            return $this->db->get('tbl_usuarios');
        else:
            return FALSE;
        endif;
    }

    public function get_byusucod($usucod=NULL){
        if ($usucod != NULL):
            $this->db->where('usucod', $usucod);
            $this->db->limit(1);
            return $this->db->get('tbl_usuarios');
        else:
            return FALSE;
        endif;
    }

    public function get_all(){
        return $this->db->get('tbl_usuarios');
    }

}

/* End of file tbl_usuarios_model.php */
/* Location: ./application/models/tbl_usuarios_model.php */