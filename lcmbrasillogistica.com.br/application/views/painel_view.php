<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt-br"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width" />
    <title><?php if(isset($titulo)): ?>{titulo} | <?php endif; ?>{titulo_padrao}</title>
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <link rel="apple-touch-icon" href="/images/faviconbrowser.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/images/faviconbrowser.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/images/faviconbrowser.png" />
    {headerinc}
</head>
<body>
    <?php if(esta_logado(FALSE)): ?>
        <div class="row header">
            <!--<div class="eight columns">
                <a href="<?php echo base_url('painel'); ?>"><h1>Painel ADM</h1></a>
            </div>-->
            <div class="eight columns">
                <a class="logo" href="<?php echo base_url('index'); ?>"></a>
            </div>
            <div class="four columns">
                <p class="text-right">Logado como <strong><?php echo $this->session->userdata('user_nome'); ?></strong></p>
                <!--<p class="text-right">
                    <?php echo anchor('usuarios/alterar_senha/'.$this->session->userdata('user_id'),'Alterar senha','class="button radius tiny"'); ?>
                    <?php echo anchor('usuarios/logoff','Sair','class="button radius tiny alert"'); ?>
                </p>-->
            </div>
        </div>
        <div class="row">
            <div class="twelve columns menu-site">
                <nav class="top-bar">
                    <ul class="left">
                        <li class="has-dropdown">
                            <?php echo anchor('#','Cadastros'); ?>
                            <ul class="dropdown">
                                <li><?php echo anchor('#','Cidades'); ?></li>
                                <li><?php echo anchor('#','Clientes'); ?></li>
                                <li><?php echo anchor('#','Embalagens'); ?></li>
                                <li><?php echo anchor('#','Espécies'); ?></li>
                                <li><?php echo anchor('#','Mercadorias'); ?></li>
                                <li><?php echo anchor('#','Motoristas'); ?></li>
                                <li><?php echo anchor('#','Navios'); ?></li>
                                <li><?php echo anchor('#','Paises'); ?></li>
                                <li><?php echo anchor('#','Portos'); ?></li>
                                <li><?php echo anchor('#','Serviços'); ?></li>
                                <li><?php echo anchor('#','Tipo de Veículos'); ?></li>
                                <li><?php echo anchor('#','Veículos'); ?></li>
                            </ul>
                        </li>
                        <li class="has-dropdown">
                            <?php echo anchor('#','Faturamento'); ?>
                            <ul class="dropdown">
                                <li><?php echo anchor('#','Faturas de Transporte'); ?></li>
                            </ul>
                        </li>
                        <li class="has-dropdown">
                            <?php echo anchor('#','Operacional'); ?>
                            <ul class="dropdown">
                                <li><?php echo anchor('solicitacao/gerenciar','Solicitação de Liberação'); ?></li>
                                <li><?php echo anchor('#','Ordem de Coleta'); ?></li>
                                <li><?php echo anchor('#','Vale Frete'); ?></li>
                                <li><?php echo anchor('#','Minutas'); ?></li>
                                <li class="has-dropdown">
                                    <?php echo anchor('#','CTRC'); ?>
                                    <ul class="dropdown">
                                        <li><?php echo anchor('#','Importação'); ?></li>
                                        <li><?php echo anchor('#','Exportação'); ?></li>
                                        <li><?php echo anchor('#','Gerar arquivo .TXT'); ?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-dropdown">
                            <?php echo anchor('#','Relatórios'); ?>
                            <ul class="dropdown">
                                <li><?php echo anchor('#','Frete - Terceiros'); ?></li>
                            </ul>
                        </li>
                        <li class="has-dropdown">
                            <?php echo anchor('#','Segurança'); ?>
                            <ul class="dropdown">
                                <li><?php echo anchor('#','Aplicativo'); ?></li>
                                <li><?php echo anchor('#','Grupos'); ?></li>
                                <li><?php echo anchor('usuarios/gerenciar','Usuários'); ?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('usuarios/logoff','Sair'); ?></li>

                    </ul>
                </nav>
            </div>
        </div>
    <?php endif; ?>
    <div class="row paineladm">
        {conteudo}
    </div>
  <div class="row rodape">
    <div class="twelve columns text-center">
        {rodape}
    </div>
  </div>
  {footerinc}
</body>
</html>
