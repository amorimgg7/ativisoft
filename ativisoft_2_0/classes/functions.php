<?php
 
// Ativa a exibição de erros (útil em ambiente de desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ativa o registro de erros (útil para produção)
ini_set('log_errors', 1);

// Caminho absoluto e gravável pelo servidor web
ini_set('error_log', __DIR__ . '/logs/erro_php.log'); // Corrigido para caminho relativo ao script

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Pragma: no-cache");


class Usuario  
{
    //public function conectar($cnpj_empresa)
//////////////////////////////////////////////////////////////////
//////////////////ESSENCIAIS//////////////////////////////////////
/////////////////////////////////////////////////////////////////
    public function conectar()
    {
        include("../../classes/conn.php"); 
        global $pdo;
        global $msgErro;
        try {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage(); 
        }
    }
    public function logar($email_pessoa, $senha_pessoa, $tipo_pessoa, $id_google, $id_facebook) 
    {
        
        $_SESSION['toEncoding'] = 'ISO-8859-1';
        $_SESSION['fromEncoding'] = 'UTF-8';
        $_SESSION['email_empresa'] = $email_pessoa;

        global $pdo;
        $loginCliente = $pdo->prepare("SELECT * FROM tb_pessoa p JOIN rel_master r ON r.cd_pessoa = p.cd_pessoa JOIN tb_acesso a ON r.cd_acesso = a.cd_acesso JOIN tb_empresa e ON e.cd_empresa = r.cd_empresa WHERE p.tipo_pessoa = 'cliente' AND p.id_google = :idg");
        //$loginCliente->bindValue(":tip", $tipo_pessoa);
        //$loginCliente->bindValue(":emc", $email_pessoa);
        $loginCliente->bindValue(":idg", $id_google);
        $loginCliente->execute();
        //echo "<script>window.alert('Area do cliente');</script>";

        if($loginCliente->rowCount() > 0){

            $cliente = $loginCliente->fetch();
                //session_start();
                $_SESSION['tipo_pessoa'] = 'cliente';
                $_SESSION['tel_cliente'] = $cliente['tel1_pessoa'];
                $_SESSION['cnpj_empresa_cliente'] = $cliente['cnpj_empresa'];

                $_SESSION['email_PESSOA'] = $cliente['email_pessoa'];
                
                $_SESSION['pnome_colab'] = $cliente['pnome_pessoa'];
                $_SESSION['snome_colab'] = $cliente['snome_pessoa'];


                //$_SESSION['tipo_pessoa'] = 'cliente';
                //echo "<script>window.alert('Area do cliente');</script>";
                //echo '<script>location.href="../../pages/samples/register.php";</script>';

                


                $_SESSION['md_assistencia'] = "style='display:none;'";
                $_SESSION['md_lanchonete'] = "style='display:none;'";
                $_SESSION['md_venda'] = "style='display:none;'";
                $_SESSION['cad_geral'] = "style='display:none;'";
                $_SESSION['md_cliente'] = "style='display:none;'";//$tb_acesso['md_cliente'];
                $_SESSION['md_fornecedor'] = "style='display:none;'";// $tb_acesso['md_fornecedor'];
                $_SESSION['md_clientefornecedor'] = "style='display:none;'";// $tb_acesso['md_clientefornecedor'];
                $_SESSION['md_patrimonio'] = "style='display:none;'";//$tb_acesso['md_patrimonio'];
                $_SESSION['md_hospedagem'] = "style='display:none;'";//$tb_acesso['md_hospedagem'];



            return true;
        }else{


        $login = $pdo->prepare("SELECT * FROM tb_pessoa WHERE tipo_pessoa = :tip AND email_pessoa = :emc");
        $login->bindValue(":tip", $tipo_pessoa);
        $login->bindValue(":emc", $email_pessoa);
        $login->execute();
        if($login->rowCount() > 0){
            //SELECT * FROM tb_pessoa WHERE tipo_pessoa = 'colab' AND email_pessoa = 'amorimgg7@gmail.com' AND (senha_pessoa = '' OR id_google = '104575877573693940893' OR id_facebook = '' )
            $login2 = $pdo->prepare("SELECT * FROM tb_pessoa WHERE tipo_pessoa = :tip AND email_pessoa = :emc AND (senha_pessoa = :sn OR id_google = :idg OR id_facebook = :idf)");
            $login2->bindValue(":tip", $tipo_pessoa);
            $login2->bindValue(":emc", $email_pessoa);
            $login2->bindValue(":idg", $id_google);
            $login2->bindValue(":idf", $id_facebook);
            $login2->bindValue(":sn", $senha_pessoa);
            $login2->execute();
            if($login2->rowCount() > 0)
            {
                $colab = $login2->fetch();
                //session_start();
                $_SESSION['cd_colab'] = $colab['cd_pessoa'];
                $_SESSION['email_colab'] = $colab['email_pessoa'];
                $_SESSION['senha_colab'] = $colab['senha_pessoa'];
                $_SESSION['pnome_colab'] = $colab['pnome_pessoa'];
                $_SESSION['snome_colab'] = $colab['snome_pessoa'];

                $sql1 = $pdo->prepare("SELECT * FROM rel_master WHERE cd_pessoa = ".$_SESSION['cd_colab']."");
                $sql1->execute();

                if($sql1->rowCount() == 0){
                    $sql2 = $pdo->prepare("INSERT INTO rel_master(token_alter, cd_pessoa, cd_estilo, cd_acesso, status_rel) VALUES ('100001', :cdp, 1, 1, 'ativo')");
                    $sql2->bindValue(":cdp", $_SESSION['cd_colab']);
                    $sql2->execute();
                }
                if($sql1->rowCount() > 0)
                {
                    //entrar no sistema(sessão)
                    $rel_master = $sql1->fetch();
                    //session_start();
                    $_SESSION['cd_estilo'] = $rel_master['cd_estilo'];
                    if(isset($rel_master['cd_acesso'])){
                        $_SESSION['cd_acesso'] = $rel_master['cd_acesso'];
                        $_SESSION['rel_geral'] = $rel_master;
                    }else{
                        $_SESSION['cd_acesso'] = 0;
                        $_SESSION['rel_geral'] = 0;
                    }

                    if(isset($rel_master['cd_empresa'])){
                        $_SESSION['cd_empresa'] = $rel_master['cd_empresa'];
                    }else{
                        $_SESSION['cd_empresa'] = 0;
                    }
                     
                    $_SESSION['cd_funcao'] = $rel_master['cd_acesso'];
                    
                    $_SESSION['cd_pessoa'] = $rel_master['cd_pessoa'];



                    $_SESSION['acesso_caixa_0001']          = $rel_master['acesso_caixa_0001'];
                    $_SESSION['acesso_assistencia_0002']    = $rel_master['acesso_assistencia_0002'];
                    $_SESSION['acesso_venda_0003']          = $rel_master['acesso_venda_0003'];
                    $_SESSION['acesso_patrimonio_0004']     = $rel_master['acesso_patrimonio_0004'];
                    $_SESSION['acesso_folhaponto_0005']     = $rel_master['acesso_folhaponto_0005'];
                    $_SESSION['acesso_financeiro_0006']     = $rel_master['acesso_financeiro_0006'];
                    $_SESSION['acesso_cadastro_0007']       = $rel_master['acesso_cadastro_0007'];
                    $_SESSION['acesso_pdv_0008']            = $rel_master['acesso_pdv_0008'];



                    
                    $sql4 = $pdo->prepare("SELECT * FROM tb_acesso WHERE cd_acesso = ".$_SESSION['cd_acesso']."");
                    $sql4->execute();
                    if($sql4->rowCount() > 0)
                    {
                        //entrar no sistema(sessão)
                        $tb_acesso = $sql4->fetch();
                        //session_start();
                        //egurança baseada em crud, ambas seguindo em ordem de 1 a 9
                        //Ler
                        //Escrever
                        //Modificar/inativar/excluir
                        //acesso total aos tres tópicos do crud é 999

                        $_SESSION['acesso_geral'] = $tb_acesso;
                        $_SESSION['titulo_acesso'] = $tb_acesso['titulo_acesso'];

                        
                        $md_cadastros = str_pad($tb_acesso['md_cadastros'], 3, '0', STR_PAD_LEFT); // Garante 3 dígitos
                        $_SESSION['md_cadastros']               =   $md_cadastros;
                        $_SESSION['md_cadastros_menu']          =   (((int)$md_cadastros[0]+(int)$md_cadastros[1]+(int)$md_cadastros[2]) > 3) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_cadastros_ler']           =   ((int)$md_cadastros[0] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_cadastros_escrever']      =   ((int)$md_cadastros[1] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_cadastros_modificar']     =   ((int)$md_cadastros[2] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        


                        $md_venda = str_pad($tb_acesso['md_venda'], 3, '0', STR_PAD_LEFT); // Garante 3 dígitos
                        $_SESSION['md_venda'] = $md_venda;
                        $_SESSION['md_venda_ler']           =   ((int)$md_venda[0] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_venda_escrever']      =   ((int)$md_venda[1] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_venda_modificar']     =   ((int)$md_venda[2] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_venda_produto']       =   (((int)$md_venda[0]+(int)$md_venda[1]+(int)$md_venda[2]) > 3) ? "style='display:block;'" : "style='display:none;'";

                        $md_caixa = str_pad($tb_acesso['md_caixa'], 3, '0', STR_PAD_LEFT); // Garante 3 dígitos
                        $_SESSION['md_caixa']       =   $md_caixa;
                        $_SESSION['md_caixa_menu']  =   (((int)$md_caixa[0]+(int)$md_caixa[1]+(int)$md_caixa[2]) > 3) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_caixa_1']     =   ((int)$md_caixa[0] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_caixa_2']     =   ((int)$md_caixa[1] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_caixa_3']     =   ((int)$md_caixa[2] >= 2) ? "style='display:block;'" : "style='display:none;'";

                        $md_comissao = str_pad($tb_acesso['md_comissao'], 3, '0', STR_PAD_LEFT); // Garante 3 dígitos
                        $_SESSION['md_comissao']            =   $md_comissao;
                        $_SESSION['md_comissao_menu']       =   (((int)$md_comissao[0]+(int)$md_comissao[1]+(int)$md_comissao[2]) > 3) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_comissao_ler']        =   ((int)$md_comissao[0] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_comissao_escrever']   =   ((int)$md_comissao[1] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_comissao_modificar']  =   ((int)$md_comissao[2] >= 2) ? "style='display:block;'" : "style='display:none;'";

                        $md_assistencia = str_pad($tb_acesso['md_assistencia'], 3, '0', STR_PAD_LEFT); // Garante 3 dígitos
                        $_SESSION['md_assistencia']            =   $md_assistencia;
                        $_SESSION['md_assistencia_menu']       =   (((int)$md_assistencia[0]+(int)$md_assistencia[1]+(int)$md_assistencia[2]) > 3) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_assistencia_ler']        =   ((int)$md_assistencia[0] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_assistencia_escrever']   =   ((int)$md_assistencia[1] >= 2) ? "style='display:block;'" : "style='display:none;'";
                        $_SESSION['md_assistencia_modificar']  =   ((int)$md_assistencia[2] >= 2) ? "style='display:block;'" : "style='display:none;'";

                        
                        $_SESSION['md_caixa']   =   $tb_acesso['md_caixa'];       
                        $_SESSION['md_assistencia'] =   $tb_acesso['md_assistencia'];
                        $_SESSION['md_venda']   =   $tb_acesso['md_venda'];
                        $_SESSION['md_patrimonio']  =   $tb_acesso['md_patrimonio'];
                        $_SESSION['md_folhaponto']  =   $tb_acesso['md_folhaponto'];
                        $_SESSION['md_financeiro']  =   $tb_acesso['md_financeiro'];
                        $_SESSION['md_cadastros']   =   $tb_acesso['md_cadastros'];
                        $_SESSION['md_pdv'] =   $tb_acesso['md_pdv'];

                        /*
                        if($tb_acesso['md_venda'] == '111'){
                            $_SESSION['md_venda'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_venda'] == '222'){
                            $_SESSION['md_venda'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_venda'] == '333'){
                            $_SESSION['md_venda'] = "style='display:none;'";
                        }
*/

                        if($tb_acesso['md_assistencia'] == "999"){
                            $_SESSION['md_assistencia'] = "style='display:block;'";
                        }
                        if($tb_acesso['md_assistencia'] == "111"){
                            $_SESSION['md_assistencia'] = "style='display:block;'";
                        }
                        if($tb_acesso['md_assistencia'] == "222"){
                            $_SESSION['md_assistencia'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_assistencia'] == "333"){
                            $_SESSION['md_assistencia'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_pdv'] == "111"){
                            $_SESSION['style_md_pdv'] = "style='display:none;'";
                        }
                        if($tb_acesso['style_md_pdv'] == "999"){
                            $_SESSION['style_md_pdv'] = "style='display:block;'";
                        }

                        
                        
                    
                        /*
                        if($tb_acesso['md_fponto'] == "999"){
                            $_SESSION['md_fponto'] = "style='display:block;'";
                        }
                        if($tb_acesso['md_fponto'] == "111"){
                            $_SESSION['md_fponto'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_fponto'] == "222"){
                            $_SESSION['md_fponto'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_fponto'] == "333"){
                            $_SESSION['md_fponto'] = "style='display:none;'";
                        }
                        */
                        $_SESSION['cad_geral'] = "";
                        $_SESSION['md_cliente'] = '';//$tb_acesso['md_cliente'];
                        //$_SESSION['md_fornecedor'] = '';// $tb_acesso['md_fornecedor'];
                        $_SESSION['md_clientefornecedor'] = '';// $tb_acesso['md_clientefornecedor'];
                        $_SESSION['md_patrimonio'] = '';//$tb_acesso['md_patrimonio'];
                        $_SESSION['md_hospedagem'] = '';//$tb_acesso['md_hospedagem'];
                        
                        //echo '<script>location.href="../../pages/dashboard/index.php";</script>';
                    }else{

                        $_SESSION['cad_geral'] = "style='display:none;'";
                        $_SESSION['md_assistencia'] = "style='display:none;'";
                        $_SESSION['md_cliente'] = "style='display:none;'";//$tb_acesso['md_cliente'];
                        $_SESSION['md_venda'] = "style='display:none;'";// $tb_acesso['md_fornecedor'];
                        $_SESSION['md_clientefornecedor'] = "style='display:none;'";// $tb_acesso['md_clientefornecedor'];
                        $_SESSION['md_patrimonio'] = "style='display:none;'";//$tb_acesso['md_patrimonio'];
                        $_SESSION['md_hospedagem'] = "style='display:none;'";//$tb_acesso['md_hospedagem'];
                    }
                
                }
                else{
                    //entrar no sistema(sessão)
                    //$seg_pessoal_empresa_estilo = $sql1->fetch();
                    //session_start();
                    //$_SESSION['cd_seg'] = 0;
                    //$_SESSION['cd_estilo'] = 0;
                    //$_SESSION['cd_empresa'] = 0; 
                    //$_SESSION['cd_setor'] = 0; 
                }

            }else{
                if($id_google != ''){
                    $updatePessoa = $pdo->prepare("UPDATE tb_pessoa SET id_google = :idg WHERE email_pessoa = :emp and tipo_pessoa = :tip");
                    $updatePessoa->bindValue(":tip", $tipo_pessoa);
                    $updatePessoa->bindValue(":idg", $id_google);
                    $updatePessoa->bindValue(":emp", $email_pessoa);
                    if($updatePessoa->execute()){
                        //echo '<script>location.href="../../pages/dashboard/index.php";</script>';
                        if($this->logar($email_pessoa, '', $tipo_pessoa, $id_google, $id_facebook)){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                    
                    
                    //echo "<script>window.alert('vincular ao google');</script>";
    
                }else{
                    echo "<script>window.alert('Senha errada');</script>";
                    //echo '<script>location.href="../../pages/samples/register.php";</script>';
                }
            }

            $sql4 = $pdo->prepare("SELECT * FROM tb_estilo WHERE cd_estilo = '".$_SESSION['cd_estilo']."'");
            $sql4->execute();

            if($sql4->rowCount() > 0)
            {
                
                //entrar no sistema(sessão)
                $tb_estilo = $sql4->fetch();
                //session_start();
                $_SESSION['t_sidebar'] = $tb_estilo['t_sidebar'];
                $_SESSION['c_sidebar'] = $tb_estilo['c_sidebar'];

                $_SESSION['t_navbar'] = $tb_estilo['t_navbar'];
                $_SESSION['c_navbar'] = $tb_estilo['c_navbar'];

                $_SESSION['t_font'] = $tb_estilo['t_font'];
                $_SESSION['c_font'] = $tb_estilo['c_font'];

                $_SESSION['c_body'] = $tb_estilo['c_body'];
                $_SESSION['c_card'] = $tb_estilo['c_card'];

                


            }


            $sql5 = $pdo->prepare("SELECT * FROM tb_empresa WHERE cd_matriz = '".$_SESSION['cd_empresa']."'");
            $sql5->execute();

            if($sql5->rowCount() > 0)
            {
                //entrar no sistema(sessão)
                $tb_empresa = $sql5->fetch();
                //session_start();
                $_SESSION['cnpj_empresa'] = $tb_empresa['cnpj_empresa'];
                $_SESSION['nfantasia_empresa'] = $tb_empresa['nfantasia_empresa'];
                $_SESSION['rsocial_empresa'] = $tb_empresa['rsocial_empresa'];
                $_SESSION['tipo_mensagem'] = $tb_empresa['tipo_mensagem'];
                $_SESSION['tipo_impressao'] = $tb_empresa['tipo_impressao'];
                

            }

            $sql6 = $pdo->prepare("SELECT * FROM tb_empresa WHERE cd_empresa = '".$_SESSION['cd_empresa']."'");
            $sql6->execute();

            if($sql6->rowCount() > 0)
            {
                //entrar no sistema(sessão)
                $tb_filial = $sql6->fetch();
                //session_start();
                $_SESSION['cd_filial'] = $tb_filial['cd_empresa'];
                $_SESSION['nfantasia_filial'] = $tb_filial['nfantasia_empresa'];
                $_SESSION['cnpj_filial'] = $tb_filial['cnpj_empresa'];
                $_SESSION['email_filial'] = $tb_filial['email_empresa'];
                $_SESSION['endereco_filial'] = $tb_filial['endereco_empresa'];
                $_SESSION['saudacoes_filial'] = $tb_filial['saudacoes_empresa'];
                

            }

            if($login2->rowCount() > 0){
                //echo '<script>location.href="../../pages/dashboard/index.php";</script>';
                //echo "<script>window.alert('colab 4:".$_SESSION['cd_colab']."');</script>";
                //echo json_encode(["success" => true, "message" => "Login realizado com sucesso"]);
                return true;
            }else{
                return false;
            }
        }
        else
        {
            if($id_google != ''){

                /*
                if($this->cadPessoa(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''))
                {
                    return true;
                }else{
                    return false;
                }
                */
                //return false;
                //echo "<script>window.alert('google:".$_SESSION['cd_colab']."');</script>";
                //$sql = $pdo->prepare("UPDATE tb_pessoa SET id_google = (:idg) WHERE email_pessoa = :emp");
                //$sql->bindValue(":idg", $id_google);
                //$sql->bindValue(":emp", $email_pessoa);
                //$sql->execute();
                //echo '<script>location.href="../../pages/dashboard/index.php";</script>';
                echo json_encode(["success" => false, "message" => "Erro ao realizar login"]);
                //echo "<script>window.alert('cadastrar');</script>";
                //echo '<script>location.href = `register.php?id_google=${encodeURIComponent(data.sub)}&name=${encodeURIComponent(data.name)}&email=${encodeURIComponent(data.email)}`;</script>';

                //exit();
                // //$email_pessoa, $senha_pessoa, $tipo_pessoa, $id_google, $id_facebook
                //echo '<script>location.href="../../pages/samples/register.php?email=' . urlencode($email_pessoa) . '";</script>';
                //return false;
                
                

            }else{
                echo "<script>window.alert('Email não encontrado \\nCadastre agora!');</script>";
                echo '<script>location.href="../../pages/samples/register.php?email=' . urlencode($email_pessoa) . '";</script>';
            }
            //$_SESSION['id_google'] = $id_google;
            //$_SESSION['id_google'] = $id_facebook;
            //$_SESSION['cademail_colab'] = $email_pessoa;
            //echo '<script>location.href="../../pages/samples/register.php";</script>';
            //echo "<script>window.alert('cadastrar geral');</script>";

            //não foi possivel logar
            return false;
        }
    }
        
        
    }
    



    ///////////////////////////////////////////////////////////////////////
    //////////////////CORRECOES ///////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////

    public function corrigeInconsistencia($cd_filial, $cd_servico, $cd_venda, $param_corrigido, $tipo_inconsistencia) 
    {
        global $conn;
        $u = new Usuario();
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        if($tipo_inconsistencia == 'FINANCEIRO VENDA'){

        }else if($tipo_inconsistencia == 'FINANCEIRO SERVICO'){
            try {

            $update_servico = "UPDATE tb_servico SET
                        orcamento_servico = '".$param_corrigido."',
                        vpag_servico = '".$param_corrigido."'
                        WHERE cd_servico = '".$cd_servico."'";
            mysqli_query($conn, $update_servico);
            
            // Recupera o serviço inserido
            $result_servico = $u->conServico($cd_servico, $cd_filial, false);
            
            if ($result_servico['status'] != 'OK') {
                return [
                    'status'            =>  'conServico: '.$result_servico['status'],
                    'cd_servico'        =>  '0',
                    'param_corrigido'   =>  'Erro'
                ];
            }
            
            // Commit na transação
            $conn->commit();

            return [
                'status'                =>  'OK',
                'cd_servico'            =>  $result_servico['cd_servico'],   
                'param_corrigido'       =>  $result_servico['vpag_servico']
            ];


                
                
            } catch (Exception $e) {
                $conn->rollback();
                return [
                    'status'            => addslashes($e->getMessage()),
                    'cd_servico'        => '0',
                    'param_corrigido'   =>   'Erro'
                ];
            }
        }else{
            
                return [
                    'status'            =>  'tipo_inconsistencia espera(FINANCEIRO VENDA | FINANCEIRO SERVICO)',
                    'cd_servico'        =>  '0',
                    'param_corrigido'   =>  ''
                ];
            
        }

        

            


            
            

    }

    ///////////////////////////////////////////////////////////////////////
    //////////////////CADASTROS ESSENCIAIS/////////////////////////////////
    ///////////////////////////////////////////////////////////////////////

    public function cadPessoa($nome_pessoa, $cpf_pessoa, $email_pessoa, $senha_pessoa, $tipo_pessoa, $id_google, $id_facebook)
    
    //public function cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $ecivil_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)
    {
        global $pdo;
        //verificar se ja está cadastrado
        $selectColab = $pdo->prepare("SELECT * FROM tb_pessoa WHERE email_pessoa = :emc");
        $selectColab->bindValue(":emc", $email_pessoa);
        $selectColab->execute();
        if($selectColab->rowCount() > 0)
        {session_start();//se ja estiver cadastrado
            //$_SESSION['concd_colab'];
            $rowColab = $selectColab->fetch();
            echo "<script>window.alert('Pessoa jà cadastrado para o email ".$email_pessoa."!');</script>";
            return false; //ja está cadastrado  
        }
        else
        {//não cadastrado, cadastrando agora

            if($id_google == ''){
                $id_google = 'N';
            }
            if($id_facebook == ''){
                $id_facebook = 'N';
            }
            

            $insertColab = $pdo->prepare("INSERT INTO tb_pessoa(pnome_pessoa, cpf_pessoa, email_pessoa, senha_pessoa, tipo_pessoa, id_google, id_facebook) VALUES (:nmc, :sfc, :emc, :snc, :tip, :idg, :idf)");
            $insertColab->bindValue(":tip", $tipo_pessoa);
            $insertColab->bindValue(":nmc", $nome_pessoa);
            $insertColab->bindValue(":sfc", $cpf_pessoa);
            $insertColab->bindValue(":emc", $email_pessoa);
            $insertColab->bindValue(":idg", $id_google);
            $insertColab->bindValue(":idf", $id_facebook);
            $insertColab->bindValue(":snc", $senha_pessoa);
            $insertColab->execute();

            $selectcdColab = $pdo->prepare("SELECT * FROM tb_pessoa WHERE email_pessoa = :emc");
            $selectcdColab->bindValue(":emc", $email_pessoa);
            $selectcdColab->execute();
            if($selectcdColab->rowCount() > 0)
            {
                echo "<script>window.alert('Login criado com sucesso');</script>";
                session_start();
                
                $rowColab = $selectcdColab->fetch();
                $_SESSION['concd_colab'] = $rowColab['cd_pessoa'];
                $_SESSION['conemail_colab'] = $rowColab['email_pessoa'];
                $_SESSION['consenha_colab'] = $rowColab['senha_pessoa'];
                $insertRel = $pdo->prepare("INSERT INTO rel_master(cd_pessoa, cd_estilo, status_rel) VALUES (:cdp, 1, 'ativo')");
                $insertRel->bindValue(":cdp", $rowColab['cd_pessoa']);
                if($insertRel->execute()){
                    echo "<script>window.alert('Nível de acesso criado com sucesso');</script>";
                    $this->logar($_SESSION['conemail_colab'], $_SESSION['consenha_colab'],'colab','','');
                    echo '<script>location.href="login.php";</script>';
                    return true;
                }else{
                    echo "<script>window.alert('Falha - Nível de acesso');</script>";
                }
            }else{
                echo "<script>window.alert('Falha - Usuario');</script>";
            }
        }
        //se não estiver cadastrado, vamos fazer o cadastro
        
    }

    public function conPessoa($tipo_pessoa, $tipo_busca, $chave_busca) 
    {
        global $conn;
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            if($tipo_pessoa == 'cliente'){

                // Recupera o serviço inserido
                $select_cliente = "SELECT * FROM tb_pessoa 
                    WHERE tipo_pessoa = 'cliente'";
                
                if($tipo_busca == 'codigo'){
                    $select_cliente = $select_cliente." AND cd_pessoa = '".$chave_busca."'";
                }else if($tipo_busca == 'telefone'){
                    $select_cliente = $select_cliente." AND tel1_pessoa = '".$chave_busca."'";
                }else{
                        return [
                            'status'        =>  '$tipo_busca espera (codigo ou telefone)',
                            'cd_cliente'    =>  '0'
                        ];
                    
                }
                
                $select_cliente = $select_cliente." LIMIT 1";

                

                      
                      

                
                $result_cliente = mysqli_query($conn, $select_cliente);
                $row_cliente = mysqli_fetch_assoc($result_cliente);
            
                
                if (!$row_cliente) {
                    return [
                        'status'        =>  'Não encontrado cliente',
                        'cd_cliente'    =>  '0'
                    ];
                }

                $select_divida = "SELECT 
                      SUM(orcamento_servico) AS total_orcamento, 
                      SUM(COALESCE(vpag_servico, 0)) AS total_pago, 
                      SUM(orcamento_servico) - SUM(COALESCE(vpag_servico, 0)) AS saldo_faltante
                  FROM 
                      tb_servico
                  WHERE 
                      status_servico != 4 AND
                      cd_filial = ".$_SESSION['cd_empresa']." AND
                      cd_cliente = ".$row_cliente['cd_pessoa']."
                  GROUP BY 
                      cd_cliente
                  HAVING 
                      SUM(orcamento_servico) - SUM(COALESCE(vpag_servico, 0)) > 0;
                ";



                $result_divida = mysqli_query($conn, $select_divida);
                $row_divida = mysqli_fetch_assoc($result_divida);
                if($row_divida) {
                  $acao_alerta = "<h5 style='color:#f00;' id='divida_cliente'>Dívida ativa de R$: ".number_format($row_divida['saldo_faltante'], 2, ',', '.')." </h1><a class='btn btn-block btn-lg btn-warning' style='margin: 5px;' href='".$_SESSION['dominio']."pages/md_assistencia/acompanha_servico.php?cnpj=".$_SESSION['cnpj_empresa']."&tel=".$row_cliente['tel1_pessoa']."'>Saiba Mais</a>";
                  $alerta_financeiro = "A L E R T A ! \\nO cliente ".$row_cliente['pnome_pessoa']." ".$row_cliente['snome_pessoa']." está com uma dívida ativa de R$:".number_format($row_divida['saldo_faltante'], 2, ',', '.')."";
                }else{
                    $acao_alerta = '';
                    $alerta_financeiro = 'OK';
                }


                $partial_cliente = '
                    <form method="POST">
                    <div class="card-body" id="abrirOS2">
                    <div class="kt-portlet__body">
                    <div class="row">
                    <div class="col-12 col-md-12">
                    <div id="" class="">
                    <h3 class="kt-portlet__head-title">Dados do Cliente</h3>
                    <div  class="typeahead" style="display:block;">
                    <input value="'.$row_cliente['cd_pessoa'].'" name="cd_cliente" type="text" id="cd_cliente" class=" form-control form-control-sm" style="display: none;"/>
                    <div class="form-group-custom">
                    <label for="showpnome_cliente">Nome</label>
                    <input value="'.$row_cliente['pnome_pessoa'].'" name="editpnome_cliente" type="text" id="showpnome_cliente" maxlength="40"   class=" form-control form-control-sm" readonly/>
                    </div>
                    <div class="form-group-custom">
                    <label for="showsnome_cliente">sobrenome</label>
                    <input value="'.$row_cliente['snome_pessoa'].'" name="showsnome_cliente" type="text" id="showsnome_cliente" maxlength="40"   class=" form-control form-control-sm" readonly/>
                    </div>
                    <div class="form-group-custom">
                    <label for="showtel_cliente">Telefone</label>
                    <input value="'.$row_cliente['tel1_pessoa'].'" name="showtel_cliente" type="tel"  id="showtel_cliente" oninput="tel(this)" class=" form-control form-control-sm" readonly/>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                ';

                $conn->commit();
            
                return [
                    'status'                =>  'OK',
                    'cd_cliente'            =>  $row_cliente['cd_pessoa'],
                    'pnome_cliente'         =>  $row_cliente['pnome_pessoa'],
                    'snome_cliente'         =>  $row_cliente['snome_pessoa'],
                    'cpf_cliente'           =>  $row_cliente['cpf_pessoa'],
                    'dtnasc_cliente'        =>  $row_cliente['dtnasc_pessoa'],
                    'obs_cliente'           =>  $row_cliente['obs_pessoa'],
                    'tel1_cliente'          =>  $row_cliente['tel1_pessoa'],
                    'obs_tel1_cliente'      =>  $row_cliente['obs_tel1_pessoa'],
                    'tel2_cliente'          =>  $row_cliente['tel2_pessoa'],
                    'obs_tel2_cliente'      =>  $row_cliente['obs_tel2_pessoa'],
                    'email_cliente'         =>  $row_cliente['email_pessoa'],
                    'senha_cliente'         =>  $row_cliente['senha_pessoa'],
                    'id_google'             =>  $row_cliente['id_google'],
                    'tipo_cliente'          =>  $row_cliente['tipo_pessoa'],
                    'subtipo_cliente'       =>  $row_cliente['subtipo_pessoa'],
                    'alerta_financeiro'     =>  $alerta_financeiro,
                    'acao_alerta'           =>  $acao_alerta,
                    'partial_cliente'       =>  $partial_cliente
                ];

            }else if($tipo_pessoa == 'colab'){

            }else{
                return [
                    'status'        =>  '($tipo) espera (cliente ou colab)',
                    'cd_cliente'    =>  '0',
                    'cd_colab'      =>  '0'
                ];
            }
               
        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_cliente'    => '0',
                'cd_colab'      => '0'
            ];
        }

    }

    public function atualizaPessoa($id_pessoa, $nome_pessoa, $cpf_pessoa, $email_pessoa, $id_google, $id_facebook, $tipo_pessoa)
    {
        global $pdo;
        $query = "UPDATE tb_pessoa SET ";

        if($nome_pessoa != ''){
            $query = $query." pnome_pessoa = (:nmp), ";
        }
        if($nome_pessoa != ''){
            $query = $query." cpf_pessoa = (:cfp), ";
        }
        if($nome_pessoa != ''){
            $query = $query." email_pessoa = (:emp), ";
        }
        if($nome_pessoa != ''){
            $query = $query." id_google = (:idg), ";
        }
        if($nome_pessoa != ''){
            $query = $query." id_facebook = (:idf), ";
        }
        
        $query = $query." tipo_pessoa = 'cliente' WHERE cd_pessoa = (:idp)";

        //UPDATE tb_pessoa SET foto_morador = (:ftm), tel_morador = (:tl), dt_nasc_morador = (:dn), cpf_morador = (:cf), senha_morador = (:sn) WHERE cd_pessoa = (:idm)

        
        $sql = $pdo->prepare($query);
        $sql->bindValue(":idp", $id_pessoa);
        $sql->bindValue(":nmp", $nome_pessoa);
        $sql->bindValue(":cfp", $cpf_pessoa);
        $sql->bindValue(":emp", $email_pessoa);
        $sql->bindValue(":idg", $id_google);
        $sql->bindValue(":idf", $id_facebook);//md5($senha_morador);$tipo_pessoa
        //$sql->bindValue(":tpp", $tipo_pessoa);
        if($sql->execute()){
            if($tipo_pessoa == 'cliente'){
                $sql2 = $pdo->prepare("UPDATE rel_master SET cd_acesso = 5 WHERE cd_pessoa = :idp");
                $sql2->bindParam(':idp', $id_pessoa);
                if($sql2->execute()){
                    echo "<script>window.alert('Sucesso para o email ".$email_pessoa.", da pessoa ".$id_pessoa."!');</script>";
                    //logar($email_pessoa, '', $tipo_pessoa, $id_google, $id_facebook);
                    return true;
                }
            }
            
           
        }else{
            echo "<script>window.alert('Não realizado para o email ".$email_pessoa."!');</script>";
            return false;
        }
       
        //echo '<script>location.href="AreaPrivada.php";</script>'; 
        //se não estiver cadastrado, vamos fazer o cadastro
    }

    public function cadServico($cd_cliente, $cd_colab, $cd_filial, $obs_servico, $prioridade_servico, $entrada_servico, $prazo_servico) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            // Insere o serviço
            $insert_servico = "INSERT INTO tb_servico(cd_cliente, cd_filial, obs_servico, prioridade_servico, entrada_servico, prazo_servico, orcamento_servico, vpag_servico, status_servico)
                VALUES('$cd_cliente', '$cd_filial', '$obs_servico', '$prioridade_servico', '$entrada_servico', '$prazo_servico', 0, 0, '0')";
            mysqli_query($conn, $insert_servico);
            
            // Recupera o serviço inserido
            $select_servico = "SELECT * FROM tb_servico WHERE cd_filial = '$cd_filial' AND cd_cliente = '$cd_cliente' AND status_servico = 0 ORDER BY cd_servico DESC LIMIT 1";
            $result_servico = mysqli_query($conn, $select_servico);
            $row_servico = mysqli_fetch_assoc($result_servico);
            
            if (!$row_servico) {
                return [
                    'status'        =>  'Não encontrado serviço',
                    'cd_servico'    =>  '0'
                ];
            }
            // Insere atividade relacionada
            $insert_atividade = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade)
                VALUES('{$row_servico['cd_servico']}', 'A', '{$row_servico['obs_servico']}', '$cd_colab', '$entrada_servico', '$entrada_servico')";
            mysqli_query($conn, $insert_atividade);
         
            $result_servico = $u->conServico($row_servico['cd_servico'], $cd_filial, false);
        
            if ($result_servico['status'] != 'OK') {
                return [
                    'status'        =>  'conServico: '.$result_servico['status'],
                    'cd_servico'    =>  '0'
                ];
            }
            
            $conn->commit();
        
            return [
                'status'                =>  $result_servico['status'],
                'cd_servico'            =>  $result_servico['cd_servico'],    
                'cd_filial'             =>  $result_servico['cd_filial'],
                'cd_cliente'            =>  $result_servico['cd_cliente'],    
                'id_servico'            =>  $result_servico['id_servico'],    
                'titulo_servico'        =>  $result_servico['titulo_servico'],        
                'obs_servico'           =>  $result_servico['obs_servico'],    
                'prioridade_servico'    =>  $result_servico['prioridade_servico'],            
                'entrada_servico'       =>  $result_servico['entrada_servico'],        
                'prazo_servico'         =>  $result_servico['prazo_servico'],    
                'orcamento_servico'     =>  $result_servico['orcamento_servico'],        
                'vpag_servico'          =>  $result_servico['vpag_servico'],    
                'status_servico'        =>  $result_servico['status_servico']        
            ];

        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_servico'  => '0'
            ];
        }

            


            
            

    }

    public function conServico($cd_servico, $cd_filial, $permite_editar) 
    {
        global $conn;
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            // Recupera o serviço inserido
            $select_servico = "SELECT * FROM tb_servico s, tb_pessoa c WHERE c.cd_pessoa = s.cd_cliente AND s.cd_filial = '$cd_filial' AND s.cd_servico = '$cd_servico' LIMIT 1";
            $result_servico = mysqli_query($conn, $select_servico);
            $row_servico = mysqli_fetch_assoc($result_servico);
            
            if (!$row_servico) {
                return [
                    'status'        =>  'Não encontrado serviço',
                    'cd_servico'    =>  '0'
                ];
            }
            
            $partial_servico = '
                <form method="POST" id="form_servico">

                <div class="card-body" id="abrirOS2">
                <div class="kt-portlet__body">
                <div class="row">
                <div class="col-12 col-md-12">
                <h3 class="kt-portlet__head-title">Dados do serviço</h3>
                <div  class="typeahead">

                <div class="form-group-custom">
                <label for="nome_cliente_servico">Cliente</label>
                <input value="'.$row_servico['cd_pessoa'].' '.$row_servico['snome_pessoa'].'" type="hidden" name="cd_cliente_servico" id="cd_cliente_servico" class=" form-control form-control-sm" readonly>
                <input value="'.$row_servico['pnome_pessoa'].' '.$row_servico['snome_pessoa'].'" type="text" name="nome_cliente_servico" id="nome_cliente_servico" class=" form-control form-control-sm" readonly>
                </div>

                <div class="form-group-custom">
                <label for="cliente_servico">Telefone</label>
                <input value="+'.$row_servico['tel1_pessoa'].'" type="text" name="cliente_servico" id="cliente_servico" class=" form-control form-control-sm" readonly>
                </div>

                <div class="form-group-custom">
                <label for="editos_servico">OS</label>
                <input value="'.$row_servico['cd_servico'].'" type="tel" name="cd_servico" id="cd_servico" class=" form-control form-control-sm" readonly>
                </div>

                <div class="form-group-custom">
                <label for="obs_servico">Descrição Geral</label>
                <!--<input value="'./*$row_servico['obs_servico']*/'" type="text" name="obs_servico" maxlength="999" id="obs_servico"  class=" form-control form-control-sm" placeholder="Caracteristica geral do serviço">-->
                <textarea name="obs_servico" maxlength="999" id="obs_servico"  class=" form-control form-control-sm" placeholder="Caracteristica geral do serviço" rows="3">'.$row_servico['obs_servico'].'</textarea>
                </div>
                

                <div class="form-group-custom">
                <label for="editprioridade_servico">Prioridade</label>
                <select name="prioridade_servico" id="prioridade_servico"  class=" form-control form-control-sm">
            ';                            
            if($row_servico['prioridade_servico'] == "U"){
                $partial_servico = $partial_servico.'<option selected="selected" value="'.$row_servico['prioridade_servico'].'" >Urgente</option>';
            }
            if($row_servico['prioridade_servico'] == "A"){
                $partial_servico = $partial_servico.'<option selected="selected" value="'.$row_servico['prioridade_servico'].'" >Alta</option>';
            }
            if($row_servico['prioridade_servico'] == "M"){
                $partial_servico = $partial_servico.'<option selected="selected" value="'.$row_servico['prioridade_servico'].'" >Média</option>';
            }
            if($row_servico['prioridade_servico'] == "B"){
                $partial_servico = $partial_servico.'<option selected="selected" value="'.$row_servico['prioridade_servico'].'" >Baixa</option>';
            }
            $partial_servico = $partial_servico.'
                <option value="U" >Urgente</option>
                <option value="A" >Alta</option>
                <option value="M" >Média</option>
                <option value="B" >Baixa</option>
                </select>
                </div>

                <div class="form-group-custom">
                <label>Entrada</label>
                <input value="'.$row_servico['entrada_servico'].'" type="datetime-local" class=" form-control form-control-sm" style="display: block; " readonly/>
                </div>

                <div class="form-group-custom">
                <label for="prazo_servico">Prazo</label>
                <input value="'.$row_servico['prazo_servico'].'" name="prazo_servico" type="datetime-local" id="prazo_servico" class=" form-control form-control-sm"/>
                </div>
                ';
                
            if($permite_editar){

                if($row_servico['orcamento_servico'] != 0){
                    if($row_servico['cd_colab_resp'] > 0){
                        $sql_colab_comissao = "SELECT * FROM tb_pessoa WHERE tipo_pessoa = 'colab' AND cd_filial = '".$_SESSION['cd_filial']."' ORDER BY CASE WHEN cd_pessoa = ".$row_servico['cd_colab_resp']." THEN 0 ELSE 1 END, cd_pessoa" ;       
                    }else{
                        $sql_colab_comissao = "SELECT * FROM tb_pessoa WHERE status_pessoa = 1 AND (vl_comissao_padrao > 0 OR pc_comissao_padrao > 0) AND tipo_pessoa = 'colab' AND cd_filial = '".$_SESSION['cd_filial']."'"; 
                    }
				    $colab_comissao = $conn->query($sql_colab_comissao);
    				if ($colab_comissao->num_rows > 0){
                        $partial_servico = $partial_servico.'
                            <div class="form-group row">
                                <select name="cd_colab_resp" id="cd_colab_resp" class="form-control col-12" required>	    
                        ';
                        if($row_servico['cd_colab_resp'] > 0){
                            
                        }else{
                            $partial_servico = $partial_servico.'
              				    <option value="">Quem fez este serviço?</option>
                            ';
                        }
                        while ( $row = $colab_comissao->fetch_assoc()){
                            $partial_servico = $partial_servico.'
                                <option value="'.$row['cd_pessoa'].'" vl-comissao="'.$row['vl_comissao_padrao'].'" pc-comissao="'.$row['pc_comissao_padrao'].'">'.$row['pnome_pessoa'].' '.$row['snome_pessoa'].' - '.$row['subtipo_pessoa'].'</option>
                            ';
                        }
                        $partial_servico = $partial_servico.'
                        </select>
                        </div>
                        '; 
                    
					$partial_servico = $partial_servico.' 
                        <!--<div class="form-group-custom">
                            <label for="vl_comissao">R$:</label>
                            <input type="tel" id="vl_comissao" name="vl_comissao" class="form-control form-control-sm col-6" >
                            <label for="pc_comissao">%</label>
                            <input type="tel" id="pc_comissao" name="pc_comissao" class="form-control form-control-sm col-6" >
                        </div>-->
                        <div class="row">
                            <div class="form-group-custom col-12" style="display:none;">
                                <label for="vl_servico">OS</label>
                                <input type="tel" value="'.$row_servico['orcamento_servico'].'" id="vl_servico" name="vl_servico" class="form-control">
                            </div>
                            <div class="form-group-custom col-6">
                                <label for="vl_comissao">R$:</label>
                                <input type="tel" value="'.$row_servico['vl_comissao'].'" id="vl_comissao" name="vl_comissao" class="form-control">
                            </div>
                            <div class="form-group-custom col-6">
                                <label for="pc_comissao">%</label>
                                <input type="tel" value="'.$row_servico['pc_comissao'].'" id="pc_comissao" name="pc_comissao" class="form-control">
                            </div>
                        </div>
                        ';
                        $partial_servico = $partial_servico.' 

                            <script>
                            function formatNumber(num) {
                                return parseFloat(num).toFixed(2);
                            }

                            document.getElementById("pc_comissao").addEventListener("input", function() {
                                let vlServico = parseFloat(document.getElementById("vl_servico").value) || 0;
                                let pc = parseFloat(this.value) || 0;

                                if(vlServico > 0 && pc >= 0) {
                                    let valor = (vlServico * pc) / 100;
                                    document.getElementById("vl_comissao").value = formatNumber(valor);
                                }
                            });

                            document.getElementById("vl_comissao").addEventListener("input", function() {
                                let vlServico = parseFloat(document.getElementById("vl_servico").value) || 0;
                                let vl = parseFloat(this.value) || 0;

                                if(vlServico > 0 && vl >= 0) {
                                    let percentual = (vl * 100) / vlServico;
                                    document.getElementById("pc_comissao").value = formatNumber(percentual);
                                }
                            });
                            </script>


                        <script>
                            document.getElementById("cd_colab_resp").addEventListener("change", function() {
                                var vlcomissao = this.options[this.selectedIndex].getAttribute("vl-comissao");
                                var pccomissao = this.options[this.selectedIndex].getAttribute("pc-comissao");
                                let vlServico = parseFloat(document.getElementById("vl_servico").value) || 0;
                                document.getElementById("vl_comissao").value = vlcomissao ? vlcomissao : "";
                                document.getElementById("pc_comissao").value = pccomissao ? pccomissao : "";



                                if(vlServico > 0 && pccomissao > 0) {
                                    let valor = (vlServico * pccomissao) / 100;
                                    document.getElementById("vl_comissao").value = formatNumber(valor);
                                    console.log("calculo pelo percentual");
                                }

                                if (vlServico > 0 && vlcomissao > 0) {
                                    let percentual = (vlcomissao * 100) / vlServico;
                                    document.getElementById("pc_comissao").value = formatNumber(percentual);
                                    console.log("cálculo pelo valor");
                                }


                            });
                        </script>
    
                    ';
				
                }
            }



                $partial_servico = $partial_servico.'
                    <td><button type="submit" name="editServico" id="editServico" class="btn btn-block btn-outline-success"><i class="icon-cog"></i>Salvar</button></td>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    <script>
                        document.getElementById("prioridade_servico").disabled = false;
                        document.getElementById("obs_servico").readOnly = false;
                        document.getElementById("prioridade_servico").readOnly = false;
                        document.getElementById("prazo_servico").readOnly = false;
                    </script>
                ';
            }else{
                $partial_servico = $partial_servico . '
                    <td>
                        <button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-block btn-outline-warning" onclick="enviarPara(\'cadastro_servico.php\')">
                            <i class="icon-cog"></i>Editar
                        </button>
                    </td>
                    </div>
                    </div>
                    </div>
                    </div>
                    
                    <script>
                        function enviarPara(url) {
                            document.getElementById("form_servico").action = url;
                        }
                        document.getElementById("prioridade_servico").disabled = true;
                        document.getElementById("obs_servico").readOnly = true;
                        document.getElementById("prioridade_servico").readOnly = true;
                        document.getElementById("prazo_servico").readOnly = true;
                    </script>
                ';
            }

            
            $sql_comissao_lancada = "SELECT c.*, p.*
                            FROM tb_comissao c
                            INNER JOIN tb_pessoa p ON p.cd_pessoa = c.cd_colab
                            WHERE c.cd_servico = '".$row_servico['cd_servico']."'
                              AND c.cd_filial = '".$_SESSION['cd_filial']."'";

                        $comissao_lancada = $conn->query($sql_comissao_lancada);
				        if ($comissao_lancada->num_rows > 0){
                            $partial_servico = $partial_servico.'
                			    <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div  class="typeahead">
                                            <h3 class="kt-portlet__head-title">Comissão lançada</h3>
                            ';
                            while ( $row = $comissao_lancada->fetch_assoc()){
                                $obs_comissao = str_replace('|', '<br>', $row['obs_comissao']);

                                $partial_servico .= '
                                    <p>(' . $row['cd_pessoa'] . ') - ' . $row['pnome_pessoa'] . ' ' . $row['snome_pessoa'] . 
                                    ' - (R$: ' . $row['vl_comissao'] . ') ' . $obs_comissao . '</p>
                                ';

                                if($row['status_comissao'] == 0){
                                    $partial_servico = $partial_servico.'
                                            <span class="bg-danger">Não pago</span></p>
                                            <script>
                                                document.getElementById("cd_colab_resp").disabled = false;
                                                document.getElementById("vl_comissao").disabled = false;
                                                document.getElementById("pc_comissao").disabled = false;
                                            </script>
                                    ';
                                }else{
                                    $partial_servico = $partial_servico.'
                                            <span class="bg-success">Pago</span></p>
                                            <script>
                                                document.getElementById("cd_colab_resp").disabled = true;
                                                document.getElementById("vl_comissao").disabled = true;
                                                document.getElementById("pc_comissao").disabled = true;
                                            </script>
                                    ';
                                }
                            }
                        }else{
                            $partial_servico = $partial_servico.'
                			    <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div  class="typeahead">
                                            <h3 class="kt-portlet__head-title">Sem Comissão</h3>
                                ';
                        }
                        $partial_servico = $partial_servico.'
                                        </div>
                                    </div>
                                </div>
                            </form>
                        ';
                    
                    




                $conn->commit();
            
                // Oculta o formulário
                //echo '<script>document.getElementById("cadOs").style.display = "none";</script>';
            

                return [
                    'status'                =>  'OK',
                    'cd_servico'            =>  $row_servico['cd_servico'],    
                    'cd_filial'             =>  $row_servico['cd_filial'],
                    'cd_cliente'            =>  $row_servico['cd_cliente'],    
                    'id_servico'            =>  $row_servico['id_servico'],    
                    'titulo_servico'        =>  $row_servico['titulo_servico'],        
                    'obs_servico'           =>  $row_servico['obs_servico'],    
                    'prioridade_servico'    =>  $row_servico['prioridade_servico'],            
                    'entrada_servico'       =>  $row_servico['entrada_servico'],        
                    'prazo_servico'         =>  $row_servico['prazo_servico'],    
                    'orcamento_servico'     =>  $row_servico['orcamento_servico'],        
                    'vpag_servico'          =>  $row_servico['vpag_servico'],
                    'cd_colab_resp'         =>  $row_servico['cd_colab_resp'],    
                    'status_servico'        =>  $row_servico['status_servico'],
                    'partial_servico'       =>  $partial_servico
                ];


                
                
            } catch (Exception $e) {
                $conn->rollback();
                return [
                    'status'        => addslashes($e->getMessage()),
                    'cd_servico'  => '0'
                ];
            }

    }

    public function editServico($cd_servico, $cd_filial, $obs_servico, $prioridade_servico, $prazo_servico, $cd_colab_resp, $vl_comissao, $pc_comissao) 
    {
        global $conn;
        $u = new Usuario();
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {

            $update_servico = "UPDATE tb_servico SET
                        obs_servico = '".$obs_servico."',
                        prioridade_servico = '".$prioridade_servico."',
                        prazo_servico = '".$prazo_servico."',
                        cd_colab_resp = '".$cd_colab_resp."',
                        vl_comissao = '".$vl_comissao."',
                        pc_comissao = '".$pc_comissao."'
                        WHERE cd_servico = '".$cd_servico."'";
            mysqli_query($conn, $update_servico);
            
            $select_comissao = "SELECT * FROM tb_comissao WHERE cd_servico = '".$cd_servico."'";
            $comissao = $conn->query($select_comissao);
            if ($comissao->num_rows > 0){
                while ( $row = $comissao->fetch_assoc()){
                    //$cd_servico = $row['cd_servico'];
                    
                    
                    if($row['cd_colab'] != $cd_colab_resp){
                        $update_comissao = "UPDATE tb_comissao SET
                            cd_colab = ".$cd_colab_resp.",
                            obs_comissao = CONCAT(obs_comissao, ' Colaborador Modificado por ".$_SESSION['pnome_colab']." (', DATE_FORMAT(NOW(), '%d/%m/%Y : %H:%i'), ') |')
                            WHERE cd_servico = ".$cd_servico;
                        mysqli_query($conn, $update_comissao);
                    }
                    if($row['vl_comissao'] != $vl_comissao){
                        $update_comissao = "UPDATE tb_comissao SET
                            vl_comissao = ".$vl_comissao.",
                            obs_comissao = CONCAT(obs_comissao, ' Valor Modificado por ".$_SESSION['pnome_colab']." (', DATE_FORMAT(NOW(), '%d/%m/%Y : %H:%i'), ') |')
                            WHERE cd_servico = ".$cd_servico;
                        mysqli_query($conn, $update_comissao);    
                    }

                }
            }else{
                if($vl_comissao != 0){
                    $insert_comissao = "INSERT INTO tb_comissao(cd_filial, cd_colab, cd_servico, vl_comissao, obs_comissao, status_comissao) VALUES(
                        '".$cd_filial."',
                        '".$cd_colab_resp."',
                        '".$cd_servico."',
                        ".$vl_comissao.",
                        CONCAT('Comissão lançada por ".$_SESSION['pnome_colab']." (', DATE_FORMAT(NOW(), '%d/%m/%Y : %H:%i'), ') |'),
                        0)
                    ";
                    mysqli_query($conn, $insert_comissao);
                }
            }
            // Recupera o serviço inserido
            $result_servico = $u->conServico($cd_servico, $cd_filial, false);
            
            if ($result_servico['status'] != 'OK') {
                return [
                    'status'        =>  'conServico: '.$result_servico['status'],
                    'cd_servico'    =>  '0'
                ];
            }
            
            // Commit na transação
            $conn->commit();

            return [
                'status'                =>  $result_servico['status'],   
                'obs_servico'           =>  $result_servico['obs_servico'],
                'prioridade_servico'    =>  $result_servico['prioridade_servico'],   
                'prazo_servico'         =>  $result_servico['prazo_servico']
            ];


                
                
            } catch (Exception $e) {
                $conn->rollback();
                return [
                    'status'        => addslashes($e->getMessage()),
                    'cd_servico'  => '0'
                ];
            }

            


            
            

    }

    public function cadVenda($cd_cliente, $cd_colab, $cd_filial) 
{
    global $conn;
    $u = new Usuario();

    $conn->autocommit(false); // Desliga o autocommit
    $conn->begin_transaction(); // Inicia a transação

    try {
        // Prepared statement para evitar SQL Injection
        $stmt = $conn->prepare("INSERT INTO tb_venda(cd_cliente, cd_filial, abertura_venda, orcamento_venda, vpag_venda, status_venda) VALUES (?, ?, NOW(), 0, 0, '0')");
        $stmt->bind_param("ii", $cd_cliente, $cd_filial);
        $stmt->execute();

        // Recupera o ID da venda inserida
        $cd_venda = $conn->insert_id;

        // Busca os dados da venda
        $result_venda = $u->conVenda('CV', $cd_venda, $cd_filial, false);

        if ($result_venda['status'] != 'OK') {
            throw new Exception("conVenda: " . $result_venda['cd_venda']);
        }

        $conn->commit();

        return [
            'status'                => 'OK',
            'cd_venda'              => $result_venda['cd_venda'],    
            'cd_filial'             => $result_venda['cd_filial'],
            'cd_cliente'            => $result_venda['cd_cliente'],    
            'id_venda'              => $result_venda['id_venda'],                
            'abertura_venda'        => $result_venda['abertura_venda'],        
            'orcamento_venda'       => $result_venda['orcamento_venda'],    
            'vpag_venda'            => $result_venda['vpag_venda'],        
            'status_venda'          => $result_venda['status_venda']        
        ];

    } catch (Exception $e) {
        $conn->rollback();
        return [
            'status'    => addslashes($e->getMessage()),
            'cd_venda'  => '0'
        ];
    }
    }


    public function conVenda($tipo_consulta, $key_consulta, $cd_filial, $permite_editar) 
    {
        global $conn;
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente


        $debug_data = [
        'tipo_consulta' => $tipo_consulta,
        'key_consulta' => $key_consulta,
        'cd_filial' => $cd_filial,
        'permite_editar' => $permite_editar
        ];

        $json_data = json_encode($debug_data);

        $partial_venda = "<script>console.log('conVenda:', " . $json_data . ");</script>";

        try {
            // Recupera o serviço inserido
            $select_venda = "SELECT * FROM tb_venda v, tb_pessoa c WHERE v.status_venda = '0' AND c.cd_pessoa = v.cd_cliente AND v.cd_filial = '$cd_filial' "; 
            if($tipo_consulta == 'CV'){
                $select_venda = $select_venda." AND v.cd_venda = '$key_consulta' ";
            }else if($tipo_consulta == 'CC'){
                $select_venda = $select_venda." AND v.cd_cliente = '$key_consulta' ";
                $cd_cliente = $key_consulta;
            }else{
                return [
                    'status'        =>  'tipo_consulta espera CV(Consulta Venda), CC(Consulta Cliente)',
                    'cd_venda'      =>  '0'
                ];
            }
            $select_venda = $select_venda." LIMIT 1 ";
            
            $result_venda = mysqli_query($conn, $select_venda);
            $row_venda = mysqli_fetch_assoc($result_venda);
            
            if (!$row_venda) {
                $partial_venda = '
                <form method="POST">

                <div class="card-body" id="abrirVenda">
                <div class="kt-portlet__body">
                <div class="row">

                <input value="'.$cd_cliente.'" name="cd_cliente" type="hidden" id="cd_cliente" class=" form-control form-control-sm"/>
                
                <td><button type="submit" name="cadVenda" id="cadVenda" class="btn btn-block btn-outline-success"><i class="icon-cog"></i>Criar Venda</button></td>
                
                </div>
                </div>
                </div>
                
                </form>
            ';

                return [
                    'status'            =>  'OK',
                    'partial_venda'     =>  $partial_venda,
                    'cd_venda'          =>  '0'
                ];
            }
            
            $partial_venda = $partial_venda.'
                <form method="POST" id="form_venda">

                <div class="card-body" id="abrirVenda">
                <div class="kt-portlet__body">
                <div class="row">
                <div class="col-12 col-md-12">
                <h3 class="kt-portlet__head-title">Dados da Venda</h3>
                <div  class="typeahead">

                <div class="form-group-custom">
                <label for="nome_cliente_venda">Cliente</label>
                <input value="'.$row_venda['cd_pessoa'].'" type="hidden" name="cd_cliente_venda" id="cd_cliente_venda" class=" form-control form-control-sm" readonly>
                <input value="'.$row_venda['cd_pessoa'].' - '.$row_venda['pnome_pessoa'].' '.$row_venda['snome_pessoa'].'" type="text" name="nome_cliente_venda" id="nome_cliente_venda" class=" form-control form-control-sm" readonly>
                </div>

                <div class="form-group-custom">
                <label for="cliente_venda">Telefone</label>
                <input value="+'.$row_venda['tel1_pessoa'].'" type="text" name="cliente_venda" id="cliente_venda" class=" form-control form-control-sm" readonly>
                </div>

                <!--<div class="form-group-custom">
                <label for="editcd_venda">Venda</label>-->
                <input value="'.$row_venda['cd_venda'].'" type="hidden" name="cd_venda" id="cd_venda" class=" form-control form-control-sm" readonly>
                <!--</div>-->

                <div class="form-group-custom">
                <label>Abertura</label>
                <input value="'.$row_venda['abertura_venda'].'" type="datetime-local" class=" form-control form-control-sm" style="display: block; " readonly/>
                </div>
            ';
            if(isset($row_venda['fechamento_venda'])){
                $partial_venda = $partial_venda.'
                    <div class="form-group-custom">
                        <label for="fechamento_venda">Fechamento</label>
                        <input value="'.$row_venda['fechamento_venda'].'" name="fechamento_venda" type="datetime-local" id="fechamento_venda" class=" form-control form-control-sm" readonly/>
                    </div>
                ';
            }else{
                if($permite_editar){
                    if($row_venda['orcamento_venda'] == $row_venda['vpag_venda']){
                        $partial_venda = $partial_venda.'
                            <div class="form-group-custom">
                                <label for="fechamento_venda">Fechamento</label>
                                <td><button type="submit" name="fecharVenda" id="fecharVenda" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Fechar Venda</button></td>
                            </div>
                        ';    
                    }else{
                        $partial_venda = $partial_venda.'
                            <div class="form-group-custom">
                                <td><h5>Falta Pagar (R$: '.number_format($row_venda['orcamento_venda'] - $row_venda['vpag_venda'], 2, '.', '.').')</h5></button></td>
                            </div>
                        ';
                    }
                    $partial_venda = $partial_venda.'
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    ';
                }else{

                    $partial_venda = $partial_venda . '
                    <td><button type="submit" name="con_edit_venda" id="con_edit_venda" class="btn btn-block btn-outline-warning" onclick="enviarPara(\'nova_conta.php\')"><i class="icon-cog"></i>Editar</button></td>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    <script>
                        function enviarPara(url) {
                            document.getElementById("form_venda").action = url;
                        }
                        //document.getElementById("prioridade_servico").disabled = true;
                        //document.getElementById("obs_servico").readOnly = true;
                        //document.getElementById("prioridade_servico").readOnly = true;
                        //document.getElementById("prazo_servico").readOnly = true;
                    </script>
                ';

                }
            }
            
/*
            if($permite_editar){
                $partial_venda = $partial_venda.'
                    <td><button type="submit" name="editVenda" id="editVenda" class="btn btn-block btn-outline-success"><i class="icon-cog"></i>Salvar</button></td>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    <script>
                        document.getElementById("prioridade_servico").disabled = false;
                        document.getElementById("obs_servico").readOnly = false;
                        document.getElementById("prioridade_servico").readOnly = false;
                        document.getElementById("prazo_servico").readOnly = false;
                    </script>
                ';
            }else{
                $partial_venda = $partial_venda . '
                    <td><button type="submit" name="con_edit_venda" id="con_edit_venda" class="btn btn-block btn-outline-warning" onclick="enviarPara(\'nova_conta.php\')"><i class="icon-cog"></i>Editar</button></td>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    <script>
                        function enviarPara(url) {
                            document.getElementById("form_venda").action = url;
                        }
                        //document.getElementById("prioridade_servico").disabled = true;
                        //document.getElementById("obs_servico").readOnly = true;
                        //document.getElementById("prioridade_servico").readOnly = true;
                        //document.getElementById("prazo_servico").readOnly = true;
                    </script>
                ';
            }
*/
                    




                $conn->commit();
            
                // Oculta o formulário
                //echo '<script>document.getElementById("cadOs").style.display = "none";</script>';
            

                return [
                    'status'                =>  'OK',
                    'cd_venda'              =>  $row_venda['cd_venda'],    
                    'cd_filial'             =>  $row_venda['cd_filial'],
                    'cd_cliente'            =>  $row_venda['cd_cliente'],    
                    'id_venda'              =>  $row_venda['id_venda'],    
                    'abertura_venda'        =>  $row_venda['abertura_venda'],        
                    'fechamento_venda'      =>  $row_venda['fechamento_venda'],    
                    'orcamento_venda'       =>  $row_venda['orcamento_venda'],        
                    'vpag_venda'            =>  $row_venda['vpag_venda'],    
                    'status_venda'          =>  $row_venda['status_servico'],
                    'partial_venda'         =>  $partial_venda
                ];


                
                
            } catch (Exception $e) {
                $conn->rollback();
                return [
                    'status'        => addslashes($e->getMessage()),
                    'cd_venda'      => '0'
                ];
            }

    }

    public function conEmpresa($tipo_consulta, $key_consulta, $permite_editar) 
    {
        global $conn;
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente


        $debug_data = [
        'tipo_consulta' => $tipo_consulta,
        'key_consulta' => $key_consulta,
        'permite_editar' => $permite_editar
        ];

        $json_data = json_encode($debug_data);

        $partial_empresa = "<script>console.log('conEmpresa:', " . $json_data . ");</script>";

        try {
            // Recupera o serviço inserido
            $select_empresa     =   "SELECT * FROM tb_empresa e, tb_pessoa p WHERE p.cd_pessoa = e.cd_proprietario ";
                      
            if($tipo_consulta == 'CD'){
                $select_empresa = $select_empresa." AND e.cd_empresa = '$key_consulta' ";
            }else if($tipo_consulta == 'CCNPJ'){
                $select_empresa = $select_empresa." AND e.cnpj_empresa = '$key_consulta' ";
                $cd_proprietario = $key_consulta;
            }else{
                return [
                    'status'        =>  'tipo_consulta espera CV(Consulta Venda), CC(Consulta Cliente)',
                    'cd_venda'      =>  '0'
                ];
            }
            $select_empresa = $select_empresa." LIMIT 1 ";
            
            $result_empresa = mysqli_query($conn, $select_empresa);

            
            $row_empresa = mysqli_fetch_assoc($result_empresa);
            
            if (!$row_empresa) {
                $partial_empresa = $partial_empresa.'
                <form method="POST">
                <div class="card-body" id="abrirVenda">
                <div class="kt-portlet__body">
                <div class="row">
                <input value="'.$cd_proprietario.'" name="cd_proprietario" type="text" id="cd_cliente" class=" form-control form-control-sm"/>
                <td><button type="submit" name="cadVenda" id="cadEmpresa" class="btn btn-block btn-outline-success"><i class="icon-cog"></i>Criar Empresa</button></td>
                <h1>'.$select_empresa.'</h1>
                </div>
                </div>
                </div>                
                </form>
            ';

                return [
                    'status'              =>  'OK',
                    'partial_empresa'     =>  $partial_empresa,
                    'cd_empresa'          =>  '0'
                ];
            }
            
            $select_contrato    =   "SELECT * FROM tb_contrato WHERE cd_empresa = '".$row_empresa['cd_empresa']."' ORDER BY cd_contrato ASC";
            $result_contrato    =   mysqli_query($conn, $select_contrato);
            

            $partial_empresa = $partial_empresa.'
                <div class="card-body" id="cadastroCliente">
                    <h3 class="kt-portlet__head-title">Dados da Empresa</h3>
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="nc-form-tac">
                                    <form method="POST" id="form_empresa">
                                        <div class="typeahead">
                                            <input value="'.$row_empresa['cd_empresa'].'" name="cadcd_cliente_comercial" type="hidden" id="cadcd_cliente_comercial" class=" form-control form-control-sm" style="display: block;" readonly/>
                                            <div class="form-group-custom">
                                               <label for="nome_proprietario_empresa">Proprietário</label>
                                               <input value="'.$row_empresa['cd_proprietario'].'" type="hidden" name="cd_proprietario_empresa" id="cd_proprietario_empresa" class=" form-control form-control-sm" readonly>
                                               <input value="'.$row_empresa['cd_pessoa'].' - '.$row_empresa['pnome_pessoa'].' '.$row_empresa['snome_pessoa'].'" type="text" name="nome_cliente_venda" id="nome_cliente_venda" class=" form-control form-control-sm" readonly>
                                           </div>
                                           <div class="form-group-custom">
                                               <label for="cadrsocial_cliente_comercial">Razão Social</label>
                                               <input value="'.$row_empresa['rsocial_empresa'].'" name="cadrsocial_cliente_comercial" type="text" id="cadrsocial_cliente_comercial" maxlength="100" class="aspNetDisabled form-control form-control-sm"  value="'.$row_empresa['cd_pessoa'].' - '.$row_empresa['pnome_pessoa'].' '.$row_empresa['snome_pessoa'].'" required/>
                                           </div>
                                           <div class="form-group-custom">
                                               <label for="cadnfantasia_cliente_comercial">Nome Fantasia</label>
                                               <input value="'.$row_empresa['nfantasia_empresa'].'" name="cadnfantasia_cliente_comercial" type="text" id="cadnfantasia_cliente_comercial" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>
                                           </div>
                                            <div class="form-group-custom">
                                               <label for="cadcnpj_cliente_comercial">CNPJ</label>
                                               <input value="'.$row_empresa['cnpj_empresa'].'" name="cadcnpj_cliente_comercial" type="text" id="cadcnpj_cliente_comercial" maxlength="90" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" readonly/>                            
                                           </div>
                                           <div class="form-group-custom">
                                               <label for="btntel_cliente">Telefone Filial</label>
                                               <input value="'.$row_empresa['tel1_empresa'].'" name="cadtel_cliente_comercial" type="tel"  id="cadtel_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                                           </div>
                                           <div class="form-group-custom">
                                               <label for="cademail_cliente_comercial">Email Filial</label>
                                               <input value="'.$row_empresa['email_empresa'].'" name="cademail_cliente_comercial" type="tel"  id="cademail_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                                           </div>
                                           <div class="form-group-custom">
                                               <label for="cadsaudacao_cliente_comercial">Saudações</label>
                                               <input value="'.$row_empresa['saudacoes_empresa'].'" name="cadsaudacao_cliente_comercial" type="tel"  id="cadsaudacao_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                                           </div>
                                           <div class="form-group-custom">
                                               <label for="cadtipo_mensagem_cliente_comercial">Tipo de Mensagens</label>
                                               <input value="'.$row_empresa['tipo_mensagem'].'" name="cadtipo_mensagem_cliente_comercial" type="tel"  id="cadtipo_mensagem_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                                           </div>
                                           <div class="form-group-custom">
                                               <label for="cadtipo_impressao_cliente_comercial">Tipo de Impressão</label>
                                               <input value="'.$row_empresa['tipo_impressao'].'" name="cadtipo_impressao_cliente_comercial" type="tel"  id="cadtipo_impressao_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                                           </div>
                                           <td><button type="hidden" name="cad_cliente_comercial" id="cad_cliente_comercial" class="btn btn-block btn-outline-success"><i class="icon-cog">Gravar</i></button></td>
                                                
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';

            $partial_empresa = $partial_empresa.'
                <div class="card-body">
                    <div class="kt-portlet__body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div  class="nc-form-tac">
                                    <h3 class="kt-portlet__head-title">Lançar novo Contrato</h3>
                                    <form method="post">
                                        <div class="typeahead" style="background-color: #C6C6C6;">
                                            <div class="horizontal-form">
                                                <div class="form-group">
                                                    <label for="data_fatura"></label>
                                                    <input value="" type="date" style="width: 20%;" name="data_fatura" id="data_fatura" class="form-control form-control-sm">
                                                    <label for="vcusto_fatura"></label>
                                                    <input type="tel" oninput="tel(this)" id="vcusto_fatura" name="vcusto_fatura" class="form-control form-control-sm" placeholder="Quanto custa este serviço?">
                                                    <label for="lancarFatura"></label>
                                                    <button type="submit" name="lancarFatura" id="lancarFatura" class="btn btn-success">Enviar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <h3 class="kt-portlet__head-title">Contratos gerados</h3>
            ';
            $_SESSION['vtotal_contrato'] = 0;
            $_SESSION['vpag_contrato'] = 0;
            $count = 0;
            $vcusto_contrato = 0;
            $vpag_contrato = 0;
            $_SESSION['vpag_servico'] = 10;
            while($row_contrato = $result_contrato->fetch_assoc()) {
                $count = $count + 1;
                // Criando os objetos DateTime para as datas de contrato e validade
                $data_inicial = new DateTime($row_contrato['dt_contrato']);
                $data_final = new DateTime($row_contrato['dt_validade']);
                // Calculando a diferença entre as duas datas
                $intervalo = $data_inicial->diff($data_final);
                // Obtendo os anos e meses da diferença
                $anos = $intervalo->y;
                $meses = $intervalo->m;
                // Exibindo a diferença no formato desejado
                $vigencia = ($anos > 0 ? $anos . ' ano' . ($anos > 1 ? 's' : '') : '') .
                ($anos > 0 && $meses > 0 ? ' e ' : '') .
                ($meses > 0 ? $meses . ' mês' . ($meses > 1 ? 'es' : '') : '');
                $status_contrato = $row_contrato['status_contrato'];
                switch ($status_contrato) {
                    case 'A':
                        $ds_status_contrato = "Aberto";
                        break;
                    case 'F':
                        $ds_status_contrato = "Fechado";
                        break;
                    case 'C':
                        $ds_status_contrato = "Cancelado";
                        break;
                    default:
                        $ds_status_contrato = "Desconhecido";
                        break;
                }
                $partial_empresa = $partial_empresa.'
                                    <form method="POST">
                                        <div class="horizontal-wrapper">
                                            <div class="horizontal-id">#'.$count.'/'.$row_contrato['cd_contrato'].' </div>
                                                <input value="'.$row_contrato['cd_contrato'].'" name="listaid_contrato" id="listaid_contrato" class="form-control form-control-sm" style="display:none;" readonly>
                                                <div class="horizontal-content">
                                                    <div class="form-group-custom full-width">
                                                        <label for="listatitulo_contrato">Descrição</label>
                                                        <input value="'.$row_contrato['ds_contrato'].'" name="listatitulo_contrato" id="listatitulo_contrato" type="text" class="form-control form-control-sm" readonly>
                                                    </div>
                                                    <div class="horizontal-form-custom">
                                                        <div class="form-group-custom">
                                                            <label for="listavigencia_contrato">Vigência (' . $vigencia . ')</label>
                                                            <input value="'.date('d/m/Y', strtotime($row_contrato['dt_contrato'])).' a '.date('d/m/Y', strtotime($row_contrato['dt_validade'])).'" name="listavigencia_contrato" id="listavigencia_contrato" type="tel" class="form-control form-control-sm" readonly>
                                                        </div>
                                                        <div class="form-group-custom">
                                                            <label for="listavalor_licenca">Valor da Licença</label>
                                                            <input value="'.$row_contrato['vl_licenca'].'" name="listavalor_licenca" id="listavalor_licenca" type="tel" class="form-control form-control-sm" readonly>
                                                        </div>                       
                                                        <div class="form-group-custom">
                                                            <label for="listavalor_contrato">Valor do contrato</label>
                                                            <input value="'.$row_contrato['vl_contrato'].'" name="listavalor_contrato" id="listavalor_contrato" type="tel" class="form-control form-control-sm" readonly>
                                                        </div>
                                                        <div class="form-group-custom">
                                                            <label for="listastatus_contrato">Status</label>
                                                            <input value="'.$ds_status_contrato.'" name="listastatus_contrato" id="listastatus_contrato" type="text" class="form-control form-control-sm" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            <input class="horizontal-action" type="submit" value="Editar">
                                        </div>
                                    </form>
                ';          
                $vcusto_contrato = $vcusto_contrato + $row_contrato['vcusto_contrato'];
                $vpag_contrato += $row_contrato['vpag_contrato'];
                $_SESSION['vcusto_contrato'] = $vcusto_contrato;
                $_SESSION['vtotal_contrato'] = $vcusto_contrato;
                $_SESSION['vpag_servico'] = $vpag_contrato;
                
            }
            $select_pagamentos = "SELECT * FROM tb_movimento_financeiro WHERE cd_cliente_comercial = '".$_SESSION['cd_cliente_comercial']."'";
            if(!$result_pagamentos = mysqli_query($conn, $select_pagamentos)){
                echo "<script>window.alert('Erro ao consultar o movimento financeiro na tb_movimento_financeiro!');</script>"; 
            }
            while($row_pagamentos = $result_pagamentos->fetch_assoc()) {
                $_SESSION['vpag_servico'] = $_SESSION['vpag_servico'] + $row_pagamentos['valor_movimento'];
            }
            $_SESSION['falta_pagar_servico'] = 0;
            $select_contrato = "SELECT * FROM tb_contrato WHERE cd_empresa = '".$_SESSION['cd_cliente_comercial']."'";
            if(!$result_contrato = mysqli_query($conn, $select_contrato)){
                echo "<script>window.alert('Erro ao consultar uma fatura na tb_movimento_financeiro!');</script>"; 
            }
            while($row_contrato = $result_contrato->fetch_assoc()) {
                $_SESSION['falta_pagar_servico'] = $_SESSION['vpag_servico'] + $row_contrato['vcusto_contrato'];
            }
            $partial_empresa = $partial_empresa.'
                                    <div class="typeahead" style="background-color: #C6C6C6;">
                                        <div class="horizontal-form">
                                            <div class="form-group">
                                                <label for="cadobs_servico">Total:</label>
                                                <input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_contrato" id="btnvpag_contrato" class="aspNetDisabled form-control form-control-sm" readonly>
                                                <label for="cadobs_servico">Falta:</label>
                                                <input value="'.$_SESSION['fatura_devida_cliente_fiscal'].'" type="tel" name="btn_falta_pagar_contrato" id="btn_falta_pagar_contrato" class="aspNetDisabled form-control form-control-sm" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            if($vcusto_contrato == 0){
            }else{
            }          
        
        
            
                if($permite_editar){
                    $partial_empresa = $partial_empresa.'
                        <script>
                            function enviarPara(url) {
                                document.getElementById("form_empresa").action = url;
                            }
                            //document.getElementById("prioridade_servico").disabled = true;
                            document.getElementById("cadrsocial_cliente_comercial").readOnly = true;
                            document.getElementById("cadnfantasia_cliente_comercial").readOnly = true;
                            document.getElementById("cadcnpj_cliente_comercial").readOnly = true;
                            document.getElementById("cadtel_cliente_comercial").readOnly = true;
                            document.getElementById("cademail_cliente_comercial").readOnly = true;
                            document.getElementById("cadsaudacao_cliente_comercial").readOnly = true;
                            document.getElementById("cadtipo_mensagem_cliente_comercial").readOnly = true;
                            document.getElementById("cadtipo_impressao_cliente_comercial").readOnly = true;
                            document.getElementById("cad_cliente_comercial").style.display = "none";
                        </script>
                    ';

                    if($row_empresa['orcamento_empresa'] == $row_empresa['vpag_empresa']){
                        $partial_venda = $partial_empresa.'
                            <div class="form-group-custom">
                                <label for="fechamento_venda">Fechamento</label>
                                <td><button type="submit" name="fecharVenda" id="fecharVenda" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Fechar Venda</button></td>
                            </div>
                        ';    
                    }else{
                        $partial_empresa = $partial_empresa.'
                            <div class="form-group-custom">
                                <td><h5>Falta Pagar (R$: '.number_format($row_empresa['orcamento_venda'] - $row_empresa['vpag_venda'], 2, '.', '.').')</h5></button></td>
                            </div>
                        ';
                    }
                    $partial_venda = $partial_venda.'
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    ';
                }else{
                    $partial_empresa = $partial_empresa . '
                    <td><button type="submit" name="con_edit_empresa" id="con_edit_empresa" class="btn btn-block btn-outline-warning" onclick="enviarPara(\'cadastrar_cliente_comercial.php\')"><i class="icon-cog"></i>Editar</button></td>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    <script>
                        function enviarPara(url) {
                            document.getElementById("form_empresa").action = url;
                        }
                        document.getElementById("prioridade_servico").disabled = true;
                        //document.getElementById("obs_servico").readOnly = true;
                        //document.getElementById("prioridade_servico").readOnly = true;
                        //document.getElementById("prazo_servico").readOnly = true;
                    </script>
                ';
                }
                $conn->commit();
                return [
                    'status'                =>  'OK',
                    'cd_empresa'            =>  $row_empresa['cd_empresa'],    
                    'cd_proprietario'       =>  $row_empresa['cd_proprietario'],    
                    'abertura_empresa'      =>  $row_empresa['abertura_venda'],        
                    'status_empresa'        =>  $row_empresa['status_servico'],
                    'partial_empresa'       =>  $partial_empresa
                ];
        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'            => addslashes($e->getMessage()),
                'cd_empresa'      => '0'
            ];
        }

    }

    public function editVenda($cd_venda, $cd_filial, $titulo_venda, $fechamento_venda, $orcamento_venda, $vpag_venda, $status_venda) 
    {
        global $conn;
        $u = new Usuario();
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            $update_venda = "UPDATE tb_venda SET
                        titulo_venda = '".$titulo_venda."',
                        fechamento_venda = '".$fechamento_venda."',
                        orcamento_venda = '".$orcamento_venda."',
                        vpag_venda = '".$vpag_venda."',
                        status_venda = '".$status_venda."'
                        WHERE cd_venda = '".$cd_venda."'";
            mysqli_query($conn, $update_venda);
            
            // Recupera o serviço inserido
            $result_venda = $u->conVenda('CV', $cd_venda, $cd_filial, false);
            
            if ($result_venda['status'] != 'OK') {
                return [
                    'status'        =>  'conVenda: '.$result_venda['status'],
                    'cd_venda'      =>  '0'
                ];
            }
            
            // Commit na transação
            $conn->commit();

            return [
                'status'                =>  'OK',
                'cd_venda'              =>  $result_venda['cd_venda'],
                'cd_filial'             =>  $result_venda['cd_filial'],
                'cd_cliente'            =>  $result_venda['cd_cliente'],
                'id_venda'              =>  $result_venda['id_venda'],
                'abertura_venda'        =>  $result_venda['abertura_venda'],
                'fechamento_venda'      =>  $result_venda['fechamento_venda'],
                'orcamento_venda'       =>  $result_venda['orcamento_venda'],
                'vpag_venda'            =>  $result_venda['vpag_venda'],
                'status_venda'          =>  $result_venda['status_venda']
            ];


                
                
            } catch (Exception $e) {
                $conn->rollback();
                return [
                    'status'        => addslashes($e->getMessage()),
                    'cd_venda'  => '0'
                ];
            }

            


            
            

    }

    public function fecharVenda($cd_venda, $cd_filial) 
    {
        global $conn;
        $u = new Usuario();
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            $update_venda = "UPDATE tb_venda SET
                        fechamento_venda = now(),
                        status_venda = '1'
                        WHERE cd_venda = '".$cd_venda."'";
            mysqli_query($conn, $update_venda);
            
            // Recupera o serviço inserido
            $result_venda = $u->conVenda('CV', $cd_venda, $cd_filial, false);
            
            if ($result_venda['status'] != 'OK') {
                return [
                    'status'        =>  'conVenda: '.$result_venda['status'],
                    'cd_venda'      =>  '0'
                ];
            }
            
            // Commit na transação
            $conn->commit();

            return [
                'status'                =>  'OK',
                'cd_venda'              =>  $result_venda['cd_venda'],
                'cd_filial'             =>  $result_venda['cd_filial'],
                'cd_cliente'            =>  $result_venda['cd_cliente'],
                'id_venda'              =>  $result_venda['id_venda'],
                'abertura_venda'        =>  $result_venda['abertura_venda'],
                'fechamento_venda'      =>  $result_venda['fechamento_venda'],
                'orcamento_venda'       =>  $result_venda['orcamento_venda'],
                'vpag_venda'            =>  $result_venda['vpag_venda'],
                'status_venda'          =>  $result_venda['status_venda']
            ];


                
                
            } catch (Exception $e) {
                $conn->rollback();
                return [
                    'status'        => addslashes($e->getMessage()),
                    'cd_venda'  => '0'
                ];
            }

            


            
            

    }
    

    public function listOrcamentoServico($cd_servico, $cd_filial, $permite_remover, $permite_lancar) 
    {
        global $conn;
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        $debug_data = [
        'cd_servico' => $cd_servico,
        'cd_filial' => $cd_filial,
        'permite_remover'   =>  $permite_remover,
        'permite_lancar'    =>  $permite_lancar
        ];

        $json_data = json_encode($debug_data);

        $partial_orcamento = "<script>console.log('listOrcamentoServico:', " . $json_data . ");</script>";

        try {

            $select_servico = "
                SELECT * FROM tb_servico WHERE cd_servico = '".$cd_servico."' AND cd_filial = '".$cd_filial."'
            ";

            $select_pagamento = "
                SELECT cd_os_movimento, SUM(valor_movimento) As total_pago FROM tb_movimento_financeiro WHERE cd_os_movimento = '".$cd_servico."' AND cd_filial = '".$cd_filial."'
            ";
            
            $select_orcamento = "
              SELECT tr.*, tos.*
              FROM tb_orcamento_servico tos
              LEFT JOIN tb_reserva tr ON tr.cd_orcamento = tos.cd_orcamento
              WHERE tos.cd_servico = '" . $cd_servico . "' AND tos.cd_filial = '" . $cd_filial . "'
              ORDER BY tos.cd_orcamento ASC
            ";

            $select_prod_serv = "SELECT tps.*, 
               COALESCE(SUM(tr.qtd_reservado), 0) AS total_reservado
             FROM tb_prod_serv tps
               LEFT JOIN tb_reserva tr ON tps.cd_prod_serv = tr.cd_prod_serv
                 AND tr.qtd_efetivado IS NULL
             WHERE (tps.estoque_prod_serv > 0 OR tps.estoque_prod_serv is null) 
               AND tps.status_prod_serv = '1'
               AND tps.cd_empresa = ".$_SESSION['cd_empresa']."
             GROUP BY tps.cd_prod_serv
             ORDER BY tps.cd_prod_serv;";

            
            $result_servico = mysqli_query($conn, $select_servico);
            $row_servico = mysqli_fetch_assoc($result_servico);
            
            $result_pagamento = mysqli_query($conn, $select_pagamento);
            $row_pagamento = mysqli_fetch_assoc($result_pagamento);
            
            $result_orcamento = mysqli_query($conn, $select_orcamento);

            $result_prod_serv = mysqli_query($conn,$select_prod_serv);
            
            $count = 0;
            $vtotal_orcamento = 0;

            /*
            $lista = $result_orcamento['list_orcamento'];
            foreach ($lista as $item) {
              echo $item['descricao'] . " - R$ " . $item['valor'] . "<br>";
            }
            */

            $partial_orcamento  =   $partial_orcamento."
                <script>
                    function showSection(sectionId, buttonId) {
                       // Esconde todas as seções
                        document.getElementById('ProdutosServicos').style.display = 'none';
                        document.getElementById('ProdutosServicosCadastro').style.display = 'none';

                        // Remove classes de ambos os botões
                        document.getElementById('ProdutosServicosBtn').style.display = 'block';
                        document.getElementById('ProdutosServicosCadastroBtn').style.display = 'block';

                        // Mostra a seção selecionada
                        document.getElementById(sectionId).style.display = 'block';

                        // Adiciona a classe ao botão correspondente
                        document.getElementById(buttonId).style.display = 'none';
                    }
                </script>
            ";
            
//INICIO DO FRAGMENTO
            if($permite_lancar){
                $partial_orcamento  =   $partial_orcamento.'
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <h3 class="kt-portlet__head-title">Composição do Orcamento</h3>
                            <form method="post">
                                <!--<div class="typeahead">-->
                ';
            
                if($_SESSION['md_venda'] != '111'){
                    $partial_orcamento  =   $partial_orcamento.'
                                    <button type="button" id="ProdutosServicosBtn" onclick="showSection(\'ProdutosServicos\', \'ProdutosServicosBtn\')" class="btn btn-outline-success" style="text-align:left; display:none;">Mudar para: Serviço Avulso</button>
                                    <button type="button" id="ProdutosServicosCadastroBtn" onclick="showSection(\'ProdutosServicosCadastro\', \'ProdutosServicosCadastroBtn\')" class="btn btn-outline-success" style="text-align:left;">Mudar para: Produtos/Serviços</button>
                    ';
                }
                $partial_orcamento  =   $partial_orcamento.'
                                    
                                    <div id="ProdutosServicos" class="typeahead" style="background-color: #C6C6C6; display: block;">
                                        <h3 class="kt-portlet__head-title">Serviço avulso</h3>
                                        <div class="horizontal-form">
                                            <div class="form-group">
                                                <label for="titulo_orcamento"></label>
                                                <input type="hidden" name="cd_cliente" id="cd_cliente" value="'.$row_servico['cd_cliente'].'">
                                                <input type="hidden" name="cd_servico" id="cd_servico" value="'.$row_servico['cd_servico'].'">
                                                <input type="text" name="titulo_orcamento" id="titulo_orcamento" class=" form-control form-control-sm" placeholder="Título do serviço">
                                                <label for="vcusto_orcamento"></label>
                                                <input type="tel" id="vcusto_orcamento" name="vcusto_orcamento" class=" form-control form-control-sm" placeholder="Quanto custa este serviço?">
                                                <label for="lancarOrcamento"></label>
                                                <button type="submit" name="lancarOrcamento" id="lancarOrcamento" class="btn btn-success">Enviar</button>
                                            </div>
                                        </div>
                                    </div>                                 
                '; 
               
                if($_SESSION['md_venda'] != '111'){
			    
                    if ($result_prod_serv->num_rows > 0){
                        $partial_orcamento  =   $partial_orcamento.'
                                    <div id="ProdutosServicosCadastro" class="typeahead" style="background-color: #C6C6C6; display: none;">
                                        <h3 class="kt-portlet__head-title">Produtos/Serviços</h3>
                                        <div class="horizontal-form">
                                            <div class="form-group"> 
                	                	        <div class="col-lg-12 col-sm-12">
                                                    <div class="input-group">
                                                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span id="produto_servico_id1" name="produto_servico_id1" class="input-group-text btn-outline-info">**</span>
                                                                <input type="tel" id="produto_servico_id2" name="produto_servico_id2" class="form-control form-control-sm" style="display:none" readonly>
                                                                <input type="text" id="produto_servico_nome" name="produto_servico_nome" class="form-control form-control-sm" style="display:none" readonly>
                                                                <select name="produto_servico" id="produto_servico" class="form-control" onchange="updatePriceAndCode()">
                                                                    <option value=""></option>
                        ';
                        while ($row_prod_serv = $result_prod_serv->fetch_assoc()) {
                            $partial_orcamento  =   $partial_orcamento.'
                                                                    <option value="' . $row_prod_serv['cd_prod_serv'] . '" data-preco="' . $row_prod_serv['preco_prod_serv'] . '" data-estoque="' . $row_prod_serv['estoque_prod_serv'] . '" data-reserva="' . $row_prod_serv['total_reservado'] . '">' . $row_prod_serv['titulo_prod_serv'] . '</option>
                            ';
                        }
                        $partial_orcamento  =   $partial_orcamento.'
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text btn-outline-info">Valor</span>
                                                                <input type="tel" id="produto_servico_preco" name="produto_servico_preco" class="form-control form-control-sm" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text btn-outline-info">QTD</span>
                                                                <input type="hidden" id="produto_servico_estoque" name="produto_servico_estoque" class="form-control form-control-sm" style="display:block;" readonly>
                                                                <input type="hidden" id="produto_servico_reserva" name="produto_servico_reserva" class="form-control form-control-sm" style="display:block" readonly>         
                                                                <input type="tel" id="produto_servico_qtd" name="produto_servico_qtd" value="1" class="form-control form-control-sm" oninput="tel(this), calculateTotal()">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text btn-outline-info">Total</span>
                                                                <input type="tel" id="produto_servico_vtotal" name="produto_servico_vtotal" value="0" class="form-control form-control-sm" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label for="lancarOrcamentoCadastro"></label>
                                                <button type="submit" name="lancarOrcamentoCadastro" id="lancarOrcamentoCadastro" class="btn btn-success">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                        ';
                    }else{
                        $partial_orcamento  =   $partial_orcamento.'
                                    <div id="ProdutosServicosCadastro" class="typeahead" style="background-color: #C6C6C6; display: none;">
                                        <h3 class="kt-portlet__head-title">Produtos/Serviços</h3>
                                        <div class="horizontal-form">
                                            <div class="form-group"> 
                                                <div class="col-lg-12 col-sm-12">
                                                    <div class="input-group">
                                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                            <div class="input-group-prepend">
                                                                <a href="'.$_SESSION['dominio'].'pages/cad_geral/cadastro_produto.php" class="btn btn-lg btn-block btn-success">Ops, alimente seu estoque para proseguir - Clique Aqui</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        ';
                    }
                }

            $partial_orcamento  =   $partial_orcamento.'
                                <!--</div>-->
                            </form>
                        </div>
                    </div>
                </div>
            ';
        }
//FIM DO FRAGMENTO         



            /*$partial_orcamento  =   $partial_orcamento.' 
                <div name="listaOrcamento" id="listaOrcamento" class="typeahead">
                    <div class="horizontal-form">                
            ';*/



            while ($row_orcamento = $result_orcamento->fetch_assoc()) {
                $count ++;
                $vtotal_orcamento = $vtotal_orcamento + $row_orcamento['vcusto_orcamento'];
                if($row_orcamento['tipo_orcamento'] == 'AVULSO'){

                    $partial_orcamento  =   $partial_orcamento.'<form method="POST">';


                    $partial_orcamento = $partial_orcamento.'
                            <div class="horizontal-wrapper">
                                <div class="horizontal-id">#'.$count.'/'.$row_orcamento['cd_orcamento'].' </div>
                                <input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="form-control form-control-sm" style="display:none;" readonly>
                                <div class="horizontal-content">
                                    <div class="form-group-custom full-width">
                                        <label for="listatitulo_orcamento">Descrição</label>
                                        <input value="'.$row_orcamento['cd_servico'].'" name="listaid_servico" id="listaid_servico" class=" form-control form-control-sm" style="display:none;">
                                        <input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class=" form-control form-control-sm" style="display:none;">
                                        <input value="'.$row_orcamento['tipo_orcamento'].'" name="listatipo_orcamento" id="listatipo_orcamento" type="text" class=" form-control form-control-sm" style="display:none">
                                        <input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="horizontal-form-custom">
                                        <div class="form-group-custom">
                                            <label for="listavalor_orcamento">Valor</label>
                                            <input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                </div>
                                


                    ';

                    if($permite_remover == true){
                        $partial_orcamento  =   $partial_orcamento.'
                                <input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="horizontal-action btn btn-danger">
                            </div>
                        ';
                    }else{
                        $partial_orcamento  =   $partial_orcamento."
                            </div>
                        ";
                    }

                    $partial_orcamento  =   $partial_orcamento.'</form>';
                }else if($row_orcamento['tipo_orcamento'] == 'CADASTRO'){
                    $partial_orcamento  =   $partial_orcamento.'<form method="POST">';
                    $partial_orcamento = $partial_orcamento.'
                        <div class="horizontal-wrapper">
                            <div class="horizontal-id">#'.$count.'/'.$row_orcamento['cd_orcamento'].' </div>
                            <input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="form-control form-control-sm" style="display:none;" readonly>
                            <div class="horizontal-content">
                                <div class="form-group-custom full-width">
                                <label for="listatitulo_orcamento">Descrição</label>
                                    <input type="hidden" value="'.$row_orcamento['cd_servico'].'" name="listaid_servico" id="listaid_servico" class=" form-control form-control-sm">
                                    <input type="hidden" value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class=" form-control form-control-sm">
                                    <input type="hidden" value="'.$row_orcamento['tipo_orcamento'].'" name="listatipo_orcamento" id="listatipo_orcamento" type="text" class=" form-control form-control-sm">
                                    <input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="horizontal-form-custom">
                                    <div class="form-group-custom">
                                        <label for="vcusto_orcamento">Valor do Produto/Servico</label>
                                        <input value="'.$row_orcamento['vcusto_orcamento'].'" name="vcusto_orcamento" id="vcusto_orcamento" type="tel" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                            </div>
                            
                    ';
                    if($permite_remover == true){
                        $partial_orcamento  =   $partial_orcamento.'
                            <input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="horizontal-action btn btn-danger">
                        </div>
                        ';  
                    }else{
                        $partial_orcamento  =   $partial_orcamento."
                        </div>
                        ";
                    }
                    $partial_orcamento  =   $partial_orcamento.'</form>';

                }      
            }
/*
            $partial_orcamento  =   $partial_orcamento.'
                    </div>
                </div> 
            ';*/

            $falta_pagar = $vtotal_orcamento - $row_pagamento['total_pago'];
            $falta_pagar = number_format($falta_pagar, 2, '.', '.'); // formato brasileiro


            $partial_orcamento = $partial_orcamento.'
                <div  class="typeahead" style="background-color: #C6C6C6; display:block;">
                    <div class="horizontal-form">
                        <div class="form-group">
                            <label for="showobs_servico">Total:</label>
                            <input value="'.$vtotal_orcamento.'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class=" form-control form-control-sm" readonly>
                            <label for="showobs_servico">Pago:</label>
                            <input value="'.$row_pagamento['total_pago'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class=" form-control form-control-sm" readonly>
                            <label for="showobs_servico">Falta:</label>
                            <input value="'.$falta_pagar.'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class=" form-control form-control-sm" readonly>                     
                        </div>
                    </div>
                </div>
            ';


            



            return [
                'status'            =>  'OK',
                'cd_servico'        =>  $cd_servico,
                'vtotal_orcamento'  =>  $vtotal_orcamento,
                'falta_pagar'       =>  $falta_pagar,
                'partial_orcamento' =>  $partial_orcamento
            ];



               
        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_servico'    => '0'
            ];
        }

    }

    public function listOrcamentoVenda($cd_venda, $cd_filial, $permite_remover, $permite_lancar) 
    {
        global $conn;
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        $debug_data = [
        'cd_venda' => $cd_venda,
        'cd_filial' => $cd_filial,
        'permite_remover' => $permite_remover,
        'permite_lancar' => $permite_lancar
        ];

        $json_data = json_encode($debug_data);

        $partial_orcamento = "<script>console.log('listOrcamentoVenda:', " . $json_data . ");</script>";

        try {

            $select_venda = "
                SELECT * FROM tb_venda WHERE cd_venda = '".$cd_venda."' AND cd_filial = '".$cd_filial."'
            ";

            $select_pagamento = "
                SELECT cd_venda_movimento, SUM(valor_movimento) As total_pago FROM tb_movimento_financeiro WHERE cd_venda_movimento = '".$cd_venda."' AND cd_filial = '".$cd_filial."'
            ";
            
            $select_orcamento = "
              SELECT tr.*, tov.*
              FROM tb_orcamento_venda tov
              LEFT JOIN tb_reserva tr ON tr.cd_orcamento = tov.cd_orcamento
              WHERE tov.cd_venda = '" . $cd_venda . "' AND tov.cd_filial = '" . $cd_filial . "'
              ORDER BY tov.cd_orcamento DESC
            ";

            $select_prod_serv = "SELECT tps.*, 
               COALESCE(SUM(tr.qtd_reservado), 0) AS total_reservado
             FROM tb_prod_serv tps
               LEFT JOIN tb_reserva tr ON tps.cd_prod_serv = tr.cd_prod_serv
                 AND tr.qtd_efetivado IS NULL
             WHERE tps.estoque_prod_serv > 0 
               AND tps.status_prod_serv = '1'
               AND tps.cd_empresa = ".$_SESSION['cd_empresa']."
             GROUP BY tps.cd_prod_serv
             ORDER BY tps.cd_prod_serv;";

            
            $result_venda = mysqli_query($conn, $select_venda);
            $row_venda = mysqli_fetch_assoc($result_venda);
            
            $result_pagamento = mysqli_query($conn, $select_pagamento);
            $row_pagamento = mysqli_fetch_assoc($result_pagamento);
            
            $result_orcamento = mysqli_query($conn, $select_orcamento);

            $result_prod_serv = mysqli_query($conn,$select_prod_serv);
            
            $count = 0;
            $vtotal_orcamento = 0;

            /*
            $lista = $result_orcamento['list_orcamento'];
            foreach ($lista as $item) {
              echo $item['descricao'] . " - R$ " . $item['valor'] . "<br>";
            }
            */

            
//INICIO DO FRAGMENTO
            $partial_orcamento  =   $partial_orcamento.'
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <!--<h5 class="kt-portlet__head-title">Orcamento da Venda</h5>-->
                            <form method="post">
                                <!--<div class="typeahead">-->
            ';
            
            $partial_orcamento  =   $partial_orcamento."
                                    

                                    <script>

    function updatePriceAndCode() {
    const select = document.getElementById('produto_venda');
    const selectedOption = select.options[select.selectedIndex];

    // Atualizar o preço
    const preco = selectedOption.getAttribute('data-preco') || 0;
    document.getElementById('produto_venda_preco').value = parseFloat(preco).toFixed(2);

    // Atualizar o ID do produto
    const cdProduto = selectedOption.value || '**';
    document.getElementById('produto_venda_id1').textContent = cdProduto;
    document.getElementById('produto_venda_id2').value = cdProduto;

    const tituloProdServ = selectedOption.text || '';
    document.getElementById('produto_venda_nome').value = tituloProdServ;

    const estoque = selectedOption.getAttribute('data-estoque') || 0;
    document.getElementById('produto_venda_estoque').value = estoque;

    const reserva = selectedOption.getAttribute('data-reserva') || 0;
    document.getElementById('produto_venda_reserva').value = reserva;


    // Recalcular o total
    calculateTotal();
}


    function calculateTotal() {
      const preco = parseFloat(document.getElementById('produto_venda_preco').value) || 0;
      const quantidade = parseFloat(document.getElementById('produto_venda_qtd').value) || 0;
      const estoque = parseFloat(document.getElementById('produto_venda_estoque').value) || 0;
      const reserva = parseFloat(document.getElementById('produto_venda_reserva').value) || 0;


      const total = preco * quantidade;

      // Validar se a quantidade excede o estoque
    if (quantidade > estoque) {
        // Adicionar borda vermelha
        document.getElementById('produto_venda_qtd').style.border = '2px solid red';
        //alert('O estque livre é '+estoque);
    } else if(quantidade > (estoque - reserva)){
      document.getElementById('produto_venda_qtd').style.border = '2px solid orange';
    }else{
        // Restaurar borda normal
        document.getElementById('produto_venda_qtd').style.border = '';
    }


      document.getElementById('produto_venda_vtotal').value = total.toFixed(2);
    }
</script>                              
            "; 
               
			if ($result_prod_serv->num_rows > 0){
                if($permite_lancar){
                    $partial_orcamento  =   $partial_orcamento.'
                                    <div id="ProdutosServicosCadastro" class="typeahead" style="background-color: #C6C6C6; display: block;">
                                        <h3 class="kt-portlet__head-title">Produtos/Serviços</h3>
                                        <div class="horizontal-form">
                                            <div class="form-group"> 
                	                	        <div class="col-lg-12 col-sm-12">
                                                    <div class="input-group">
                                                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span id="produto_venda_id1" name="produto_venda_id1" class="input-group-text btn-outline-info">**</span>
                                                                <input type="text" id="produto_venda_id2" name="produto_venda_id2" class="form-control form-control-sm" style="display:none" readonly>
                                                                <input type="text" id="produto_venda_nome" name="produto_venda_nome" class="form-control form-control-sm" style="display:none" readonly>
                                                                <select name="produto_venda" id="produto_venda" class="form-control" onchange="updatePriceAndCode()">
                                                                    <option value=""></option>
                    ';
                    while ($row_prod_serv = $result_prod_serv->fetch_assoc()) {
                        $partial_orcamento  =   $partial_orcamento.'
                                                                    <option value="' . $row_prod_serv['cd_prod_serv'] . '" data-preco="' . $row_prod_serv['preco_prod_serv'] . '" data-estoque="' . $row_prod_serv['estoque_prod_serv'] . '" data-reserva="' . $row_prod_serv['total_reservado'] . '">' . $row_prod_serv['titulo_prod_serv'] . '</option>
                        ';
                    }
                    $partial_orcamento  =   $partial_orcamento.'
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text btn-outline-info">Valor</span>
                                                                <input type="tel" id="produto_venda_preco" name="produto_venda_preco" class="form-control form-control-sm" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text btn-outline-info">QTD</span>
                                                                <input type="hidden" id="produto_venda_estoque" name="produto_venda_estoque" class="form-control form-control-sm" style="display:block;" readonly>
                                                                <input type="hidden" id="produto_venda_reserva" name="produto_venda_reserva" class="form-control form-control-sm" style="display:block" readonly>         
                                                                <input type="tel" id="produto_venda_qtd" name="produto_venda_qtd" value="1" class="form-control form-control-sm" oninput="tel(this), calculateTotal()">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-md-3 col-lg-3 col-xl-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text btn-outline-info">Total</span>
                                                                <input type="tel" id="produto_venda_vtotal" name="produto_venda_vtotal" value="0" class="form-control form-control-sm" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label for="lancarOrcamentoCadastro"></label>
                                                <button type="submit" name="lancarOrcamentoCadastro" id="lancarOrcamentoCadastro" class="btn btn-success">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                    ';
                }                          
			}else{
                $partial_orcamento  =   $partial_orcamento.'
                                    <div id="ProdutosServicosCadastro" class="typeahead" style="background-color: #C6C6C6;">
                                        <h3 class="kt-portlet__head-title">Produtos/Serviços</h3>
                                        <div class="horizontal-form">
                                            <div class="form-group"> 
                                                <div class="col-lg-12 col-sm-12">
                                                    <div class="input-group">
                                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                            <div class="input-group-prepend">
                                                                <a href="'.$_SESSION['dominio'].'pages/cad_geral/cadastro_produto.php" class="btn btn-lg btn-block btn-success">Ops, alimente seu estoque para proseguir - Clique Aqui</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                ';
            }
            $partial_orcamento  =   $partial_orcamento.'
                                <!--</div>-->
                            </form>
                        </div>
                    </div>
                </div>
            ';
//FIM DO FRAGMENTO         



            /*$partial_orcamento  =   $partial_orcamento.' 
                <div name="listaOrcamento" id="listaOrcamento" class="typeahead">
                    <div class="horizontal-form">                
            ';*/



            while ($row_orcamento = $result_orcamento->fetch_assoc()) {
                $count ++;
                $vtotal_orcamento = $vtotal_orcamento + $row_orcamento['vtotal_orcamento'];



                
                    $partial_orcamento = $partial_orcamento.'

<form method="POST">
                        <div class="horizontal-wrapper">
                            <div class="horizontal-id">#'.$count.'/'.$row_orcamento['cd_orcamento'].' </div>
                            <input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="form-control form-control-sm" style="display:none;" readonly>
                            <div class="horizontal-content">
                                <div class="form-group-custom full-width">
                                <label for="listatitulo_orcamento">Descrição</label>
                                    <input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class=" form-control form-control-sm" style="display:none;">
                                    <input value="'.$row_orcamento['tipo_orcamento'].'" name="listatipo_orcamento" id="listatipo_orcamento" type="text" class=" form-control form-control-sm" style="display:none">
                                    <input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="horizontal-form-custom">
                                    <div class="form-group-custom">
                                        <label for="listavalor_total">Valor total</label>
                                        <input value="'.$row_orcamento['vtotal_orcamento'].'" name="listavalor_orcamento" id="listavalor_total" type="tel" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                            </div>';

                            if($permite_remover == true){
                                $partial_orcamento  =   $partial_orcamento.'
                                    <input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="horizontal-action btn btn-danger">
                                    </div>
                                    </form>
                                ';  
                            }else{
                                $partial_orcamento  =   $partial_orcamento."
                                    </div>
                                    </form>
                                ";
                            }
                     
                
            

                    
            }
/*
            $partial_orcamento  =   $partial_orcamento.'
                    </div>
                </div> 
            ';*/

            $falta_pagar = $vtotal_orcamento - $row_pagamento['total_pago'];
            $falta_pagar = number_format($falta_pagar, 2, '.', '.'); // formato brasileiro

            
            $partial_orcamento = $partial_orcamento.'
                <div  class="typeahead" style="background-color: #C6C6C6; display:block;">
                    <div class="horizontal-form">
                        <div class="form-group">
                            <label for="showobs_servico">Total:</label>
                            <input value="'.$vtotal_orcamento.'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class=" form-control form-control-sm" readonly>
                            <label for="showobs_servico">Pago:</label>
                            <input value="'.$row_pagamento['total_pago'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class=" form-control form-control-sm" readonly>
                            <label for="showobs_servico">Falta:</label>
                            <input value="'.$falta_pagar.'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class=" form-control form-control-sm" readonly>                     
                        </div>
                    </div>
                </div>
            ';






            return [
                'status'            =>  'OK',
                'cd_venda'          =>  $cd_venda,
                'vtotal_orcamento'  =>  $vtotal_orcamento,
                'falta_pagar'       =>  $falta_pagar,
                'partial_orcamento' =>  $partial_orcamento
            ];



               
        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_venda'    => '0'
            ];
        }

    }

    public function cadOrcamento($tipo, $cd_cliente, $cd_empresa, $cd_servico, $titulo_orcamento, $vcusto_orcamento) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        //$lista_sql = [];
        try {
            if($titulo_orcamento == ''){
                return [
                    'status'        =>  'Descreva o Oeçamento',
                    'cd_orcamento'    =>  '0'
                ];
            }elseif($vcusto_orcamento == '0'){
                return [
                    'status'        =>  'Insira o Valor do Orcamento!',
                    'cd_orcamento'    =>  '0'
                ];
            }else{  

                
                $insert_orcamento = "INSERT INTO tb_orcamento_servico(cd_cliente, cd_filial, cd_servico, titulo_orcamento, vcusto_orcamento, tipo_orcamento, status_orcamento) VALUES(
                  '".$cd_cliente."',
                  '".$cd_empresa."',
                  '".$cd_servico."',
                  '".$titulo_orcamento."',
                  '".str_replace(',', '.', $vcusto_orcamento)."',
                  'AVULSO',
                  0)
                ";

                //mysqli_query($conn, $insert_orcamento);

                $updateServico = "UPDATE tb_servico SET
                  orcamento_servico = orcamento_servico + ".$vcusto_orcamento."
                  WHERE cd_servico = ".$cd_servico."";
                mysqli_query($conn, $updateServico);

                $lista_sql[] = preg_replace('/\s+/', ' ', $insert_orcamento);
                $lista_sql[] = preg_replace('/\s+/', ' ', $updateServico);
                
                if (!mysqli_query($conn, $insert_orcamento)) {
                    return [
                        'SQL'               =>  implode(" ", $lista_sql),
                        'status'            =>  'Erro ao inserir orçamento: ' . mysqli_error($conn)
                    ];
                }

                $conn->commit();

                return [
                    'SQL'               =>  implode(" ", $lista_sql),
                    'status'            =>  'OK'
                ];


            }

        } catch (Exception $e) {
            $conn->rollback();
            return [
                'SQL'           =>  implode(" ", $lista_sql),
                'status'        =>  addslashes($e->getMessage()),
            ];
        }

            


            
            

    }

    public function movimentoFinanceiro($referencia, $cd_filial, $cd_servico, $cd_venda, $valor_max){
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        $dataHoraAtual = date('Y-m-d H:i:s'); // Exemplo: 2025-04-19 14:30:00

        //$lista_sql = [];
        try {
            if($referencia == ''){
                $partial_financeiro = '                
                    <div class="col-12 grid-margin stretch-card btn-warning" '.$_SESSION['c_card'].'>
                    <div class="card" '.$_SESSION['c_card'].'>
                    <div class="card-body">
                    <h1 class="card-title">Abra já seu caixa</h1>
                    <p class="card-title">Para realizar movimento financeiro, o seu caixa deve estar devidamente aberto</p>
                    <form action="../../pages/md_caixa/abertura_caixa.php" method="POST">
                    <button type="submit" class="btn btn-lg btn-block btn-outline-info" style="margin: 5px;"><i class="mdi mdi-file-check"></i>Abra já seu caixa</button>
                    </form>
                    </div>
                    </div>
                    </div>
                ';
                return [
                    'status'                =>  'OK',
                    'partial_financeiro'    =>  $partial_financeiro
                ];
            }elseif($referencia == 'HOJE'){
                //$select_financeiro = "SELECT * FROM tb_movimento_financeiro WHERE cd_os_movimento = '".$cd_servico."' ORDER BY cd_movimento ASC";
                $select_financeiro = "SELECT * FROM tb_movimento_financeiro WHERE cd_filial = '".$cd_filial."' ";
                if($cd_servico != ''){
                    $select_financeiro_servico  = "SELECT * FROM tb_servico WHERE cd_servico = '".$cd_servico."' LIMIT 1";

                    $select_financeiro = $select_financeiro." AND cd_os_movimento = '".$cd_servico."' ORDER BY cd_movimento ASC";

                    $result_financeiro = mysqli_query($conn, $select_financeiro);
                    //$row_atividade = mysqli_fetch_assoc($result_atividade);
                    
                    // Exibe as informações do usuário no formulário
                    
                    $count = 0;
                    $vpag = 0;
                    $partial_financeiro = '
                    <div class="col-12 grid-margin stretch-card btn-success">
                        <div class="card" '.$_SESSION['c_card'].'>
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">Histórico de Pagamento de Serviços</h4>
                    ';


                }
                if($cd_venda != ''){
                    $select_financeiro_venda    = "SELECT * FROM tb_venda WHERE cd_venda = '".$cd_venda."' LIMIT 1";
                    $select_financeiro = $select_financeiro." AND cd_venda_movimento = '".$cd_venda."' ORDER BY cd_movimento ASC";
                    $result_financeiro = mysqli_query($conn, $select_financeiro);
                    
                    $count = 0;
                    $vpag = 0;
                    $partial_financeiro = $partial_financeiro.'
                    <div class="col-12 grid-margin stretch-card btn-success">
                        <div class="card" '.$_SESSION['c_card'].'>
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">Histórico de Pagamento da Venda</h4>
                    ';

                }
                $conferir_movimento = 0;
                while($row_financeiro = $result_financeiro->fetch_assoc()) {
                    $count ++;
                    
                    $partial_financeiro = $partial_financeiro.'
                                <div class="typeahead" style="background-color: #C6C6C6;">
                                    <div class="horizontal-form">
                                        <div class="form-group">
                                            <label for="listadt_movimento">CX'.$row_financeiro['cd_caixa_movimento'].'</label>
                                            <input value="'.date('d/m/y', strtotime($row_financeiro['data_movimento'])).'" name="listadt_movimento" id="listadt_movimento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>
                                            <label for="listavalor_movimento"></label>
                                            <input value="'.$row_financeiro['fpag_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>
                                            <label for="listavalor_movimento"></label>
                                            <input value="R$:'.$row_financeiro['valor_movimento'].'" name="listavalor_movimento" id="listavalor_movimento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>
                                        </div>
                                    </div>
                                </div>
                    ';
                    $conferir_movimento = $conferir_movimento + $row_financeiro['valor_movimento'];
                }

                if($cd_servico != ''){
                    $result_financeiro_servico = mysqli_query($conn, $select_financeiro_servico);
                    $row_financeiro_servico = mysqli_fetch_assoc($result_financeiro_servico);

                    $vpag = $row_financeiro_servico['vpag_servico'];

                    $falta_paga = $row_financeiro_servico['orcamento_servico'] - $vpag;
                    $orcamento = $row_financeiro_servico['orcamento_servico'];
                    
                    
                    //$result_financeiro_servico = mysqli_query($conn, $select_financeiro_servico);
                    //$row_financeiro_servico = mysqli_fetch_assoc($result_financeiro_servico);

                    if($conferir_movimento != $vpag){
                        $partial_financeiro = $partial_financeiro.'
                            <form method="POST">
                                <div class="input-group">
                                    <span class="input-group-text btn-outline-danger">Há uma inconsistencia de (R$:'.$vpag-$conferir_movimento.')</span>
                                    <input type="hidden" id="os_corrigir" name="os_corrigir" value="'.$cd_servico.'">
                                    <input type="hidden" id="venda_corrigir" name="venda_corrigir" value="'.$cd_venda.'">
                                    <input type="hidden" id="valor_correto" name="valor_correto" value="'.$conferir_movimento.'">
                                    <button type="submit" name="corrige_inconsistencia" id="corrige_inconsistencia" class="btn btn-danger"><i class="mdi mdi-file-check"></i>Corrigir</button>
                                </div>
                            </form>
                        ';
                    }


                }

                if($cd_venda != ''){
                    $result_financeiro_venda = mysqli_query($conn, $select_financeiro_venda);
                    $row_financeiro_venda = mysqli_fetch_assoc($result_financeiro_venda);

                    $vpag = $row_financeiro_venda['vpag_venda'];
                    $falta_pagar = $row_financeiro_venda['orcamento_venda'] - $vpag;
                    $orcamento = $row_financeiro_venda['orcamento_venda'];
                    

                    if($conferir_movimento != $vpag){
                        $partial_financeiro = $partial_financeiro.'
                            <form method="POST">
                                <div class="input-group">
                                    <span class="input-group-text btn-outline-danger">Há uma inconsistencia de (R$:'.$vpag-$conferir_movimento.')</span>
                                    <input type="hidden" id="os_corrigir" name="os_corrigir" value="'.$cd_servico.'">
                                    <input type="hidden" id="venda_corrigir" name="venda_corrigir" value="'.$cd_venda.'">
                                    <input type="hidden" id="valor_correto" name="valor_correto" value="'.$conferir_movimento.'">
                                    <button type="submit" name="corrige_inconsistencia" id="corrige_inconsistencia" class="btn btn-danger"><i class="mdi mdi-file-check"></i>Corrigir</button>
                                </div>
                            </form>
                        ';
                    }

                    
                }
                
                if($valor_max  == 0){
                    $partial_financeiro = $partial_financeiro.'
                                <h6 style="color:#000;">total pago: ('.$vpag.') - ('.$orcamento.')</h6>
                    ';
                    if($vpag < $orcamento){
                        $partial_financeiro = $partial_financeiro.'
                            <form method="POST">
                                <div class="input-group">
                                    <span class="input-group-text btn-outline-danger">Há uma inconsistencia de (R$:'.$vpag - $orcamento.')</span>
                                    <input type="hidden" id="os_corrigir" name="os_corrigir" value="'.$cd_servico.'">
                                    <input type="hidden" id="venda_corrigir" name="venda_corrigir" value="'.$cd_venda.'">
                                    <input type="hidden" id="valor_correto" name="valor_correto" value="'.$vpag.'">
                                    <button type="submit" name="corrige_inconsistencia" id="corrige_inconsistencia" class="btn btn-danger"><i class="mdi mdi-file-check"></i>Corrigir</button>
                                </div>
                            </form>
                        ';
                    }
                }else{
                    
                        $partial_financeiro = $partial_financeiro.'
                                <form method="POST" id="tela_pagamento" name="tela_pagamento">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text btn-outline-success">FORMA DE PAGAMENTO:</span>
                                        </div>
                                        <select id="fpag_movimento" name="fpag_movimento" type="tel" class="form-control form-control-lg " required>
                                            <option selected value=""></option>
                    ';
            
            
                    $sql_describe = "DESCRIBE tb_caixa";
                    $result_describe = mysqli_query($conn, $sql_describe);
                    $found_start = false;
                    if ($result_describe) {
                        while ($row_describe = mysqli_fetch_assoc($result_describe)) {
                            if ($row_describe['Field'] == 'diferenca_caixa') {
                                $found_start = true;
                                continue; // Começar a coleta após encontrar a coluna "diferenca_caixa"
                            }
            
                            if ($found_start && $row_describe['Field'] == 'status_caixa') {
                                break; // Parar a coleta após encontrar a coluna "status_caixa"
                            }
            
                            if ($found_start) {
                                $column_name = str_replace('fpag_', '', $row_describe['Field']);
                                //echo $column_name . "<br>";
                                $partial_financeiro = $partial_financeiro.'<option value="'.$column_name.'">'.$column_name.'</option>';
            
                            }
                        }
                    } else {
                        return [
                            'status'                =>  'tb_caixa não encontrada',
                            'partial_financeiro'    =>  $partial_financeiro
                        ];
                    }
            
            
                    $partial_financeiro = $partial_financeiro.'
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text btn-outline-info">R$:</span>
                                        </div>
                                        <input id="vpag_movimento" name="vpag_movimento" type="tel" class="form-control form-control-sm" aria-label="Amount (to the nearest dollar)" required oninput="validateInput(this)">
                                        <span id="mensagem-financeira"></span>
                                    </div>
                                    <script>
                                        function validateInput(inputElement) {
                                            var inputValue = inputElement.value;
                                            var errorMessageElement = document.getElementById("mensagem-financeira");
                                            var borderForm = document.getElementById("vpag_movimento");
                                            if (isNaN(inputValue) || inputValue < 0.1 || inputValue > '.$valor_max.') {
                                                errorMessageElement.style.color = "red";
                                                borderForm.style.border = "2px solid red";
                                                errorMessageElement.textContent = "O valor pago deve ser maior que 1 e menor ou igual a '.$valor_max.'.";
                                                inputElement.setCustomValidity("O valor pago deve ser maior que 1 e menor ou igual a '.$valor_max.'.");
                                            } else {
                                                errorMessageElement.style.color = "green";
                                                borderForm.style.border = "1px solid green";
                                                errorMessageElement.textContent = "OK";
                                                inputElement.setCustomValidity("");
                                            }
                                        }
                                    </script>  
                                    <button type="submit" name="pagar" id="pagar" class="btn btn-lg btn-block btn-outline-success btn-light"><i class="mdi mdi-file-check"></i>Lançar Pagamento</button>
                                </form>
                    '; 
                    
                    


                    

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Processar dados do formulário
                        unset($_POST['pagar_servico']);
                        unset($_POST['fpag_movimento']);
                        unset($_POST['vpag_movimento']);
                        
                        
                        // Redirecionar para evitar reenvio
                        ////header("Location: ".$_SERVER['PHP_SELF']);
                        ////exit();
                    }
                    
                }

                $partial_financeiro = $partial_financeiro.'
                            </div>
                        </div>
                    </div>
                ';
                
                
                





                return [
                    'status'                =>  'OK',
                    'partial_financeiro'    =>  $partial_financeiro
                ];
            }elseif($referencia == 'ONTEM'){
                $partial_financeiro = '<h3>Abra seu caixa de hoje.</h3>';
            }elseif($referencia == 'ANTERIOR'){
                $partial_financeiro = '<h3>Abra seu caixa de hoje.</h3>';
            }else{
                $conn->commit();
                return [
                    'status'               =>  '$referencia espera ("" ou "HOJE" ou "ONTEM" ou "ANTERIOR")',
                    'cd_orcamento'      =>  'OK123'
                ];
            }

        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_servico'  => '0'
            ];
        }



        
        


    }

    public function impressao1($modelo_documento, $tipo_impressao, $cd_empresa, $chave_busca) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            if($modelo_documento == 'TERMICA1'){
                if($tipo_impressao == 'SERVICO'){
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa, false, false);
                    $partial_impressao  = '
                        <form action="termica1.php" method="POST" target="_blank">
                            <div class="card-body" id="formBtn"><!--FORMULÁRIO DOS BOTOES-->
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div id="" class="" style="display:none;">
                                                <h3 class="kt-portlet__head-title">FORM DE IMPRESSÃO</h3> 
                                                <div  class="typeahead" id="botoes" name="botoes">
                                                    <input value="'.$result_cliente['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class=" form-control form-control-sm" style="display: none;"/>
                                                    <label for="btnpnome_cliente">Nome</label>
                                                    <input value="'.$result_cliente['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btnsnome_cliente">sobrenome</label>
                                                    <input value="'.$result_cliente['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btntel_cliente">Telefone</label>
                                                    <input value="'.$result_cliente['tel1_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" >
                                                    <label for="btncd_servico">OS</label>
                                                    <input value="'.$result_servico['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class=" form-control form-control-sm">
                                                    <label for="btnobs_servico">Descrição Geral</label>
                                                    <input value="'.$result_servico['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class=" form-control form-control-sm" placeholder="Caracteristica geral do serviço">
                                                    <label for="btnprioridade_servico">Prioridade</label>
                                                    <select name="btnprioridade_servico" id="btnprioridade_servico"  class=" form-control form-control-sm">
                                                        <option selected="selected" value="'.$result_servico['prioridade_servico'].'" >'.$result_servico['prioridade_servico'].'</option>
                                                    </select>
                                                    <!--<label for="btnprazo_servico">Entrada</label>-->
                                                    <input value="'.$result_servico['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" class=" form-control form-control-sm" />
                                                    <label for="btnprazo_servico">Prazo</label>
                                                    <input value="'.$result_servico['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" style="background-color: #C6C6C6; display:block;">
                                                    <div class="horizontal-form">
                                                        <div class="form-group">
                                                            <label for="showobs_servico">Total</label>
                                                            <input value="'.$result_orcamento['vtotal_orcamento'].'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class=" form-control form-control-sm" readonly>
                                                            <label for="showobs_servico">Pago</label>
                                                            <input value="'.$result_servico['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class=" form-control form-control-sm" placeholder="Valor Pago">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Imprimir OS</button>
                                <button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Impressão)</button>
                                <button type="submit" name="historico_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Histórico <i class="mdi mdi-printer btn-icon-append"></i></button>                                
                            </div>
                        </form>
                        <form method="post">
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;">Novo Serviço</button>
                        </form>
                    ';
                }else if($tipo_impressao == 'VENDA'){
                    $result_venda       = $u->conVenda('CV', $chave_busca, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_venda['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoVenda($result_venda['cd_venda'], $cd_empresa, false, false);
                    $partial_impressao  = '
                        <form action="termica1.php" method="POST" target="_blank">
                            <div class="card-body" id="formBtn"><!--FORMULÁRIO DOS BOTOES-->
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div id="" class="" style="display:none;">
                                                <h3 class="kt-portlet__head-title">FORM DE IMPRESSÃO</h3> 
                                                <div  class="typeahead" id="botoes" name="botoes">
                                                    <input value="'.$result_cliente['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class=" form-control form-control-sm" style="display: none;"/>
                                                    <label for="btnpnome_cliente">Nome</label>
                                                    <input value="'.$result_cliente['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btnsnome_cliente">sobrenome</label>
                                                    <input value="'.$result_cliente['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btntel_cliente">Telefone</label>
                                                    <input value="'.$result_cliente['tel1_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" >
                                                    <label for="btncd_venda">Venda</label>
                                                    <input value="'.$result_venda['cd_venda'].'" type="tel" name="btncd_venda" id="btncd_venda" class=" form-control form-control-sm">
                                                    <label for="btntitulo_venda">Descrição Geral</label>
                                                    <input value="'.$result_venda['titulo_venda'].'" type="text" name="btntitulo_venda" maxlength="999" id="btntitulo_venda"  class=" form-control form-control-sm" placeholder="Caracteristica geral do serviço">
                                                    
                                                    <!--<label for="btnabertura_venda">Abertura</label>-->
                                                    <input value="'.$result_venda['abertura_venda'].'" name="btnabertura_venda" type="datetime-local" id="btnabertura_venda" class=" form-control form-control-sm" />
                                                    <label for="btnfechamento_venda">Fechamento</label>
                                                    <input value="'.$result_venda['fechamento_venda'].'" name="btnfechamento_venda" type="datetime-local" id="btnfechamento_venda" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" style="background-color: #C6C6C6; display:block;">
                                                    <div class="horizontal-form">
                                                        <div class="form-group">
                                                            <label for="showobs_servico">Total</label>
                                                            <input value="'.$result_orcamento['vtotal_orcamento'].'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class=" form-control form-control-sm" readonly>
                                                            <label for="showobs_servico">Pago</label>
                                                            <input value="'.$result_venda['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class=" form-control form-control-sm" placeholder="Valor Pago">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="imprimir_venda" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Imprimir OS</button>
                                <button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Impressão)</button>
                            </div>
                        </form>
                        <form method="post">
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;">Novo Serviço</button>
                        </form>
                    ';
                }else{
                    return [
                        'status'                =>  '($tipo_impressao) espera (SERVICO)',
                        'partial_impressao'     =>  ''
                    ];
                }
                return [
                    'status'                =>  'OK',
                    'partial_impressao'       =>  $partial_impressao
                ];

            }else if($modelo_documento == 'TERMICA2'){
                if($tipo_impressao == 'SERVICO'){
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa, false, false);
                    $partial_impressao  = '
                        <form action="impresso.php" method="POST" target="_blank">
                            <h1>TERMICA2</h1>
                            <div class="card-body" id="formBtn"><!--FORMULÁRIO DOS BOTOES-->
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div id="" class="" style="display:none;">
                                                <h3 class="kt-portlet__head-title">FORM DE IMPRESSÃO</h3> 
                                                <div  class="typeahead" id="botoes" name="botoes">
                                                    <input value="'.$result_cliente['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class=" form-control form-control-sm" style="display: none;"/>
                                                    <label for="btnpnome_cliente">Nome</label>
                                                    <input value="'.$result_cliente['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btnsnome_cliente">sobrenome</label>
                                                    <input value="'.$result_cliente['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btntel_cliente">Telefone</label>
                                                    <input value="'.$result_cliente['tel1_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" >
                                                    <label for="btncd_servico">OS</label>
                                                    <input value="'.$result_servico['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class=" form-control form-control-sm">
                                                    <label for="btnobs_servico">Descrição Geral</label>
                                                    <input value="'.$result_servico['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class=" form-control form-control-sm" placeholder="Caracteristica geral do serviço">
                                                    <label for="btnprioridade_servico">Prioridade</label>
                                                    <select name="btnprioridade_servico" id="btnprioridade_servico"  class=" form-control form-control-sm">
                                                        <option selected="selected" value="'.$result_servico['prioridade_servico'].'" >'.$result_servico['prioridade_servico'].'</option>
                                                    </select>
                                                    <!--<label for="btnprazo_servico">Entrada</label>-->
                                                    <input value="'.$result_servico['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" class=" form-control form-control-sm" />
                                                    <label for="btnprazo_servico">Prazo</label>
                                                    <input value="'.$result_servico['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" style="background-color: #C6C6C6; display:block;">
                                                    <div class="horizontal-form">
                                                        <div class="form-group">
                                                            <label for="showobs_servico">Total</label>
                                                            <input value="'.$result_orcamento['vtotal_orcamento'].'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class=" form-control form-control-sm" readonly>
                                                            <label for="showobs_servico">Pago</label>
                                                            <input value="'.$result_servico['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class=" form-control form-control-sm" placeholder="Valor Pago">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Imprimir OS</button>
                                <button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Impressão)</button>
                            </div>
                        </form>
                        <form method="post">
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;">Novo Serviço</button>
                        </form>
                    ';
                }else{
                    return [
                        'status'                =>  '($tipo_impressao) espera (SERVICO)',
                        'partial_impressao'     =>  ''
                    ];
                }
                return [
                    'status'                =>  'OK',
                    'partial_impressao'       =>  $partial_impressao
                ];
            }else if($modelo_documento == 'A4'){
                if($tipo_impressao == 'SERVICO'){
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa, false, false);
                    $partial_impressao  = '
                        <form action="a4.php" method="POST" target="_blank">
                            <!--<h1>A4</h1>
                            <div class="card-body" id="formBtn">--><!--FORMULÁRIO DOS BOTOES-->
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div id="" class="" style="display:none;">
                                                <h3 class="kt-portlet__head-title">FORM DE IMPRESSÃO</h3> 
                                                <div  class="typeahead" id="botoes" name="botoes">
                                                    <input value="'.$result_cliente['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class=" form-control form-control-sm" style="display: none;"/>
                                                    <label for="btnpnome_cliente">Nome</label>
                                                    <input value="'.$result_cliente['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btnsnome_cliente">sobrenome</label>
                                                    <input value="'.$result_cliente['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btncpf_cnpj">CPF CNPJ</label>
                                                    <input value="'.$result_cliente['cpf_cliente'].'" name="btncpf_cnpj" type="text" id="btncpf_cnpj" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btntel_cliente">Telefone</label>
                                                    <input value="'.$result_cliente['tel1_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" >
                                                    <label for="btncd_servico">OS</label>
                                                    <input value="'.$result_servico['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class=" form-control form-control-sm">
                                                    <label for="btnobs_servico">Descrição Geral</label>
                                                    <input value="'.$result_servico['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class=" form-control form-control-sm" placeholder="Caracteristica geral do serviço">
                                                    <label for="btnprioridade_servico">Prioridade</label>
                                                    <select name="btnprioridade_servico" id="btnprioridade_servico"  class=" form-control form-control-sm">
                                                        <option selected="selected" value="'.$result_servico['prioridade_servico'].'" >'.$result_servico['prioridade_servico'].'</option>
                                                    </select>
                                                    <!--<label for="btnprazo_servico">Entrada</label>-->
                                                    <input value="'.$result_servico['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" class=" form-control form-control-sm" />
                                                    <label for="btnprazo_servico">Prazo</label>
                                                    <input value="'.$result_servico['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" style="background-color: #C6C6C6; display:block;">
                                                    <div class="horizontal-form">
                                                        <div class="form-group">
                                                            <label for="showobs_servico">Total</label>
                                                            <input value="'.$result_orcamento['vtotal_orcamento'].'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class=" form-control form-control-sm" readonly>
                                                            <label for="showobs_servico">Pago</label>
                                                            <input value="'.$result_servico['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class=" form-control form-control-sm" placeholder="Valor Pago">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Imprimir OS</button>
                                <button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Impressão)</button>
                                <button type="submit" name="historico_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Histórico <i class="mdi mdi-printer btn-icon-append"></i></button>                                
                            <!--</div>-->
                        </form>
                        <form method="post">
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;">Novo Serviço</button>
                        </form>
                    ';
                }else if($tipo_impressao == 'VENDA'){
                    $result_venda       = $u->conVenda('CV', $chave_busca, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_venda['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoVenda($result_venda['cd_venda'], $cd_empresa, false, false);
                    $partial_impressao  = '
                        <form action="a4.php" method="POST" target="_blank">
                            <!--<h1>A4</h1>-->
                            <!--<div class="card-body" id="formBtn">--><!--FORMULÁRIO DOS BOTOES-->
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div id="" class="" style="display:none;">
                                                <h3 class="kt-portlet__head-title">FORM DE IMPRESSÃO</h3> 
                                                <div  class="typeahead" id="botoes" name="botoes">
                                                    <input value="'.$result_cliente['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class=" form-control form-control-sm" style="display: none;"/>
                                                    <label for="btnpnome_cliente">Nome</label>
                                                    <input value="'.$result_cliente['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btnsnome_cliente">sobrenome</label>
                                                    <input value="'.$result_cliente['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class=" form-control form-control-sm"/>
                                                    <label for="btntel_cliente">Telefone</label>
                                                    <input value="'.$result_cliente['tel1_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" >
                                                    <label for="btncd_venda">Vendas</label>
                                                    <input value="'.$result_venda['cd_venda'].'" type="tel" name="btncd_venda" id="btncd_venda" class=" form-control form-control-sm">
                                                    <label for="btntitulo_venda">Descrição Geral</label>
                                                    <input value="'.$result_venda['titulo_venda'].'" type="text" name="btntitulo_venda" maxlength="999" id="btntitulo_venda"  class=" form-control form-control-sm" placeholder="Caracteristica geral da Venda">
                                                    <!--<label for="btnabertura_venda">Abertura</label>-->
                                                    <input value="'.$result_venda['abertura_venda'].'" name="btnabertura_venda" type="datetime-local" id="btnabertura_venda" class=" form-control form-control-sm" />
                                                    <label for="btnfechamento_venda">Fechamento</label>
                                                    <input value="'.$result_venda['fechamento_venda'].'" name="btnfechamento_venda" type="datetime-local" id="btnfechamento_venda" class=" form-control form-control-sm"/>
                                                </div>
                                                <div  class="typeahead" style="background-color: #C6C6C6; display:block;">
                                                    <div class="horizontal-form">
                                                        <div class="form-group">
                                                            <label for="showobs_servico">Total</label>
                                                            <input value="'.$result_venda['orcamento_venda'].'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class=" form-control form-control-sm" readonly>
                                                            <label for="showobs_servico">Pago</label>
                                                            <input value="'.$result_venda['vpag_venda'].'" type="tel" name="btnvpag_venda" id="btnvpag_venda" class=" form-control form-control-sm" placeholder="Valor Pago" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="imprimir_venda" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Imprimir Venda</button>
                                <!--<button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Impressão)</button>-->
                            <!--</div>-->
                        </form>
                        <form method="post">
                            <button type="submit" class="btn btn-block btn-lg btn-danger" name="limparVenda" style="margin-top: 20px; margin-bottom: 20px;">Nova Venda</button>
                        </form>
                    ';
                }else{
                    return [
                        'status'                =>  '($tipo_impressao) espera (SERVICO)',
                        'partial_impressao'     =>  ''
                    ];
                }
                return [
                    'status'                =>  'OK',
                    'partial_impressao'       =>  $partial_impressao
                ];
            }else{

                $partial_impressao = '
                    <form action="../cad_geral/unidade_operacional.php" method="POST" target="_blank">
                            <h1>Configure seu modelo de impressão</h1>
                            
                                <button type="submit" name="tabInfoImpressao" id="tabInfoImpressao" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Clique aqui</button>
                            
                        </form>
                ';

                return [
                    'status'                =>  '($modelo_documento) espera (TERMICA1 ou TERMICA2 ou A4)',
                    'partial_impressao'     =>  $partial_impressao
                ];
            }     
        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'                => addslashes($e->getMessage()),
                'partial_impressao'     => 'ERRO'
            ];
        }

    }
    public function mensagem1($modelo_mensagem, $tipo_mensagem, $cd_empresa, $chave_busca) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            if($modelo_mensagem == 'WHATSAPP'){
                if($tipo_mensagem == 'SERVICO'){
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    //$result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa);
                    $partial_mensagem  = '

                        <button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>
                    
                        <script>
                            function enviarMensagemWhatsApp() {
                                // Obter os valores dos campos do formulário
                                var nomeCliente = "'.$result_cliente['pnome_cliente'].'";
                                var telefoneCliente = "'.$result_cliente['tel1_cliente'].'";
                                var numeroOS = "'.$result_servico['cd_servico'].'";
                                var entradaServico = "'.$result_servico['entrada_servico'].'";
                                var observacoesServico = "'.$result_servico['obs_servico'].'";
                                var prioridadeServico = "'.$result_servico['prioridade_servico'].'";
                                var prazoServico = "'.$result_servico['prazo_servico'].'";
                                var vtotalServico = "'.$result_servico['orcamento_servico'].'";
                                var vpagServico = "'.$result_servico['vpag_servico'].'";
                                var anoEntrada = entradaServico.substring(0, 4);
                                var mesEntrada = entradaServico.substring(5, 7);
                                var diaEntrada = entradaServico.substring(8, 10);
                                var horaEntrada = entradaServico.substring(11, 13);
                                var minutoEntrada = entradaServico.substring(14, 16);
                                var anoPrazo = prazoServico.substring(0, 4);
                                var mesPrazo = prazoServico.substring(5, 7);
                                var diaPrazo = prazoServico.substring(8, 10);
                                var horaPrazo = prazoServico.substring(11, 13);
                                var minutoPrazo = prazoServico.substring(14, 16);

                                // Montar a data organizada
                                var entradaOrganizada = diaEntrada + "/" + mesEntrada + "/" + anoEntrada + " às " + horaEntrada + ":" + minutoEntrada;
                                var prazoOrganizado = diaPrazo + "/" + mesPrazo + "/" + anoPrazo + " às " + horaPrazo + ":" + minutoPrazo;
                                if(prioridadeServico == "U"){
                                    prioridadeOrganizada = "Urgente";
                                }
                                if(prioridadeServico == "A"){
                                    prioridadeOrganizada = "Alta";
                                }
                                if(prioridadeServico == "M"){
                                prioridadeOrganizada = "Média";
                                }
                                if(prioridadeServico == "B"){
                                    prioridadeOrganizada = "Baixa";
                                }
                                faltaPagar = vtotalServico - vpagServico;
                                // Construir a mensagem com todos os dados do formulário
                                var mensagem = "*Olá, " + nomeCliente + "!*\n";
                                mensagem += "Somos da *'.$_SESSION['nfantasia_filial'].'* e ficamos no endereço *'.$_SESSION['endereco_filial'].'*.\n\n";
                                mensagem += "Sua ordem de serviço de número *OS" + numeroOS + "*, deu entrada em nossa loja *" + entradaOrganizada + "*.\n";
                                mensagem += "Descrição da atividade: " + observacoesServico + "\n";
                                //mensagem += "Prioridade Requerida: *" + prioridadeOrganizada + "*\n";
                                mensagem += "O prazo previsto para entrega é: *" + prazoOrganizado + "*\n\n";
                    ';
                    $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = ".$result_servico['cd_servico']." ORDER BY cd_orcamento ASC";
                    $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
                    
                    $partial_mensagem =  $partial_mensagem.'mensagem += "*Lista detalhada*\n";';
                    $count = 0;                  
                    while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
                        $count ++;
                        $partial_mensagem =  $partial_mensagem.'mensagem += "*'.$count.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vcusto_orcamento'].' \n";';
                    }
                    $partial_mensagem =  $partial_mensagem.'
                                mensagem += "\n";
                                if (faltaPagar > 0) {
                                    mensagem += "Total: *R$ " + vtotalServico + "*\n";
                                    // mensagem += "Valor pago: *R$ " + vpagServico + "*\n";
                                    mensagem += "Falta pagar: *R$ " + faltaPagar + "*\n\n";
                                } else if (faltaPagar < 0) {
                                    mensagem += "Você tem um crédito (cupom) de: *R$ " + Math.abs(faltaPagar) + "* conosco!\n\n";
                                } else {
                                    mensagem += "Total Pago: *R$ " + vpagServico + "*\n";
                                }

                                mensagem += "\n __________________________________\n";
                                mensagem += "Acompanhe seu histórico pelo link:\n'.$_SESSION['dominio'].'pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel=" + telefoneCliente + "\n";                              
                                mensagem += "\n __________________________________\n";
                                mensagem += "OBS: *_'.$_SESSION['saudacoes_filial'].'_*\n\n";
                                mensagem += "```AtiviSoft © | Release: B E T A```";
                                var mensagemCodificada = encodeURIComponent(mensagem);
                                var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + telefoneCliente + "&text=" + mensagemCodificada;
                                window.open(urlWhatsApp, "_blank");
                            }
                        </script>
                    ';
                    
                }else if($tipo_mensagem == 'VENDA'){
                    $result_venda     = $u->conVenda($chave_busca, $cd_empresa, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_venda['cd_cliente']);
                    //$result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa);
                    $partial_mensagem  = '
                        <button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>
                    
                        <script>
                            function enviarMensagemWhatsApp() {
                                // Obter os valores dos campos do formulário
                                var nomeCliente = "'.$result_cliente['pnome_cliente'].'";
                                var telefoneCliente = "'.$result_cliente['tel1_cliente'].'";
                                var numeroVenda = "'.$result_venda['cd_venda'].'";
                                var aberturaVenda = "'.$result_venda['abertura_venda'].'";
                                var fechamentoVenda = "'.$result_venda['fechamento_venda'].'";
                                var tituloVenda = "'.$result_venda['titulo_venda'].'";
                                var orcamentoVenda = "'.$result_venda['orcamento_venda'].'";
                                var vpagVenda = "'.$result_venda['vpag_venda'].'";
                                var anoAbertura = aberturaVenda.substring(0, 4);
                                var mesAbertura = aberturaVenda.substring(5, 7);
                                var diaAbertura = aberturaVenda.substring(8, 10);
                                var horaAbertura = aberturaVenda.substring(11, 13);
                                var minutoAbertura = aberturaVenda.substring(14, 16);
                                var anoFechamento = fechamentoVenda.substring(0, 4);
                                var mesFechamento = fechamentoVenda.substring(5, 7);
                                var diaFechamento = fechamentoVenda.substring(8, 10);
                                var horaFechamento = fechamentoVenda.substring(11, 13);
                                var minutoFechamento = fechamentoVenda.substring(14, 16)

                                // Montar a data organizada
                                var aberturaOrganizada = diaAbertura + "/" + mesAbertura + "/" + anoAbertura + " às " + horaAbertura + ":" + minutoAbertura;
                                var fechamentoOrganizado = diaFechamento + "/" + mesFechamento + "/" + anoFechamento + " às " + horaFechamento + ":" + minutoFechamento;
                                
                                faltaPagar = orcamentoVenda - vpagVenda;
                                // Construir a mensagem com todos os dados do formulário
                                var mensagem = "*Olá, " + nomeCliente + "!*\n";
                                mensagem += "Somos da *'.$_SESSION['nfantasia_filial'].'* e ficamos no endereço *'.$_SESSION['endereco_filial'].'*.\n\n";
                                mensagem += "Sua Compra *" + numeroVenda + "*, foi aberta em nossa loja *" + aberturaOrganizada + "*.\n";
                                mensagem += "E finalizada em: *" + fechamentoOrganizado + "*\n\n";
                    ';
                    $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_venda WHERE cd_venda = ".$result_venda['cd_venda']." ORDER BY cd_orcamento ASC";
                    $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
                    
                    $partial_mensagem =  $partial_mensagem.'mensagem += "*Lista detalhada*\n";';
                    $count = 0;                  
                    while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
                        $count ++;
                        $partial_mensagem =  $partial_mensagem.'mensagem += "*'.$count.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vtotal_orcamento'].' \n";';
                    }
                    $partial_mensagem =  $partial_mensagem.'
                                mensagem += "\n";
                                if (faltaPagar > 0) {
                                    mensagem += "Total: *R$ " + vtotalVenda + "*\n";
                                    // mensagem += "Valor pago: *R$ " + vpagVenda + "*\n";
                                    mensagem += "Falta pagar: *R$ " + faltaPagar + "*\n\n";
                                } else if (faltaPagar < 0) {
                                    mensagem += "Você tem um crédito (cupom) de: *R$ " + Math.abs(faltaPagar) + "* conosco!\n\n";
                                } else {
                                    mensagem += "Total Pago: *R$ " + vpagVenda + "*\n";
                                }

                                mensagem += "\n __________________________________\n";
                                mensagem += "Acompanhe seu histórico pelo link:\n'.$_SESSION['dominio'].'pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel=" + telefoneCliente + "\n";                              
                                mensagem += "\n __________________________________\n";
                                mensagem += "OBS: *_'.$_SESSION['saudacoes_filial'].'_*\n\n";
                                mensagem += "```AtiviSoft © | Release: B E T A```";
                                var mensagemCodificada = encodeURIComponent(mensagem);
                                var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + telefoneCliente + "&text=" + mensagemCodificada;
                                window.open(urlWhatsApp, "_blank");
                            }
                        </script>
                    ';
                    
                }else{
                    return [
                        'status'                =>  '($tipo_mensagem) espera (SERVICO, VENDA)',
                        'partial_mensagem'     =>  ''
                    ];
                }
                return [
                    'status'                =>  'OK',
                    'partial_mensagem'       =>  $partial_mensagem
                ];
            }else if($modelo_mensagem == 'TELEGRAM BOT'){
                if($tipo_mensagem == 'SERVICO'){
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa, false);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    //$result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa);
                    $partial_mensagem  = '

                        <button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>
                    
                        <script>
                            function enviarMensagemWhatsApp() {
                                // Obter os valores dos campos do formulário
                                var nomeCliente = "'.$result_cliente['pnome_cliente'].'";
                                var telefoneCliente = "'.$result_cliente['tel1_cliente'].'";
                                var numeroOS = "'.$result_servico['cd_servico'].'";
                                var entradaServico = "'.$result_servico['entrada_servico'].'";
                                var observacoesServico = "'.$result_servico['obs_servico'].'";
                                var prioridadeServico = "'.$result_servico['prioridade_servico'].'";
                                var prazoServico = "'.$result_servico['prazo_servico'].'";
                                var vtotalServico = "'.$result_servico['orcamento_servico'].'";
                                var vpagServico = "'.$result_servico['vpag_servico'].'";
                                var anoEntrada = entradaServico.substring(0, 4);
                                var mesEntrada = entradaServico.substring(5, 7);
                                var diaEntrada = entradaServico.substring(8, 10);
                                var horaEntrada = entradaServico.substring(11, 13);
                                var minutoEntrada = entradaServico.substring(14, 16);
                                var anoPrazo = prazoServico.substring(0, 4);
                                var mesPrazo = prazoServico.substring(5, 7);
                                var diaPrazo = prazoServico.substring(8, 10);
                                var horaPrazo = prazoServico.substring(11, 13);
                                var minutoPrazo = prazoServico.substring(14, 16)

                                // Montar a data organizada
                                var entradaOrganizada = diaEntrada + "/" + mesEntrada + "/" + anoEntrada + " às " + horaEntrada + ":" + minutoEntrada;
                                var prazoOrganizado = diaPrazo + "/" + mesPrazo + "/" + anoPrazo + " às " + horaPrazo + ":" + minutoPrazo;
                                if(prioridadeServico == "U"){
                                    prioridadeOrganizada = "Urgente";
                                }
                                if(prioridadeServico == "A"){
                                    prioridadeOrganizada = "Alta";
                                }
                                if(prioridadeServico == "M"){
                                prioridadeOrganizada = "Média";
                                }
                                if(prioridadeServico == "B"){
                                    prioridadeOrganizada = "Baixa";
                                }
                                faltaPagar = vtotalServico - vpagServico;
                                // Construir a mensagem com todos os dados do formulário
                                var mensagem = "*Olá, " + nomeCliente + "!*\n";
                                mensagem += "Somos da *'.$_SESSION['nfantasia_filial'].'* e ficamos no endereço *'.$_SESSION['endereco_filial'].'*.\n\n";
                                mensagem += "Sua ordem de serviço de número *OS" + numeroOS + "*, deu entrada em nossa loja *" + entradaOrganizada + "*.\n";
                                mensagem += "Descrição da atividade: " + observacoesServico + "\n";
                                //mensagem += "Prioridade Requerida: *" + prioridadeOrganizada + "*\n";
                                mensagem += "O prazo previsto para entrega é: *" + prazoOrganizado + "*\n\n";
                    ';
                    $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = ".$result_servico['cd_servico']." ORDER BY cd_orcamento ASC";
                    $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
                    
                    $partial_mensagem =  $partial_mensagem.'mensagem += "*Lista detalhada*\n";';
                    $count = 0;                  
                    while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
                        $count ++;
                        $partial_mensagem =  $partial_mensagem.'mensagem += "*'.$count.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vcusto_orcamento'].' \n";';
                    }
                    $partial_mensagem =  $partial_mensagem.'
                                mensagem += "\n";
                                if (faltaPagar > 0) {
                                    mensagem += "Total: *R$ " + vtotalServico + "*\n";
                                    // mensagem += "Valor pago: *R$ " + vpagServico + "*\n";
                                    mensagem += "Falta pagar: *R$ " + faltaPagar + "*\n\n";
                                } else if (faltaPagar < 0) {
                                    mensagem += "Você tem um crédito (cupom) de: *R$ " + Math.abs(faltaPagar) + "* conosco!\n\n";
                                } else {
                                    mensagem += "Total Pago: *R$ " + vpagServico + "*\n";
                                }

                                mensagem += "\n __________________________________\n";
                                mensagem += "Acompanhe seu histórico pelo link:\n'.$_SESSION['dominio'].'pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel=" + telefoneCliente + "\n";                              
                                mensagem += "\n __________________________________\n";
                                mensagem += "OBS: *_'.$_SESSION['saudacoes_filial'].'_*\n\n";
                                mensagem += "```AtiviSoft © | Release: B E T A```";
                                var mensagemCodificada = encodeURIComponent(mensagem);
                                var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + telefoneCliente + "&text=" + mensagemCodificada;
                                window.open(urlWhatsApp, "_blank");
                            }
                        </script>
                    ';
                    
                }else{
                    return [
                        'status'                =>  '($tipo_mensagem) espera (SERVICO)',
                        'partial_mensagem'     =>  ''
                    ];
                }
                return [
                    'status'                =>  'OK',
                    'partial_mensagem'       =>  $partial_mensagem
                ];
            }else{

                $partial_mensagem = '<h1>'.$modelo_mensagem.'</h1>
                    <form action="../cad_geral/unidade_operacional.php" method="POST" target="_blank">
                        <h1>Configure seu modelo de mensagem</h1>
                        <button type="submit" name="tabInfoMensagens" id="tabInfoMensagens" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Clique aqui</button>
                    </form>
                ';

                return [
                    'status'                =>  '($modelo_documento) espera (TERMICA1 ou TERMICA2 ou A4)',
                    'partial_mensagem'     =>  $partial_mensagem
                ];
            }     
        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'                => addslashes($e->getMessage()),
                'partial_mensagem'     => 'ERRO'
            ];
        }

    }

    public function cadUnidadeOperacional($cnpj_empresa, $tipo_empresa, $cd_colab, $rsocial_filial, $nfantasia_filial, $telefone_filial, $email_filial) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            $insert_empresa = "INSERT INTO tb_empresa(cd_proprietario, tipo_empresa, rsocial_empresa, nfantasia_empresa, cnpj_empresa, tel1_empresa, email_empresa, status_empresa) VALUES(
                '$cd_colab', '$tipo_empresa', '$rsocial_filial', '$nfantasia_filial', '$cnpj_empresa', '$telefone_filial', '$email_filial', 1)
            ";
            mysqli_query($conn, $insert_empresa);
            $conn->commit();

            $select_empresa = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '$cnpj_empresa' LIMIT 1";
            $result_empresa = mysqli_query($conn, $select_empresa);
            $row_empresa = mysqli_fetch_assoc($result_empresa);
            
            if (!$row_empresa) {
                return [
                    'status'        =>  'Cadastro não realizado',
                    'cd_empresa'    =>  '0'
                ];
            }

            // Obtém o ID recém-criado (cd_empresa)
            $cd_empresa = $row_empresa['cd_empresa'];

            if($tipo_empresa == 'matriz'){
                // Atualiza o campo cd_matriz com o valor de cd_empresa
                $updateEmpresa = "UPDATE tb_empresa SET cd_matriz = $cd_empresa WHERE cd_empresa = $cd_empresa";
                mysqli_query($conn, $updateEmpresa);
            }

            $updateRelMaster = "UPDATE rel_master SET cd_empresa = $cd_empresa WHERE cd_empresa is null and cd_pessoa = ".$_SESSION['cd_colab']."";

            mysqli_query($conn, $updateRelMaster);

            

            if (!$row_empresa) {
                return [
                    'status'        =>  'Empresa não encontrada',
                    'cd_empresa'    =>  '0'
                ];
            }
            
            $conn->commit();
        
            return [
                'status'                =>  'OK',
                'cd_empresa'            =>  $row_empresa['cd_empresa'],    
                'cd_matriz'             =>  $row_empresa['cd_matriz'],
                'rsocial_empresa'       =>  $row_empresa['rsocial_empresa'],    
                'nfantasia_empresa'     =>  $row_empresa['nfantasia_empresa'],    
                'cnpj_empresa'          =>  $row_empresa['cnpj_empresa'],        
                'tel1_empresa'          =>  $row_empresa['tel1_empresa'],    
                'email_empresa'         =>  $row_empresa['email_empresa'],            
                'endereco_empresa'      =>  $row_empresa['endereco_empresa'],        
                'saudacoes_empresa'     =>  $row_empresa['saudacoes_empresa'],    
                'tipo_impressao'        =>  $row_empresa['tipo_impressao'],    
                'status_empresa'        =>  $row_empresa['status_empresa']        
            ];

        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_empresa'  => '0'
            ];
        }

            


            
            

    }

    public function editUnidadeOperacional($cd_empresa, $rsocial_empresa, $nfantasia_empresa, $tel1_empresa, $email_empresa, $endereco_empresa, $saudacoes_empresa) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            $updateEmpresa = "UPDATE tb_empresa SET 
                rsocial_empresa = '$rsocial_empresa',
                nfantasia_empresa = '$nfantasia_empresa',
                tel1_empresa = '$tel1_empresa',
                email_empresa = '$email_empresa',
                endereco_empresa = '$endereco_empresa',
                saudacoes_empresa = '$saudacoes_empresa'
                WHERE cd_empresa = $cd_empresa";
            mysqli_query($conn, $updateEmpresa);
            $conn->commit();
            return [
                'status'                    =>  'OK',
                'cd_empresa'                =>  $cd_empresa,    
                'rsocial_empresa'           =>  $rsocial_empresa,
                'nfantasia_empresa'         =>  $nfantasia_empresa,    
                'tel1_empresa'              =>  $tel1_empresa,    
                'email_empresa'             =>  $email_empresa,        
                'saudacoes_empresa'         =>  $saudacoes_empresa,
                'endereco_empresa'          =>  $endereco_empresa    
            ];

        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_empresa'    => '0'
            ];
        }

            


            
            

    }

    public function conUnidadeOperacional($cd_empresa) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            $selectEmpresa = "SELECT tb_empresa WHERE cd_empresa = $cd_empresa LIMIT 1";


            $result_empresa = mysqli_query($conn, $selectEmpresa);
            $row_empresa = mysqli_fetch_assoc($result_empresa);
            
            if (!$row_empresa) {
                return [
                    'status'        =>  'Empresa não encontrada',
                    'cd_empresa'    =>  '0'
                ];
            }

            $conn->commit();
            return [
                'status'                    =>  'OK',
                'cd_empresa'                =>  $row_empresa['cd_empresa'],    
                'cd_matriz'                 =>  $row_empresa['cd_matriz'],    
                'rsocial_empresa'           =>  $row_empresa['rsocial_empresa'],
                'nfantasia_empresa'         =>  $row_empresa['nfantasia_empresa'],    
                'tel1_empresa'              =>  $row_empresa['tel1_empresa'],    
                'email_empresa'             =>  $row_empresa['email_empresa'],        
                'saudacoes_empresa'         =>  $row_empresa['saudacoes_empresa'],
                'endereco_empresa'          =>  $row_empresa['endereco_empresa']    
            ];

        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'cd_empresa'    => '0'
            ];
        }

            


            
            

    }

    public function fragAtividade($cd_servico){
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        $dataHoraAtual = date('Y-m-d H:i:s'); // Exemplo: 2025-04-19 14:30:00

        //$lista_sql = [];
        try {
            $partial_atividade = '';
            $sql_atividade = "SELECT * FROM (
                SELECT @rownum:=@rownum+1 'rownum', t.* 
                FROM tb_atividade t, (SELECT @rownum:=0) r 
                WHERE cd_servico = '".$_SESSION['cd_servico']."' 
                ORDER BY cd_atividade ASC
                ) as temp_table 
                WHERE temp_table.rownum < (SELECT COUNT(*) FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."')";
            $result_atividade = mysqli_query($conn, $sql_atividade);
            //echo '<h3>HISTÓRICO PASSADO</h3>';
            while($row_atividade = $result_atividade->fetch_assoc()) { //mostrar historico
                $partial_atividade = $partial_atividade.'<div class="col-lg-12 grid-margin stretch-card" '.$_SESSION['c_card'].'>
                    <div class="card" '.$_SESSION['c_card'].'>
                    <div class="card-body">
                ';
                if($row_atividade['titulo_atividade'] == "A"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_atividade['cd_atividade'].' Entrada</h4>';
                }
                if($row_atividade['titulo_atividade'] == "B"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_atividade['cd_atividade'].' Em Andamento / Fazendo</h4>';
                }
                if($row_atividade['titulo_atividade'] == "C"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_atividade['cd_atividade'].' Finalizado / Liberado para Entrega</h4>';
                }
                if($row_atividade['titulo_atividade'] == "D"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_atividade['cd_atividade'].' Entregue / Devolvido ao Cliente</h4>';
                }
                if($row_atividade['titulo_atividade'] == "E"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_atividade['cd_atividade'].' ARQUIVADO</h4>';
                }
                $partial_atividade = $partial_atividade.'<div class="table-responsive">
                    <table class="table" '.$_SESSION['c_card'].'>
                    <thead>
                    <tr>
                    <th>Início</th>
                    <th>Observações</th>
                    <th>Fim</th>
                    </tr>
                    </thead>
                    <tbody>
                ';
                if(isset($row_atividade['inicio_atividade'])){
                    $partial_atividade = $partial_atividade.'<td>'.date('d/m/Y', strtotime($row_atividade['inicio_atividade'])).'</td>';
                }else{
                    $partial_atividade = $partial_atividade.'<td>...</td>';
                }
                $partial_atividade = $partial_atividade.'<td>'.$row_atividade['obs_atividade'].'</td>';
                if(isset($row_atividade['fim_atividade'])){
                    $partial_atividade = $partial_atividade.'<td>'.date('d/m/Y', strtotime($row_atividade['fim_atividade'])).'</td>';
                }else{
                    $partial_atividade = $partial_atividade.'<td>...</td>';
                }
                $partial_atividade = $partial_atividade.'
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </div>
                    </div>
                ';  
            }
            //$sql_lastatividade = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_POST['conos_servico']."'";
            $sql_lastatividade = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_atividade DESC LIMIT 1";

            $result_lastatividade = mysqli_query($conn, $sql_lastatividade);
            $row_lastatividade = mysqli_fetch_assoc($result_lastatividade);
            //echo '<h3>ULTIMA ATIVIDADE EXECUTADA</h3>';
            // Exibe as informações do usuário no formulário
            if($row_lastatividade) {//MOSTRAR FORMULÁRIO DE ANDAMENTO DA ATIVIDADE ATUAL / ULTIMA ATIVIDADE REGISTRADA
                $partial_atividade = $partial_atividade.'
                <div class="col-lg-12 grid-margin stretch-card" style="background-color: #23A5F6;">
                <div class="card" '.$_SESSION['c_card'].'>
                <div class="card-body">
                ';
                if($row_lastatividade['titulo_atividade'] == "A"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Entrada</h4>';
                }
                if($row_lastatividade['titulo_atividade'] == "B"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Em Andamento / Fazendo</h4>';
                }
                if($row_lastatividade['titulo_atividade'] == "C"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Finalizado / Liberado para Entrega</h4>';
                }
                if($row_lastatividade['titulo_atividade'] == "D"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Entregue / Devolvido ao Cliente</h4>';
                }
                if($row_lastatividade['titulo_atividade'] == "E"){
                    $partial_atividade = $partial_atividade.'<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' ARQUIVADO</h4>';
                }
                $partial_atividade = $partial_atividade.'<div class="table-responsive" '.$_SESSION['c_card'].'>
                    <table class="table" '.$_SESSION['c_card'].'>
                    <thead>
                    <tr>
                    <th>Início</th>
                    <th>Observações</th>
                    <th>Fim</th>
                    </tr>
                    </thead>
                    <tbody>
                    <td>'.date('d/m/Y', strtotime($row_lastatividade['inicio_atividade'])).'</td>
                    <td>'.$row_lastatividade['obs_atividade'].'</td>
                ';
                if(isset($row_lastatividade['fim_atividade'])){
                    $partial_atividade = $partial_atividade.'<td>'.date('d/m/Y', strtotime($row_lastatividade['fim_atividade'])).'</td>';
                }else{
                    $partial_atividade = $partial_atividade.'<td></td>';
                }
                $partial_atividade = $partial_atividade.'</tbody>
                    </table>
                    </div>
                    </div>
                    </div>
                    </div>
                ';

                $partial_atividade = $partial_atividade.'<div class="card-body" id="novaAtividade" '.$_SESSION['c_card'].'>
                    <div class="kt-portlet__body" '.$_SESSION['c_card'].'>
                    <div class="row">
                    <div class="col-12 col-md-12">
                    <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                    <h3>LANÇAR ATIVIDADE</h3>
                    <form method="POST">

                    <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                    <input value="'.$row_lastatividade['cd_servico'].'" style="display: none;" name="atividadecd_servico" type="text" id="atividadecd_servico" class="aspNetDisabled form-control form-control-sm" readonly/>       
                    <input value="'.$row_lastatividade['cd_colab'].'" style="display: none;" name="atividadecd_colab" type="text" id="atividadecd_colab" class="aspNetDisabled form-control form-control-sm" readonly/>
                ';    
                
                      if($row_lastatividade['titulo_atividade'] == "A"){//INICIAR ATENDIMENTO
                        $partial_atividade = $partial_atividade.'<label for="marcartitulo_atividade">Entrada</label>
                            <select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>
                            <option selected="selected"value="B">EM ANDAMENTO</option>
                            <option value="C">FINALIZAR</option>
                            <option value="E">ARQUIVAR</option>
                            </select>
                            <label for="showobs_servico">Observações</label>
                            <input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">
                            <label for="data_hora_ponto">Data e Hora</label>
                            <input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>
                            <input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">
                        ';
                        }

                      if($row_lastatividade['titulo_atividade'] == "B"){//FINALIZAR ATENDIMENTO
                        $partial_atividade = $partial_atividade.'<label for="marcartitulo_atividade">Serviço em Andamento</label>
                            <select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>
                            <option selected="selected"value="C">FINALIZAR</option>
                            </select>
                            <label for="obs_atividade">Observações</label>
                            <input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">
                            <label for="data_hora_ponto">Data e Hora</label>
                            <input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>
                            <input type="submit" class="btn btn-success" name="finalizarAtividade" id="finalizarAtividade" value="Finalizar Atividade">
                        ';
                      
                      }

                      if($row_lastatividade['titulo_atividade'] == "C"){//ENTREGAR / DEVOLVER OU REABRIR
                        $partial_atividade = $partial_atividade.'<label for="marcartitulo_atividade">Serviço Realizado</label>
                            <select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>
                            <option selected="selected"value="D">ENTREGAR / DEVOLVER</option>
                            <option value="B">REFAZER AGORA</option>
                            <option value="A">REFAZER DEPOIS</option>
                            <option value="E">ARQUIVAR</option>
                            </select>
                            <label for="obs_atividade">Observações</label>
                            <input name="obs_atividade" type="text" maxlength="999" id="obs_atividade"  class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?" />
                            <label for="novadataentrega_atividade">Prazo Para Revisão</label>
                            <input name="novadataentrega_atividade" type="datetime-local" value="'.date('Y-m-d\T16:00', strtotime('+30 days')).'" id="novadataentrega_atividade" class="form-control form-control-sm">
                            <label for="data_hora_ponto">Data e Hora</label>
                            <input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>
                            <input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">
                        ';
                      }

                      if($row_lastatividade['titulo_atividade'] == "D"){//ENTREGUE / DEVOLVIDO
                        $partial_atividade = $partial_atividade.'<label for="marcartitulo_atividade">Entregue / Devolvido</label>
                            <select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>
                            <option selected="selected"value="B">REFAZER AGORA</option>
                            <option value="A">REFAZER DEPOIS</option>
                            <option value="E">ARQUIVAR</option>
                            </select>
                            <label for="obs_atividade">Observações</label>
                            <input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">
                            <label for="novadataentrega_atividade">Prazo Para Revisão</label>
                            <input name="novadataentrega_atividade" type="datetime-local" value="'.date('Y-m-d\T16:00', strtotime('+30 days')).'" id="novadataentrega_atividade" class="form-control form-control-sm">
                            <label for="data_hora_ponto">Data e Hora</label>
                            <input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>
                            <input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">
                        ';
                      }
                      
                      if($row_lastatividade['titulo_atividade'] == "E"){//ARQUIVADO
                        $partial_atividade = $partial_atividade.'<label for="marcartitulo_atividade">Atividade Arquivada</label>
                            <select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>
                            <option selected="selected"value="B">REFAZER AGORA</option>
                            <option value="A">REFAZER DEPOIS</option>
                            </select>
                            <label for="obs_atividade">Observações</label>
                            <input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">
                            <label for="novadataentrega_atividade">Prazo Para Revisão</label>
                            <input name="novadataentrega_atividade" type="datetime-local" value="'.date('Y-m-d\T16:00', strtotime('+30 days')).'" id="novadataentrega_atividade" class="form-control form-control-sm">
                            <label for="data_hora_ponto">Data e Hora</label>
                            <input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>
                            <input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">
                        ';
                      }
                      
                      $partial_atividade = $partial_atividade.'</div>
                        </form>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                      ';
                    }
            return [
                'status'                =>  'OK',
                'partial_atividade'    =>  $partial_atividade
            ];

        } catch (Exception $e) {
            $conn->rollback();
            return [
                'status'        => addslashes($e->getMessage()),
                'partial_atividade'  => ''
            ];
        }

    }

    public function lancaAtividade($cd_servico, $cd_colab, $flag_atividade, $flag_confirmacao, $obs_atividade) 
    {
        global $conn;
        $u = new Usuario();

        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {
            echo '<script>iniciarCarregamento();</script>';
            //include("../../partials/load.html");
            if($flag_atividade == 'A') {    ///.MCRIAR NOVA ATIVIDADE A FAZER PARA O SERVICO
                $insert_atividade = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                  '".$cd_servico."',
                  'A',
                  '".$obs_atividade."',
                  '".$cd_colab."',
                  NOW(),
                  NOW()
                  )
                ";
                mysqli_query($conn, $insert_atividade);
                $id_atividade = mysqli_insert_id($conn);

                $update_servico = "UPDATE tb_servico SET
                    prazo_servico = NOW(),
                    prioridade_servico = 'U',
                    status_servico = '0'
                    WHERE cd_servico = '".$cd_servico."'
                ";
                mysqli_query($conn, $update_servico);
            }else if($flag_atividade == 'B') {  //SQL DAR INICIO A ATIVIDADE
                $insert_atividade = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade) VALUES(
                  '".$cd_servico."',
                  'B',
                  '".$obs_atividade."',
                  '".$cd_colab."',
                  NOW()
                  )
                ";
                mysqli_query($conn, $insert_atividade);
                $id_atividade = mysqli_insert_id($conn);
                $update_servico = "UPDATE tb_servico SET
                    status_servico = '1'
                    WHERE cd_servico = '".$cd_servico."'
                  ";
                  mysqli_query($conn, $update_servico);
/*
                if(isset($_POST['novadataentrega_atividade'])){
                  $query = "UPDATE tb_servico SET
                    prazo_servico = '".$_POST['novadataentrega_atividade']."',
                    prioridade_servico = 'U',
                    status_servico = '1'
                    WHERE cd_servico = '".$_POST['atividadecd_servico']."'
                  ";
                  mysqli_query($conn, $query);
                  
                    
                
                  //echo "<script>window.alert('Prazo para entrega alterado!');</script>";
                }
*/
                //echo "<script>window.alert('ATIVIDADE INICIADA COM SUCESSO!');</script>";
            }else if($flag_atividade == 'C'){   //FINALIZAR ATIVIDADE
                $select_atividade_finalizar = "SELECT * FROM tb_atividade where titulo_atividade = 'B' AND cd_servico = '".$cd_servico."'";
                $result_atividade_finalizar = mysqli_query($conn, $select_atividade_finalizar);
                $row_atividade_finalizar = mysqli_fetch_assoc($result_atividade_finalizar);
                if($row_atividade_finalizar){
                    $id_atividade = $row_atividade_finalizar['cd_atividade'];
                    $query = "UPDATE tb_atividade SET
                        titulo_atividade = '".$flag_atividade."',
                        obs_atividade = CONCAT(obs_atividade, ' - ','$obs_atividade'),
                        fim_atividade = NOW()
                        WHERE titulo_atividade = 'B' AND cd_atividade = '".$id_atividade."'
                    ";
                mysqli_query($conn, $query);
                //echo "<script>window.alert('FINALIZAR APÓS ANDAMENTO!');</script>";
                }else{
                  $query = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                    '".$cd_servico."',
                    '".$flag_atividade."',
                    '".$obs_atividade."',
                    '".$cd_colab."',
                    NOW(),
                    NOW()
                    )
                  ";
                  mysqli_query($conn, $query);
                  //echo "<script>window.alert('FINALIZAR DIRETO!');</script>";
                }
                $query = "UPDATE tb_servico SET
                  status_servico = '2'
                  WHERE cd_servico = '".$cd_servico."'
                ";
                mysqli_query($conn, $query);
            }else if($flag_atividade == 'D'){   //ENTREGAR ATIVIDADE
                if(isset($flag_confirmacao) && $flag_confirmacao == 'sim'){
                    // Inserir no banco de dados
                    $queryInsert = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                        '" . $cd_servico . "',
                        '" . $flag_atividade . "',
                        '" . $obs_atividade . "',
                        '" . $cd_colab . "',
                        NOW(),
                        NOW()
                    )";
                    mysqli_query($conn, $queryInsert);
                    $id_atividade = mysqli_insert_id($conn);
                    // Atualizar no banco de dados
                    $updateServico = "UPDATE tb_servico SET
                        status_servico = '3'
                        WHERE cd_servico = '" . $_POST['atividadecd_servico'] . "'
                    ";
                    if (mysqli_query($conn, $updateServico)) {
                        $updateEstoque = "
                            UPDATE tb_prod_serv tps
                                INNER JOIN (
                                    SELECT cd_prod_serv, SUM(qtd_reservado) AS total_reservado
                                        FROM tb_reserva
                                            WHERE cd_servico = '" . $cd_servico . "'
                                            AND qtd_reservado IS NOT NULL
                                            AND qtd_reservado > 0
                                            AND qtd_efetivado IS NULL
                                        GROUP BY cd_prod_serv
                                    ) tr ON tps.cd_prod_serv = tr.cd_prod_serv
                                SET tps.estoque_prod_serv = tps.estoque_prod_serv - tr.total_reservado
                            WHERE (tps.estoque_prod_serv - tr.total_reservado) >= 0
                        ";
                        if (mysqli_query($conn, $updateEstoque)) {
                            $updateReserva = "UPDATE tb_reserva SET
                                qtd_efetivado = qtd_reservado,
                                dt_efetivado = '".date('Y-m-d H:i')."'
                                WHERE cd_servico = '" . $cd_servico . "'
                            ";
                            if (mysqli_query($conn, $updateReserva)) {
                                echo "<script>alert('Operação realizada com sucesso!');</script>";
                            }else{
                                echo "<script>alert('Erro ao atualizar a reserva: " . mysqli_error($conn) . "');</script>";
                            }
                      }else{
                        echo "<script>alert('Erro ao atualizar o estoque: " . mysqli_error($conn) . "');</script>";
                      }
                    } else {
                        echo "<script>alert('Erro ao atualizar o serviço: " . mysqli_error($conn) . "');</script>";
                    }
                }else {
                    // Obter os itens dinamicamente do banco de dados
                    $itens = [];
                    $select_orcamento = "
                        SELECT 
                            (@rownum := @rownum + 1) AS linha,
                            tr.qtd_reservado,
                            tos.vcusto_orcamento,
                            tps.titulo_prod_serv
                        FROM tb_orcamento_servico tos
                        INNER JOIN tb_prod_serv tps ON tos.cd_produto = tps.cd_prod_serv
                        LEFT JOIN tb_reserva tr ON tos.cd_orcamento = tr.cd_orcamento
                        WHERE tos.tipo_orcamento = 'CADASTRADO'
                          AND tr.qtd_efetivado IS NULL
                          AND tos.cd_servico = '" . $cd_servico . "'
                        ORDER BY tos.cd_orcamento ASC
                    ";
                    $result_orcamento = mysqli_query($conn, $select_orcamento);
                    if($result_orcamento->num_rows> 0){
                        while ($row_orcamento = $result_orcamento->fetch_assoc()) {
                            $itens[] =  $row_orcamento['linha'] . " - ".$row_orcamento['titulo_prod_serv'] . " | QTD:".$row_orcamento['qtd_reservado'] . " | R$:".$row_orcamento['vcusto_orcamento'];
                        }
            
                        // Construir a mensagem com os itens separados por quebra de linha
                        $mensagem = "Deseja confirmar a saída dos itens:\n" . implode("\n", $itens);
                    
                        // Gerar o JavaScript dinamicamente com json_encode para evitar problemas com caracteres especiais
                        echo "
                            <script>
                                const mensagem = " . json_encode($mensagem) . ";
                                if (confirm(mensagem)) {
                                    // Cria um formulário com todos os dados do POST
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = ''; // Mesma página
                    
                                    // Adiciona os campos existentes no POST ao formulário
                                    const postData = " . json_encode($_POST) . ";
                                    for (const key in postData) {
                                        if (postData.hasOwnProperty(key)) {
                                            const input = document.createElement('input');
                                            input.type = 'hidden';
                                            input.name = key;
                                            input.value = postData[key];
                                            form.appendChild(input);
                                        }
                                    }
                    
                                    // Adiciona o campo de confirmação
                                    const confirmInput = document.createElement('input');
                                    confirmInput.type = 'hidden';
                                    confirmInput.name = 'confirmacao';
                                    confirmInput.value = 'sim';
                                    form.appendChild(confirmInput);
                                    document.body.appendChild(form);
                                    form.submit();
                                } else {
                                    alert('Operação cancelada pelo usuário.');
                                }
                            </script>
                        ";
                    }else{
                        echo "
                            <script>
                                const mensagem = " . json_encode('Confirmar o encerramento deste serviço?') . ";
                                if (confirm(mensagem)) {
                                    // Cria um formulário com todos os dados do POST
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = ''; // Mesma página
                    
                                    // Adiciona os campos existentes no POST ao formulário
                                    const postData = " . json_encode($_POST) . ";
                                    for (const key in postData) {
                                        if (postData.hasOwnProperty(key)) {
                                            const input = document.createElement('input');
                                            input.type = 'hidden';
                                            input.name = key;
                                            input.value = postData[key];
                                            form.appendChild(input);
                                        }
                                    }
                    
                                    // Adiciona o campo de confirmação
                                    const confirmInput = document.createElement('input');
                                    confirmInput.type = 'hidden';
                                    confirmInput.name = 'confirmacao';
                                    confirmInput.value = 'sim';
                                    form.appendChild(confirmInput);
                                    document.body.appendChild(form);
                                    form.submit();
                                } else {
                                    alert('Operação cancelada pelo usuário.');
                                }
                            </script>
                        ";
                    }
                }   
            }else if($flag_confirmacao == 'sim'){
                return [
                    'status'                    =>  'Confirmado',
                    'cd_atividade'              =>  '0'  
                ];
            }else if($flag_atividade == 'E'){   //ARQUIVAR
                $query = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                  '".$cd_servico."',
                  '".$flag_atividade."',
                  '".$obs_atividade."',
                  '".$cd_colab."',
                  NOW(),
                  NOW()
                  )
                ";
                if(mysqli_query($conn, $query)){
                    $id_atividade = mysqli_insert_id($conn);
                    //echo "<script>window.alert('".addslashes($query)."');</script>";
                    //echo "<script>window.alert('ATIVIDADE ARQUIVADA!');</script>";        
                }else{
                    echo "<script>window.alert('ERRO');</script>";
                    //echo "<script>window.alert('".addslashes($e->getMessage())."');</script>";
                }

                $query = "UPDATE tb_servico SET
                    status_servico = '4'
                    WHERE cd_servico = '".$_POST['atividadecd_servico']."'
                ";
                if(mysqli_query($conn, $query)){
                    //echo "<script>window.alert('".addslashes($query)."');</script>"; 
                    //echo "<script>window.alert('SERVICO ARQUIVADO!');</script>";
                }else{
                  echo "<script>window.alert('ERRO');</script>";
                  //echo "<script>window.alert('".addslashes($e->getMessage())."');</script>";
                } 

            }else{
                echo '<script>setTimeout(finalizarCarregamento, 3000);</script>';
                return [
                    'status'                    =>  'flag_atividade espera (A(CRIAR), B(INICIAR), C(FINALIZAR), D(ENTREGAR) ou E(ARQUIVAR))',
                    'cd_atividade'              =>  '0'   
                ]; 
            }

            $conn->commit();
            echo '<script>setTimeout(finalizarCarregamento, 3000);</script>';

            return [
                
                'status'                    =>  'OK',
                'cd_atividade'              =>  $id_atividade   
            ];

        } catch (Exception $e) {
            $conn->rollback();
                echo '<script>setTimeout(finalizarCarregamento, 1000);</script>';

            return [
                'status'        => addslashes($e->getMessage()),
                'cd_empresa'    => '0'
            ];
        }

            


            
            

    }

    public function retPermissao($codigo)
    {
        // Lista de módulos existentes
        $modulos = [
            "acesso_caixa_0001",
            "acesso_assistencia_0002",
            "acesso_venda_0003",
            "acesso_patrimonio_0004",
            "acesso_folhaponto_0005",
            "acesso_financeiro_0006",
            "acesso_cadastro_0007",
            "acesso_pdv_0008"
        ];

        $todasPermissoes = [];

        // Monta o mega-array com todas as permissões de todos os módulos
        foreach ($modulos as $mod) {

        //echo '<script>console.log("VERIFICANDO MÓDULO: '.$mod.'");</script>';

        if (!isset($_SESSION[$mod])) {
            echo '<script>console.log("⚠ NÃO EXISTE NA SESSÃO");</script>';
            continue;
        }

        //echo '<script>console.log("✔ EXISTE NA SESSÃO: '. $_SESSION[$mod] .'");</script>';

        $json = json_decode($_SESSION[$mod], true);

        if ($json === null) {
            //echo '<script>console.log("❌ JSON INVÁLIDO");</script>';
            continue;
        }

        if (!is_array($json)) {
            //echo '<script>console.log("❌ NÃO É ARRAY");</script>';
            continue;
        }

        if (count($json) === 0) {
            echo '<script>console.log("⚠ JSON VAZIO");</script>';
            continue;
        }

        //echo '<script>console.log("✔ JSON OK: '.json_encode($json).'");</script>';

        foreach ($json as $p) {

            //echo '<script>console.log("ADICIONANDO: '.json_encode($p).'");</script>';

            $todasPermissoes[] = [
                "codigo" => $p[0],
                "descricao" => $p[1],
                "status" => $p[2]
            ];
        }
    }


    // Agora valida o código solicitado
    foreach ($todasPermissoes as $perm) {

        if ($perm["codigo"] == $codigo) {

            if ($perm["status"] === "S") {
                // Acesso permitido
                echo '<script>console.log("Acesso permitido ('.$perm["descricao"].' - '.$codigo.')");</script>';
                return true;
            } else {
                // Negado
                echo '<script>console.log("Acesso negado ('.$perm["descricao"].' - '.$codigo.')");</script>';

                echo '<h1 style="font-family: Arial; text-align:center; margin-top:40px;">
                        Acesso negado ('.$perm["descricao"].' - '.$codigo.')
                      </h1>';

                echo '<p style="text-align:center; font-size:20px;">
                        Redirecionando em <span id="contador">5</span> segundos...
                      </p>';

                echo '<script>
                        let tempo = 5;

                        const intervalo = setInterval(() => {
                            tempo--;
                            document.getElementById("contador").textContent = tempo;

                            if (tempo <= 0) {
                                clearInterval(intervalo);
                                window.location.href = "'.$_SESSION['dominio'].'/pages/error/page_403.html";
                            }
                        }, 1000);
                    </script>';

                exit;
            }
        }
    }

    $logJson = json_encode($todasPermissoes);
    echo '<script>console.log("PERMISSOES ENCONTRADAS: ' . $logJson . '");</script>';


    // Código não encontrado → negar por segurança
    //header("Location: https://sistema.ativisoft.com.br/pages/error/page_403.html");
    exit;
}


function mostrarPermissoes($titulo, $lista, $permissao_modulo)
{
    if($permissao_modulo > 112){
        echo '<div class="mt-4 p-3 border rounded shadow-sm" style="max-width: 460px;">';
    echo '<h1 class="h5 card-title mb-3">'.$titulo.'</h1>';

    if (empty($lista)) {
        echo '<p class="text-muted">Nenhuma permissão cadastrada.</p>';
        echo '</div>';
        return;
    }

    foreach ($lista as $p) {
        $checked = ($p[2] == "S") ? "checked" : "";

        echo '
        <div class="input-group mb-2" style="max-width: 420px;">
            <textarea class="form-control form-control-sm"
          readonly
          style="
              overflow: hidden;
              resize: none;
              height: auto;
              min-height: 38px;
              line-height: 1.2;
          "
            >'.$p[0].' - '.$p[1].'</textarea>


            <div class="input-group-text" style="cursor: pointer;">
                <input type="hidden" name="'.$titulo.'[]" value="'.$p[0].'||'.$p[1].'||N">
<input class="form-check-input"
       type="checkbox"
       '.$checked.'
       name="'.$titulo.'[]"
       value="'.$p[0].'||'.$p[1].'||S"
       style="width: 20px; height: 20px; cursor:pointer;">

            </div>
        </div>
        ';
    }

    echo '</div>';
    }
    
}


    public function conProdServ($cd_empresa){
    global $conn;

    $produtos = [];
    $categorias = [];

    $sql = "
        SELECT 
            p.cd_prod_serv AS id,
            p.cdbarras_prod_serv AS sku,
            p.titulo_prod_serv AS name,
            p.preco_prod_serv AS price,
            p.cd_grupo AS category_id,
            g.titulo_grupo AS ds_grupo
        FROM tb_prod_serv p
        LEFT JOIN tb_grupo g ON g.cd_grupo = p.cd_grupo
        WHERE p.cd_empresa = $cd_empresa
        ORDER BY p.titulo_prod_serv ASC
    ";

    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        return [
            "products" => [],
            "categories" => []
        ];
    }

    while ($row = mysqli_fetch_assoc($result)) {

        // lista de produtos
        $produtos[] = [
            'id'         => (int)$row['id'],
            'sku'        => $row['sku'],
            'name'       => $row['name'],
            'price'      => (float)$row['price'],
            'category'   => $row['ds_grupo'],  // Nome do grupo
            'categoryId' => (int)$row['category_id']
        ];

        // armazena categorias únicas
        if (!in_array($row['ds_grupo'], $categorias)) {
            $categorias[] = $row['ds_grupo'];
        }
    }

    return [
        "products"   => $produtos,
        "categories" => $categorias
    ];
}


}

function loggout(){
    //session_start();
    $_SESSION['cd_pessoal'] = '';
    session_destroy();
    echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';
    echo "<script>window.close();</script>";
}


?>

