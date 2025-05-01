<?php


require_once('fpdf/fpdf.php');

    if (isset($_POST['imprimir_os'])) {
        unset($_POST['imprimir_os']);
        $showcd_servico = $_POST['btncd_servico'];
        $nome = $_POST['btnpnome_cliente'];
        $sobrenome = $_POST['btnsnome_cliente'];
        $telefone = $_POST['btntel_cliente'];
        $showtitulo_servico = "abc";//$_POST['btntitulo_servico'];
        $showobs_servico = $_POST['btnobs_servico'];
        $showprioridade_servico = $_POST['btnprioridade_servico'];
        $showprazo_servico = $_POST['btnprazo_servico'];
        if(!isset($_POST['btnvcusto_orcamento'])){
            $showorcamento_servico = 0;
        }else{
            $showorcamento_servico = $_POST['btnvcusto_orcamento'];
        }
        $showvpag_servico = $_POST['btnvpag_orcamento'];
        $showdtinicio_atividade = $_POST['btnentrada_servico'];
        $inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        if ($inicioDatetime !== false) {
            $dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
            $horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }
        $showprazo_servico = $_POST['btnprazo_servico'];
        $prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        if ($prazoDatetime !== false) {
            $dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
            $horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }
    
        
        class MeuPDF extends FPDF {
            
            function Header() {
                //$this->SetFont('Arial', 'B', 10);
                //$this->Cell(58, 10, utf8_decode('Ordem de serviço'), 0, 1, 'C');
                //$this->Ln(5);
            }

            function Footer() {
                //$this->SetY(-20);
                //$this->SetFont('Arial', 'B', 6);
                //$this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                //$this->Cell(40, 5, '______________________________________________________________________________________________________________', 0, 1, 'C');
                //$this->Cell(80, 10, $this->WrapText(utf8_decode('Ativisoft © sistema.ativisoft.com.br 2025  Version 2.0 | Release: 0.00')), 0, 1, 'C');
                //$this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                
            }

            function GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico) {
                $this->AddPage('P', array(80, 1000)); // Tamanho do papel em milímetros
                $this->SetAutoPageBreak(false);
                $this->SetLeftMargin(0);
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(60, 10, '.', 0, 1, 'C');

                $this->customHeader('M1', 'Ordem de Serviço', $showcd_servico, );

                $this->dadosCliente('M1', $nome.$sobrenome, $telefone, $showobs_servico);
                
                $this->detalheServico('M1', $showprioridade_servico, $showprazo_servico, $showcd_servico);
                
                $this->dadosFinanceiros('M1', $showorcamento_servico, $showvpag_servico);

                $this->customFooter('M1', '');
                
            }

        }
        $pdf = '';
        // Instanciar a classe MeuPDF e gerar o PDF
        $pdf = new MeuPDF();
        $pdf->GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico);

        // Concatenar o número de telefone com o nome do arquivo
        $nomeArquivo = 'OS_' . $showcd_servico . '.pdf';

        $pdf->Output($nomeArquivo, 'D');

    } elseif (isset($_POST['via_cliente'])) {
        unset($_POST['via_cliente']);
        
        $showcd_servico = $_POST['btncd_servico'];
        
        $showdtinicio_atividade = $_POST['btnentrada_servico'];

        $inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        if ($inicioDatetime !== false) {
            $dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
            $horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }

        ////$inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        ////$dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
        ////$horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        //$this->Cell(0, 5, 'Data de entrada: '.date('d/m/Y H:i', strtotime($showdtinicio_atividade)), 0, 1, 'L');
                

        $showprazo_servico = $_POST['btnprazo_servico'];

        $prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        if ($inicioDatetime !== false) {
            $dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
            $horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }
        ////$prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        ////$dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
        ////$horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        //$this->Cell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y H:i', strtotime($showprazo_servico)), 0, 1, 'L');
                
            
      
        $showobs_servico = $_POST['btnobs_servico'];
        $showprioridade_servico = $_POST['btnprioridade_servico'];
        
        
        if(!isset($_POST['btnvcusto_orcamento'])){
            $showorcamento_servico = 0;
        }else{
            $showorcamento_servico = $_POST['btnvcusto_orcamento'];

        }
        
        $showvpag_servico = $_POST['btnvpag_orcamento'];
        //session_start();
        $nfantasia_filial = $_SESSION['nfantasia_filial'];
        $cnpj_filial = $_SESSION['cnpj_filial'];
        $endereco_filial = $_SESSION['endereco_filial'];
        $saudacoes_filial = $_SESSION['saudacoes_filial'];


        ////$falta_pagar = $showorcamento_servico - $showvpag_servico;
        // Converter as variáveis para números inteiros usando intval() antes de subtrair
        $falta_pagar = floatval($showorcamento_servico) - floatval($showvpag_servico);


        // Criação da classe MeuPDF que estende a classe FPDF
        class MeuPDF extends FPDF {
            function Header() {
                //$this->SetFont('Arial', 'B', 10);
                //$this->Cell(58, 10, utf8_decode('Via do clienteee'), 0, 1, 'C');
                //$this->Cell(60, 7, utf8_decode('Via do cliente'), 1, 1, 'C');


                //$this->Ln(1);
            }

            function Footer() {
                //$this->SetY(-20);
                //$this->SetFont('Arial', 'B', 6);
                //$this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                //$this->Cell(40, 5, '______________________________________________________________________________________________________________', 0, 1, 'C');
                //$this->Cell(80, 10, $this->WrapText(utf8_decode('Ativisoft © sistema.ativisoft.com.br 2025  Version 2.0 | Release: 0.00')), 0, 1, 'C');
                //$this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
            }

            function GerarViaCliente($nfantasia_filial, $cnpj_filial, $endereco_filial, $saudacoes_filial, $showcd_servico, $showdtinicio_atividade, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico, $falta_pagar) {
                $this->AddPage('P', array(80, 1000)); // Tamanho do papel em milímetros
                $this->SetAutoPageBreak(false);
                $this->SetLeftMargin(0);
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(60, 10, '.', 0, 1, 'C');

                $this->customHeader('M1', 'Via do cliente', $showcd_servico, );

                $this->dadosEmpresa('M1', $nfantasia_filial, $cnpj_filial, $endereco_filial);
                
                $this->detalheServico('M1', $showprioridade_servico, $showprazo_servico, $showcd_servico);
                
                $this->dadosFinanceiros('M1', $showorcamento_servico, $showvpag_servico);

                $this->customFooter('M1', $saudacoes_filial);


            }

            function WrapText($text) {
                $maxWidth = 58; // Largura máxima do texto
                $words = explode(' ', $text);
                $lines = array();
                $currentLine = '';

                foreach ($words as $word) {
                    if ($this->GetStringWidth($currentLine . ' ' . $word) <= $maxWidth) {
                        $currentLine .= ' ' . $word;
                    } else {
                        $lines[] = trim($currentLine);
                        $currentLine = $word;
                    }
                }

                if (!empty($currentLine)) {
                    $lines[] = trim($currentLine);
                }

                return implode("\n", $lines);
            }

            //$this->AddPage('P', array(80, 300));


        }
        $pdf = '';
        // Instanciar a classe MeuPDF e gerar o PDF
        $pdf = new MeuPDF();
        $pdf->GerarViaCliente($nfantasia_filial, $cnpj_filial, $endereco_filial, $saudacoes_filial, $showcd_servico, $showdtinicio_atividade, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico, $falta_pagar);

        // Concatenar o número de telefone com o nome do arquivo
        $nomeArquivo = 'VIA_CLIENTE_OS_' . $showcd_servico . '.pdf';

        $pdf->Output($nomeArquivo, 'D');
        
    } elseif (isset($_POST['lancar_composto'])) {
            include("../../partials/load.html");
            // Atualiza as informações do usuário no banco de dados
            $insertOrcamento = "INSERT INTO tb_orcamento(cd_cliente, cd_servico, obs_orcamento, vcusto_orcamento, status_orcamento) VALUES(
              '".$_POST['showcd_cliente']."',
              '".$_POST['showcd_servico']."',
              '".$_POST['obs_orcamento']."',
              '".$_POST['custo_orcamento']."',
              '0')
            ";
            mysqli_query($conn, $insertOrcamento);
            echo "<script>window.alert('Composto lançado!');</script>";
            
            $selectServico = "SELECT * FROM tb_servico WHERE cd_cliente = '".$_POST['cd_cliente']."' AND status_servico = 0 ORDER BY cd_servico DESC LIMIT 1";
            $resultServico = mysqli_query($conn, $selectServico);
            $rowServico = mysqli_fetch_assoc($resultServico);
            if($rowServico) {
            }

              echo "<script>window.alert('consulta novamente o servico!');</script>";
              echo '<script>document.getElementById("showOS").style.display = "block";</script>';
              echo '<script>document.getElementById("showcd_servico").value = "'.$row['cd_servico'].'"</script>';
              echo '<script>document.getElementById("showtitulo_servico").value = "'.$row['titulo_servico'].'"</script>';
              echo '<script>document.getElementById("showobs_servico").value = "'.$row['obs_servico'].'"</script>';
              echo '<script>document.getElementById("showprioridade_servico").value = "'.$row['prioridade_servico'].'"</script>';
              echo '<script>document.getElementById("showentrada_servico").value = "'.$_POST['data_hora_ponto'].'"</script>';
              echo '<script>document.getElementById("showprazo_servico").value = "'.$row['prazo_servico'].'"</script>';
              echo '<script>document.getElementById("showorcamento_servico").value = "'.$row['orcamento_servico'].'"</script>';
              echo '<script>document.getElementById("showvpag_servico").value = "'.$row['vpag_servico'].'"</script>';
              echo '<script>document.getElementById("showcd_cliente").value = "'.$row['cd_cliente'].'"</script>';





            $selectOrcamento = "SELECT * FROM tb_orcamento WHERE cd_servico = '".$_POST['cd_servico']."'";
            $resultOrcamento = mysqli_query($conn, $selectOrcamento);
            $rowOrcamento = mysqli_fetch_assoc($resultOrcamento);
            if($rowOrcamento) {
              echo "<script>window.alert('OS: ".$row['cd_servico']." Prioridade: ".$row['prioridade_servico'].", cadastrado com sucesso!');</script>";
              echo '<script>document.getElementById("showOS").style.display = "block";</script>';
              echo '<script>document.getElementById("showcd_servico").value = "'.$row['cd_servico'].'"</script>';
              echo '<script>document.getElementById("showtitulo_servico").value = "'.$row['titulo_servico'].'"</script>';
              echo '<script>document.getElementById("showobs_servico").value = "'.$row['obs_servico'].'"</script>';
              echo '<script>document.getElementById("showprioridade_servico").value = "'.$row['prioridade_servico'].'"</script>';
              echo '<script>document.getElementById("showentrada_servico").value = "'.$_POST['data_hora_ponto'].'"</script>';
              echo '<script>document.getElementById("showprazo_servico").value = "'.$row['prazo_servico'].'"</script>';
              echo '<script>document.getElementById("showorcamento_servico").value = "'.$row['orcamento_servico'].'"</script>';
              echo '<script>document.getElementById("showvpag_servico").value = "'.$row['vpag_servico'].'"</script>';
              echo '<script>document.getElementById("showcd_cliente").value = "'.$row['cd_cliente'].'"</script>';

              $query3 = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                '".$row['cd_servico']."',
                'A',
                '".$row['obs_servico']."',
                '".$_SESSION['cd_colab']."',
                '".$_POST['data_hora_ponto']."',
                          '".$_POST['data_hora_ponto']."')
                          ";
                          mysqli_query($conn, $query3);
                          echo "<script>window.alert('Atividade Lançada!');</script>";
                          //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";

                        $query2 = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$row['cd_cliente']."'";
                        $result2 = mysqli_query($conn, $query2);
                        $row2 = mysqli_fetch_assoc($result2);

                        // Exibe as informações do usuário no formulário
                        if($row2) {
                          echo '<script>document.getElementById("showpnome_cliente").value = "'.$row2['pnome_cliente'].'"</script>';
                          echo '<script>document.getElementById("showsnome_cliente").value = "'.$row2['snome_cliente'].'"</script>';
                          echo '<script>document.getElementById("showtel_cliente").value = "'.$row2['tel_cliente'].'"</script>';      
                        }
                      }
                      echo '<script>window.close();</script>';
                      


                      
            
            //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
    } elseif(isset($_POST['historico_os'])){
        unset($_POST['historico_os']);
        $showcd_servico = $_POST['btncd_servico'];
        $nome = $_POST['btnpnome_cliente'];
        $sobrenome = $_POST['btnsnome_cliente'];
        $telefone = $_POST['btntel_cliente'];
    
        $showtitulo_servico = "ABC";//$_POST['btntitulo_servico'];
        $showobs_servico = $_POST['btnobs_servico'];
        $showprioridade_servico = $_POST['btnprioridade_servico'];
        $showprazo_servico = $_POST['btnprazo_servico'];


        $showdtinicio_atividade = $_POST['btnentrada_servico'];

        $inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        if ($inicioDatetime !== false) {
            $dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
            $horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }


        //$inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        //$dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
        //$horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        //$this->Cell(0, 5, 'Data de entrada: '.date('d/m/Y H:i', strtotime($showdtinicio_atividade)), 0, 1, 'L');
                

        $showprazo_servico = $_POST['btnprazo_servico'];

        $prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        if ($prazoDatetime !== false) {
            $dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
            $horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }

        //$prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        //$dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
        //$horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        //$this->Cell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y H:i', strtotime($showprazo_servico)), 0, 1, 'L');
          
        
        // Criação da classe MeuPDF que estende a classe FPDF
        class MeuPDF extends FPDF {
            function Header() {
                //$this->SetFont('Arial', 'B', 10);
                //$this->Cell(58, 10, utf8_decode('Histórico do serviço'), 0, 1, 'C');
                //$this->Ln(5);
            }

            function Footer() {
                //$this->SetY(-20);
                //$this->SetFont('Arial', 'B', 6);
                //$this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                //$this->Cell(40, 5, '______________________________________________________________________________________________________________', 0, 1, 'C');
                //$this->Cell(80, 10, $this->WrapText(utf8_decode('Ativisoft © sistema.ativisoft.com.br 2025  Version 2.0 | Release: 0.00')), 0, 1, 'C');
                //$this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                
            }

            function GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico) {
                $this->AddPage('P', array(80, 1000)); // Tamanho do papel em milímetros
                $this->SetAutoPageBreak(false);
                $this->SetLeftMargin(0);
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(60, 10, '.', 0, 1, 'C');

                $this->customHeader('M1', 'Histórico do serviço', $showcd_servico);

                $this->dadosCliente('M1',$nome.$sobrenome, $telefone, $showobs_servico );
                
                $this->detalhesAtividadesServico('M1', $showcd_servico);
                
                $this->customFooter('M1', ''); 
            }

        }
        $pdf = '';
        // Instanciar a classe MeuPDF e gerar o PDF
        $pdf = new MeuPDF();
        $pdf->GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico);

        // Concatenar o número de telefone com o nome do arquivo
        $nomeArquivo = 'HISTORICO_OS_' . $showcd_servico . '.pdf';

        $pdf->Output($nomeArquivo, 'D');



    }elseif(isset($_POST['limparOS'])){
        //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
        session_start();
        $_SESSION['cd_cliente'] = 0;
        $_SESSION['cd_servico'] = 0;
        $_SESSION['vtotal_orcamento'] = 0;
        $_SESSION['vpag_servico'] = 0;
        header("location: cadastro_servico.php");
        exit;
    }


?>






