<?php

// Ativa a exibição de erros (útil em ambiente de desenvolvimento)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Ativa o registro de erros (útil para produção)
ini_set('log_errors', 1);

// Caminho absoluto e gravável pelo servidor web
ini_set('error_log', __DIR__ . '/logs/erro_php.log'); // Corrigido para caminho relativo ao script




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
                    }else{
                        $_SESSION['cd_acesso'] = 0;
                    }
                     
                    $_SESSION['cd_funcao'] = $rel_master['cd_acesso'];
                    $_SESSION['cd_empresa'] = $rel_master['cd_empresa'];
                    $_SESSION['cd_pessoa'] = $rel_master['cd_pessoa'];

                    
                    $sql4 = $pdo->prepare("SELECT * FROM tb_acesso WHERE cd_acesso = ".$_SESSION['cd_acesso']."");
                    $sql4->execute();
                    if($sql4->rowCount() > 0)
                    {
                        //entrar no sistema(sessão)
                        $tb_acesso = $sql4->fetch();
                        //session_start();
                   
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

                        if($tb_acesso['md_venda'] == '999'){
                            $_SESSION['md_venda'] = "style='display:block;'";
                        }
                        if($tb_acesso['md_venda'] == '111'){
                            $_SESSION['md_venda'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_venda'] == '222'){
                            $_SESSION['md_venda'] = "style='display:none;'";
                        }
                        if($tb_acesso['md_venda'] == '333'){
                            $_SESSION['md_venda'] = "style='display:none;'";
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
         
            $result_servico = $u->conServico($row_servico['cd_servico'], $cd_filial);
        
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

    public function conServico($cd_servico, $cd_filial) 
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
                <form method="POST">

                <div class="card-body" id="abrirOS2">
                <div class="kt-portlet__body">
                <div class="row">
                <div class="col-12 col-md-12">
                <h3 class="kt-portlet__head-title">Dados do serviço</h3>
                <div  class="typeahead">

                <div class="form-group-custom">
                <label for="nome_cliente_servico">cd_cliente</label>
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
                <input value="'.$row_servico['obs_servico'].'" type="text" name="obs_servico" maxlength="999" id="obs_servico"  class=" form-control form-control-sm" placeholder="Caracteristica geral do serviço">
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

                <td><button type="submit" name="editServico" id="editServico" class="btn btn-block btn-outline-success"><i class="icon-cog"></i>Salvar</button></td>
                </div>
                </div>
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

    public function editServico($cd_servico, $cd_filial, $obs_servico, $prioridade_servico, $prazo_servico) 
    {
        global $conn;
        $u = new Usuario();
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

        try {

            $update_servico = "UPDATE tb_servico SET
                        obs_servico = '".$obs_servico."',
                        prioridade_servico = '".$prioridade_servico."',
                        prazo_servico = '".$prazo_servico."'
                        WHERE cd_servico = '".$cd_servico."'";
            mysqli_query($conn, $update_servico);
            
            // Recupera o serviço inserido
            $result_servico = $u->conServico($cd_servico, $cd_filial);
            
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

    public function listOrcamentoServico($cd_servico, $cd_filial) 
    {
        global $conn;
        $conn->autocommit(false); // Desliga o autocommit
        $conn->begin_transaction(); // Inicia a transação manualmente

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
             WHERE tps.estoque_prod_serv > 0 
               AND tps.status_prod_serv = '1'
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

            $partial_orcamento  =   "
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
            $partial_orcamento  =   $partial_orcamento.' 
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <h3 class="kt-portlet__head-title">Composição do Orcamento</h3>
                            <form method="post">
                                <div class="typeahead">
            ';
            
            $partial_orcamento  =   $partial_orcamento.'
                                    <button type="button" id="ProdutosServicosBtn" onclick="showSection(\'ProdutosServicos\', \'ProdutosServicosBtn\')" class="btn btn-outline-success" style="text-align:left; display:none;">Mudar para: Serviço Avulso</button>
                                    <button type="button" id="ProdutosServicosCadastroBtn" onclick="showSection(\'ProdutosServicosCadastro\', \'ProdutosServicosCadastroBtn\')" class="btn btn-outline-success" style="text-align:left;">Mudar para: Produtos/Serviços</button>
                                    <script>document.getElementById("listaOrcamento").style.display = "block";</script>
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
                                                                <input type="tel" id="produto_servico_estoque" name="produto_servico_estoque" class="form-control form-control-sm" style="display:block;" readonly>
                                                                <input type="tel" id="produto_servico_reserva" name="produto_servico_reserva" class="form-control form-control-sm" style="display:block" readonly>         
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
            $partial_orcamento  =   $partial_orcamento.'
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            ';
//FIM DO FRAGMENTO         



            $partial_orcamento  =   $partial_orcamento.' 
                <div name="listaOrcamento" id="listaOrcamento" class="typeahead">
                    <div class="horizontal-form">                
            ';



            while ($row_orcamento = $result_orcamento->fetch_assoc()) {
                $count ++;
                $vtotal_orcamento = $vtotal_orcamento + $row_orcamento['vcusto_orcamento'];

                if($row_orcamento['tipo_orcamento'] == 'AVULSO'){

                    $partial_orcamento = $partial_orcamento.'
                        <div class="form-group">
                            <form method="POST">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="input-group">
                                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text btn-outline-info">'.$count.'</span>
                                                <input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class=" form-control form-control-sm" style="display:none;">
                                                <input value="'.$row_orcamento['tipo_orcamento'].'" name="listatipo_orcamento" id="listatipo_orcamento" type="text" class=" form-control form-control-sm" style="display:none">
                                                <input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class=" form-control form-control-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text btn-outline-info">R$:</span>
                                                <input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class=" form-control form-control-sm" placeholder="" readonly>
                                                <input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>   
                        </div>

                    ';
                }else if($row_orcamento['tipo_orcamento'] == 'CADASTRO'){
                    $partial_orcamento = $partial_orcamento.'
                        <div class="form-group">
                            <form method="POST">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="input-group">
                                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text btn-outline-info">'.$count.'</span>
                                                <input type="hidden" value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class=" form-control form-control-sm" style="display:block;">
                                                <input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class=" form-control form-control-sm" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text btn-outline-info">R$: </span>
                                                <input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class=" form-control form-control-sm" placeholder="" readonly>
                                                <input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           
                            </form>
                        </div>

                    ';
                }
                    
            }

            $partial_orcamento  =   $partial_orcamento.'
                    </div>
                </div> 
            ';

            $falta_pagar = $vtotal_orcamento - $row_pagamento['total_pago'];
            
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
                    </div>
                    </div>
                    </div>
                ';
                return [
                    'status'                =>  'OK',
                    'partial_financeiro'    =>  $partial_financeiro
                ];
            }elseif($referencia == 'HOJE'){

                /*
                $partial_financeiro = '                
                    <div class="col-12 grid-margin stretch-card btn-warning" '.$_SESSION['c_card'].'>
                    <div class="card" '.$_SESSION['c_card'].'>
                    <div class="card-body">
                    <h1 class="card-title">Abra já seu caixa</h1>
                    <p class="card-title">Para realizar movimento financeiro, o seu caixa deve estar devidamente aberto</p>
                    </div>
                    </div>
                    </div>
                ';*/
       
                $select_financeiro = "SELECT * FROM tb_movimento_financeiro WHERE cd_os_movimento = '".$cd_servico."' ORDER BY cd_movimento ASC";
                $select_financeiro_servico = "SELECT * FROM tb_servico WHERE cd_servico = '".$cd_servico."' LIMIT 1";

                $result_financeiro = mysqli_query($conn, $select_financeiro);
                //$row_atividade = mysqli_fetch_assoc($result_atividade);
                    
                // Exibe as informações do usuário no formulário
                    
                $count = 0;
                $vpag_servico = 0;
                $partial_financeiro = '
                    <div class="col-12 grid-margin stretch-card btn-success">
                        <div class="card" '.$_SESSION['c_card'].'>
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">Histórico de Pagamento</h4>
                ';
                
                while($row_financeiro = $result_financeiro->fetch_assoc()) {
                    $count ++;
                    $vpag_servico = $row_financeiro['valor_movimento'];
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
                }

                $result_financeiro_servico = mysqli_query($conn, $select_financeiro_servico);
                $row_financeiro_servico = mysqli_fetch_assoc($result_financeiro_servico);

                $falta_pagar_servico = $row_financeiro_servico['orcamento_servico'] - $vpag_servico;
                            
                $result_financeiro_servico = mysqli_query($conn, $select_financeiro_servico);
                $row_financeiro_servico = mysqli_fetch_assoc($result_financeiro_servico);



                if($vpag_servico == $row_financeiro_servico['vpag_servico']){
                    $partial_financeiro = $partial_financeiro.'
                                <h6 style="color:#000;">total pago: ('.$vpag_servico.') - ('.$row_financeiro_servico['orcamento_servico'].')</h6>
                    ';     
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
                                            if (isNaN(inputValue) || inputValue < 0.1 || inputValue > '.$falta_pagar_servico.') {
                                                errorMessageElement.style.color = "red";
                                                borderForm.style.border = "2px solid red";
                                                errorMessageElement.textContent = "O valor pago deve ser maior que 1 e menor ou igual a '.$falta_pagar_servico.'.";
                                                inputElement.setCustomValidity("O valor pago deve ser maior que 1 e menor ou igual a '.$falta_pagar_servico.'.");
                                            } else {
                                                errorMessageElement.style.color = "green";
                                                borderForm.style.border = "1px solid green";
                                                errorMessageElement.textContent = "OK";
                                                inputElement.setCustomValidity("OK");
                                            }
                                        }
                                    </script>  
                                    <button type="submit" name="pagar_servico" id="pagar_servico" class="btn btn-lg btn-block btn-outline-success btn-light"><i class="mdi mdi-file-check"></i>Lançar Pagamento</button>
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
            }elseif($referencia == 'ANTERIOR'){

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
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa);
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
                                <button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>
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
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa);
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
                                <button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>
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
                    $result_servico     = $u->conServico($chave_busca, $cd_empresa);
                    $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                    $result_orcamento   = $u->listOrcamentoServico($result_servico['cd_servico'], $cd_empresa);
                    $partial_impressao  = '
                        <form action="a4.php" method="POST" target="_blank">
                            <h1>A4</h1>
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
                                <button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>
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
            }else{
                return [
                    'status'                =>  '($modelo_documento) espera (TERMICA1 ou TERMICA2 ou A4)',
                    'partial_impressao'     =>  ''
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


}

function loggout(){
    //session_start();
    $_SESSION['cd_pessoal'] = '';
    session_destroy();
    echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';
    echo "<script>window.close();</script>";
}


?>

