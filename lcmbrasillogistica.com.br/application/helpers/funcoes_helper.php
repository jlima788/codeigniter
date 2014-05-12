<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//carrega um módulo do sistema devolvendo a tela solicitada
function load_modulo($modulo=NULL, $tela=NULL, $diretorio='painel'){
    $CI =& get_instance();
    if ($modulo!=NULL):
        return $CI->load->view("$diretorio/$modulo", array('tela'=>$tela), TRUE);
    else:
        return FALSE;
    endif;
}

//seta valores ao array $tema da classe sistema
function set_tema($prop, $valor, $replace=TRUE){
    $CI =& get_instance();
    $CI->load->library('sistema');
    if ($replace):
        $CI->sistema->tema[$prop] = $valor;
    else:
        if (!isset($CI->sistema->tema[$prop])) $CI->sistema->tema[$prop] = '';
        $CI->sistema->tema[$prop] .= $valor;
    endif;
}

//retorna os valores do array $tema da classe sistema
function get_tema(){
    $CI =& get_instance();
    $CI->load->library('sistema');
    return $CI->sistema->tema;
}

//inicializa o painel adm carregando os recursos necessários
function init_painel(){
    $CI =& get_instance();
    $CI->load->library(array('parser','sistema', 'session', 'form_validation'));
    $CI->load->helper(array('form', 'url', 'array', 'text'));
    //carregamento dos models
    $CI->load->model('usuarios_model', 'usuarios');

    set_tema('titulo_padrao', 'Sistema de Transporte');
    set_tema('rodape', '<p>&copy; 2014 | Todos os direitos reservados para <a href="http://agenciamanga.com.br">Agência Manga</a>');
    set_tema('template', 'painel_view');

    set_tema('headerinc', load_css(array('foundation.min','app')), FALSE);
    set_tema('headerinc', load_js(array('foundation.min', 'app')), FALSE);
    set_tema('footerinc', '');
}

//carrega um template passando o array $tema como parâmetro
function load_template(){
    $CI =& get_instance();
    $CI->load->library('sistema');
    $CI->parser->parse($CI->sistema->tema['template'], get_tema());
}

//carrega um ou vários arquivos .css de uma pasta
function load_css($arquivo=NULL, $pasta='css', $media='all'){
    if ($arquivo != NULL):
        $CI =& get_instance();
        $CI->load->helper('url');
        $retorno = '';
        if (is_array($arquivo)):
            foreach ($arquivo as $css):
                $retorno .= '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$css.css").'" media="'.$media.'" />';
            endforeach;
        else:
            $retorno .= '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$arquivo.css").'" media="'.$media.'" />';
        endif;
    endif;
    return $retorno;
}

//carrega um ou vários arquivos .js de uma pasta ou servidor remoto
function load_js($arquivo=NULL, $pasta='js', $remoto=FALSE){
    if ($arquivo != NULL):
        $CI =& get_instance();
        $CI->load->helper('url');
        $retorno = '';
        if (is_array($arquivo)):
            foreach ($arquivo as $js):
                if ($remoto):
                    $retorno .= '<script type="text/javascript" src="'.$js.'"></script>';
                else:
                    $retorno .= '<script type="text/javascript" src="'.base_url("$pasta/$js.js").'"></script>';
                endif;
            endforeach;
        else:
            if ($remoto):
                $retorno .= '<script type="text/javascript" src="'.$arquivo.'"></script>';
            else:
                $retorno .= '<script type="text/javascript" src="'.base_url("$pasta/$arquivo.js").'"></script>';
            endif;
        endif;
    endif;
    return $retorno;
}

//mostra erros de validação em forms
function erros_validacao(){
    if (validation_errors()) echo '<div class="alert-box alert">'.validation_errors('<p>', '</p>').'</div>';
}

//verifica se o usuário está logado no sistema
function esta_logado($redir=TRUE){
    $CI =& get_instance();
    $CI->load->library('session');
    $user_status = $CI->session->userdata('user_logado');
    if (!isset($user_status) || $user_status != TRUE):
        //$CI->session->sess_destroy();
        //$CI->session->sess_create();
        if ($redir):
            $CI->session->set_userdata(array('redir_para'=>current_url()));
            set_msg('errologin', 'Acesso restrito, faça login antes de prosseguir', 'erro');
            redirect('usuarios/login');
        else:
            return FALSE;
        endif;
    else:
        return TRUE;
    endif;
}

//define uma mensagem para ser exibida na próxima tela carregada
function set_msg($id='msgerro', $msg=NULL, $tipo='erro'){
    $CI =& get_instance();
    switch ($tipo):
        case 'erro':
            $CI->session->set_flashdata($id, '<div class="alert-box alert"><p>'.$msg.'</p></div>');
            break;
        case 'sucesso':
            $CI->session->set_flashdata($id, '<div class="alert-box success"><p>'.$msg.'</p></div>');
            break;
        default:
            $CI->session->set_flashdata($id, '<div class="alert-box"><p>'.$msg.'</p></div>');
            break;
    endswitch;
}

//verifica se existe uma mensagem para ser exibida na tela atual
function get_msg($id, $printar=TRUE){
    $CI =& get_instance();
    if ($CI->session->flashdata($id)):
        if ($printar):
            echo $CI->session->flashdata($id);
            return TRUE;
        else:
            return $CI->session->flashdata($id);
        endif;
    endif;
    return FALSE;
}

//verifica se o usuário atual é administrador
function is_admin($set_msg=FALSE){
    $CI =& get_instance();
    $user_admin = $CI->session->userdata('user_admin');
    if (!isset($user_admin) || $user_admin != TRUE):
        if ($set_msg) set_msg('msgerro', 'Seu usuário não tem permissão para executar esta operação', 'erro');
        return FALSE;
    else:
        return TRUE;
    endif;
}

//gera um breadcrumb com base no controller atual
function breadcrumb(){
    $CI =& get_instance();
    $CI->load->helper('url');
    $classe = ucfirst($CI->router->class);
    if ($classe == 'Painel'):
        $classe = anchor($CI->router->class, 'Início');
    else:
        $classe = anchor($CI->router->class, $classe);
    endif;
    $metodo = ucwords(str_replace('_', ' ', $CI->router->method));
    if ($metodo && $metodo != 'Index'):
        $metodo = " &raquo; ".anchor($CI->router->class."/".$CI->router->method, $metodo);
    else:
        $metodo = '';
    endif;
    return '<p>Sua localização: '.anchor('painel', 'Painel').' &raquo; '.$classe.$metodo.'</p>';
}

//seta um registro na tabela de auditoria
function auditoria($operacao, $obs='', $query=TRUE){
    $CI =& get_instance();
    $CI->load->library('session');
    $CI->load->model('auditoria_model', 'auditoria');
    if ($query):
        $last_query = $CI->db->last_query();
    else:
        $last_query = '';
    endif;
    if (esta_logado(FALSE)):
        $user_id = $CI->session->userdata('user_id');
        $user_login = $CI->usuarios->get_byusucod($user_id)->row()->usulogin;
    else:
        $user_login = 'Desconhecido';
    endif;
    $dados = array(
        'usuario' => $user_login,
        'operacao' => $operacao,
        'query' => $last_query,
        'observacao' => $obs,
    );
    $CI->auditoria->do_insert($dados);
}