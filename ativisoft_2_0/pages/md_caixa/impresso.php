<?php


require_once('fpdf/fpdf.php');

    if (isset($_POST['abrir_caixa'])) {
        $showcd_servico = $_POST['btncd_servico'];
        $nome = $_POST['btnpnome_cliente'];
        $sobrenome = $_POST['btnsnome_cliente'];
        $telefone = $_POST['btntel_cliente'];
    
        $showtitulo_servico = $_POST['btntitulo_servico'];
        $showobs_servico = $_POST['btnobs_servico'];
        $showprioridade_servico = $_POST['btnprioridade_servico'];
        $showprazo_servico = $_POST['btnprazo_servico'];
        $showorcamento_servico = $_POST['btnvtotal_orcamento'];
        $showvpag_servico = $_POST['btnvpag_orcamento'];


        $showdtinicio_atividade = $_POST['btnentrada_servico'];
        $inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        $dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
        $horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        //$this->Cell(0, 5, 'Data de entrada: '.date('d/m/Y H:i', strtotime($showdtinicio_atividade)), 0, 1, 'L');
                

        $showprazo_servico = $_POST['btnprazo_servico'];
        $prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        $dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
        $horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        //$this->Cell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y H:i', strtotime($showprazo_servico)), 0, 1, 'L');
             


        // Criação da classe MeuPDF que estende a classe FPDF
        class MeuPDF extends FPDF {
            function Header() {
                //$this->SetFont('Arial', 'B', 10);
                //$this->Cell(58, 10, utf8_decode('Ordem de serviço'), 0, 1, 'C');
                //$this->Ln(5);
            }

            function Footer() {
                //$this->SetY(-15);
                //$this->SetFont('Arial', 'I', 8);
                //$this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
            }

            function GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico) {
                $this->AddPage('P', array(80, 150)); // Tamanho do papel em milímetros

                // Define a margem esquerda como zero
                $this->SetLeftMargin(0);

                $this->SetFont('Arial', 'B', 20);
                $this->Cell(58, 10, utf8_decode('Ordem de serviço'), 0, 1, 'C');
                $this->Ln(5);

                // Cabeçalho com informações do cliente
                $this->SetFont('Arial', 'B', 30);
                $this->Cell(0, 5, 'OS: '.$showcd_servico, 0, 1, 'C');
                $this->Ln(5);
                $this->SetFont('Arial', 'B', 15);
                $this->Cell(0, 5, 'Cliente: ' . utf8_decode($nome) . ' ' . utf8_decode($sobrenome), 0, 1, 'L');
                $this->Cell(0, 4, 'Telefone: ' . $telefone, 0, 1, 'L');
                $this->Ln(5);

                // Observações
                $this->SetFont('Arial', 'B', 15);
                //$this->Cell(0, 5, utf8_decode('Título: ') . utf8_decode($showtitulo_servico), 0, 1, 'L');
                $this->MultiCell(0, 5, 'OBS: '.utf8_decode($this->WrapText($showobs_servico)), 0, 'L');
                $this->SetFont('Arial', '', 15);
          
                $this->Ln(5);

                // Data
                $this->SetFont('Arial', 'B', 15);
                if($showprioridade_servico == "U"){
                    $this->Cell(0, 5, 'Prioridade: Urgente', 0, 1, 'L');
                }
                if($showprioridade_servico == "A"){
                    $this->Cell(0, 5, 'Prioridade: Alta', 0, 1, 'L');
                }
                if($showprioridade_servico == "M"){
                    $this->Cell(0, 5, 'Prioridade: Media', 0, 1, 'L');
                }
                if($showprioridade_servico == "B"){
                    $this->Cell(0, 5, 'Prioridade: Baixa', 0, 1, 'L');
                }
                //$this->Cell(0, 5, 'Prioridade: ' . $showprioridade_servico, 0, 1, 'L');
                //$this->Cell(0, 5, 'Prazo: ' . $showprazo_servico, 0, 1, 'L');
                $this->MultiCell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y \a\s H:i', strtotime($showprazo_servico)), 0, 'L');
                
                $this->Ln(5);




                // Lista de orçamentos feitos
                session_start();
                require_once '../../classes/conn.php';
                include("../../classes/functions.php");

                $this->SetFont('Arial', 'B', 15);
                $this->Cell(0, 5, 'Lista Detalhada', 0, 1, 'C');
                $this->SetFont('Arial', 'B', 15);
                
                $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['servico']."' ORDER BY cd_orcamento ASC";
                $result_orcamento = mysqli_query($conn, $select_orcamento);
                $count = 0;
                while($row_orcamento = $result_orcamento->fetch_assoc()) {
                    $count ++;
                    $this->MultiCell(0, 5, $this->WrapText($count .'__'. utf8_decode($row_orcamento['titulo_orcamento']).'__R$:'.$row_orcamento['vcusto_orcamento']), 0, 'L');
                }
                $this->Ln(5);

                // FINANCEIRO
                $this->SetFont('Arial', 'B', 15);
                $faltapagar = $showorcamento_servico - $showvpag_servico;
                if($faltapagar == 0){
                    $this->Cell(0, 5, 'Total Pago: ' . $showvpag_servico, 0, 1, 'L');
                }else{
                    $this->Cell(0, 5, utf8_decode('Orçamento: ') . $showorcamento_servico, 0, 1, 'L');
                    if($showvpag_servico == 0){
                    }else{
                        $this->Cell(0, 5, 'Valor pago: ' . $showvpag_servico, 0, 1, 'L');
                    }
                    $this->Cell(0, 5, 'Falta Pagar: ' . $faltapagar, 0, 1, 'L');
                    $this->Ln(5);
                }
                $this->SetFont('Arial', 'B', 8);
                $this->Ln(5);
                $this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->MultiCell(0, 5, $this->WrapText(utf8_decode('NuvemSoft © nuvemsoft.com.br 2023  Version 1.0 | Release: B E T A')), 0, 'C');
                $this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                //$this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->Ln(5);
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
        }

        // Instanciar a classe MeuPDF e gerar o PDF
        $pdf = new MeuPDF();
        $pdf->GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico);

        // Concatenar o número de telefone com o nome do arquivo
        $nomeArquivo = 'OS_' . $showcd_servico . '.pdf';

        $pdf->Output($nomeArquivo, 'I');

    } elseif (isset($_POST['fechar_caixa_normal'])) {
        $showcd_servico = $_POST['btncd_servico'];
        
        $showdtinicio_atividade = $_POST['btnentrada_servico'];
        $inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        $dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
        $horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        //$this->Cell(0, 5, 'Data de entrada: '.date('d/m/Y H:i', strtotime($showdtinicio_atividade)), 0, 1, 'L');
                

        $showprazo_servico = $_POST['btnprazo_servico'];
        $prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        $dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
        $horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        //$this->Cell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y H:i', strtotime($showprazo_servico)), 0, 1, 'L');
                
            
      
        $showobs_servico = $_POST['btnobs_servico'];
        $showprioridade_servico = $_POST['btnprioridade_servico'];
        
        $showorcamento_servico = $_POST['btnvtotal_orcamento'];
        $showvpag_servico = $_POST['btnvpag_orcamento'];
        session_start();
        $nfantasia_filial = $_SESSION['nfantasia_filial'];
        $cnpj_filial = $_SESSION['cnpj_filial'];
        $endereco_filial = $_SESSION['endereco_filial'];
        $saudacoes_filial = $_SESSION['saudacoes_filial'];


        $falta_pagar = $showorcamento_servico - $showvpag_servico;

        // Criação da classe MeuPDF que estende a classe FPDF
        class MeuPDF extends FPDF {
            function Header() {
                //$this->SetFont('Arial', 'B', 10);
                //$this->Cell(58, 10, utf8_decode('Via do cliente'), 0, 1, 'C');
                //$this->Ln(5);
            }

            function Footer() {
                //$this->SetY(-15);
                //$this->SetFont('Arial', 'I', 8);
                //$this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
            }

            function GerarViadoCliente($nfantasia_filial, $cnpj_filial, $endereco_filial, $saudacoes_filial, $showcd_servico, $showdtinicio_atividade, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico, $falta_pagar) {
                $this->AddPage('P', array(80, 150)); // Tamanho do papel em milímetros

                // Define a margem esquerda como zero
                $this->SetLeftMargin(0);

                $this->SetFont('Arial', 'B', 10);
                $this->Cell(58, 10, utf8_decode('Via do cliente'), 0, 1, 'C');
                $this->Ln(5);

                // Cabeçalho com informações do cliente
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 5, "-", 0, 1, 'C');
                $this->Cell(0, 5, utf8_decode($nfantasia_filial), 0, 1, 'C');
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, 'CNPJ: '.$cnpj_filial, 0, 1, 'C');
                $this->SetFont('Arial', 'B', 8);
                $this->MultiCell(75, 5, utf8_decode($this->WrapText($endereco_filial)), 0, 'C');
                
                
                $this->Ln(5);
                
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(0, 5, 'OS: '.$showcd_servico, 0, 1, 'L');
                $this->Ln(5);

                // Observações
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, 'Data de entrada: '.date('d/m/Y H:i', strtotime($showdtinicio_atividade)), 0, 1, 'L');
                $this->Cell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y H:i', strtotime($showprazo_servico)), 0, 1, 'L');
                $this->MultiCell(0, 5, 'OBS: '.utf8_decode($this->WrapText($showobs_servico)), 0, 'L');
                $this->SetFont('Arial', '', 8);
                $this->Ln(5);

                // Data
                session_start();
                require_once '../../classes/conn.php';
                include("../../classes/functions.php");

                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 5, 'Lista Detalhada', 0, 1, 'C');
                $this->SetFont('Arial', 'B', 8);
                
                $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['servico']."' ORDER BY cd_orcamento ASC";
                $result_orcamento = mysqli_query($conn, $select_orcamento);
                $count = 0;
                while($row_orcamento = $result_orcamento->fetch_assoc()) {
                    $count ++;
                    $this->MultiCell(0, 5, $this->WrapText($count .' - '. utf8_decode($row_orcamento['titulo_orcamento']).' - R$:'.$row_orcamento['vcusto_orcamento']), 0, 'L');
                }
                $this->Ln(5);
                //$this->Cell(0, 5, 'Prioridade: ' . $showprioridade_servico, 0, 1, 'L');
                $this->Ln(5);

                // FINANCEIRO
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, utf8_decode('Orçamento: ') . $showorcamento_servico, 0, 1, 'L');
                $this->Cell(0, 5, 'Valor pago: ' . $showvpag_servico, 0, 1, 'L');
                $this->Cell(0, 5, 'Falta pagar: ' . $falta_pagar, 0, 1, 'L');
                $this->Ln(5);

                $this->SetFont('Arial', 'B', 8);
                $this->Ln(5);
                $this->SetFont('Arial', '', 7);
                $this->MultiCell(75, 5, utf8_decode($this->WrapText($saudacoes_filial)), 0, 'C');

                $this->SetFont('Arial', 'B', 8);
                $this->Ln(5);
                $this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->MultiCell(0, 5, $this->WrapText(utf8_decode('NuvemSoft © nuvemsoft.com.br 2023  Version 1.0 | Release: 0.00')), 0, 'C');
                $this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                //$this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->Ln(5);
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
        }

        // Instanciar a classe MeuPDF e gerar o PDF
        $pdf = new MeuPDF();
        $pdf->GerarViadoCliente($nfantasia_filial, $cnpj_filial, $endereco_filial, $saudacoes_filial, $showcd_servico, $showdtinicio_atividade, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico, $falta_pagar);

        // Concatenar o número de telefone com o nome do arquivo
        $nomeArquivo = 'VIA_CLIENTE_OS_' . $showcd_servico . '.pdf';

        $pdf->Output($nomeArquivo, 'I');
    } elseif (isset($_POST['fechar_caixa_ontem'])) {
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
    } elseif(isset($_POST['fechar_caixa_anterior'])){
        $showcd_servico = $_POST['btncd_servico'];
        $nome = $_POST['btnpnome_cliente'];
        $sobrenome = $_POST['btnsnome_cliente'];
        $telefone = $_POST['btntel_cliente'];
    
        $showtitulo_servico = $_POST['btntitulo_servico'];
        $showobs_servico = $_POST['btnobs_servico'];
        $showprioridade_servico = $_POST['btnprioridade_servico'];
        $showprazo_servico = $_POST['btnprazo_servico'];


        $showdtinicio_atividade = $_POST['btnentrada_servico'];
        $inicioDatetime = date_create_from_format('d/m/Y H:i', $showdtinicio_atividade);
        $dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
        $horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        //$this->Cell(0, 5, 'Data de entrada: '.date('d/m/Y H:i', strtotime($showdtinicio_atividade)), 0, 1, 'L');
                

        $showprazo_servico = $_POST['btnprazo_servico'];
        $prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        $dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
        $horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
        //$this->Cell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y H:i', strtotime($showprazo_servico)), 0, 1, 'L');
          
        
        // Criação da classe MeuPDF que estende a classe FPDF
        class MeuPDF extends FPDF {
            function Header() {
                //$this->SetFont('Arial', 'B', 10);
                //$this->Cell(58, 10, utf8_decode('Histórico do serviço'), 0, 1, 'C');
                //$this->Ln(5);
            }

            function Footer() {
                //$this->SetY(-15);
                //$this->SetFont('Arial', 'I', 8);
                //$this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
            }

            function GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico) {
                $this->AddPage('P', array(80, 150)); // Tamanho do papel em milímetros

                // Define a margem esquerda como zero
                $this->SetLeftMargin(0);

                // Cabeçalho com informações do cliente
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(58, 10, utf8_decode('Histórico do serviço'), 0, 1, 'C');
                $this->Ln(5);
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(0, 5, 'OS: '.$showcd_servico, 0, 1, 'C');
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, 'Cliente: ' . utf8_decode($nome) . ' ' . utf8_decode($sobrenome), 0, 1, 'L');
                $this->Cell(0, 4, 'Telefone: ' . $telefone, 0, 1, 'L');
                $this->Ln(5);

                // Observações
                $this->SetFont('Arial', 'B', 8);
                //$this->Cell(0, 5, utf8_decode('Título: ') . utf8_decode($showtitulo_servico), 0, 1, 'L');
                $this->MultiCell(0, 5, 'OBS: '.utf8_decode($this->WrapText($showobs_servico)), 0, 'L');
                $this->SetFont('Arial', '', 8);
          
                $this->Ln(5);

                // Data
                $this->SetFont('Arial', 'B', 8);
                if($showprioridade_servico == "U"){
                    $this->Cell(0, 5, 'Prioridade: Urgente', 0, 1, 'L');
                }
                if($showprioridade_servico == "A"){
                    $this->Cell(0, 5, 'Prioridade: Alta', 0, 1, 'L');
                }
                if($showprioridade_servico == "M"){
                    $this->Cell(0, 5, 'Prioridade: Media', 0, 1, 'L');
                }
                if($showprioridade_servico == "B"){
                    $this->Cell(0, 5, 'Prioridade: Baixa', 0, 1, 'L');
                }
                //$this->Cell(0, 5, 'Prioridade: ' . $showprioridade_servico, 0, 1, 'L');
                //$this->Cell(0, 5, 'Prazo: ' . $showprazo_servico, 0, 1, 'L');
                $this->Cell(0, 5, utf8_decode('Previsão de entrega: ').date('d/m/Y H:i', strtotime($showprazo_servico)), 0, 1, 'L');
                
                $this->Ln(5);




                // Lista de orçamentos feitos
                session_start();
                require_once '../../classes/conn.php';
                include("../../classes/functions.php");

                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 5, utf8_decode('Histórico Detalhado'), 0, 1, 'C');
                $this->SetFont('Arial', 'B', 8);
                $select_servico = "SELECT * FROM (
                    SELECT @rownum:=@rownum+1 'rownum', t.* 
                    FROM tb_atividade t, (SELECT @rownum:=0) r 
                    WHERE cd_servico = '".$_SESSION['os_servico']."' 
                    ORDER BY cd_atividade ASC
                  ) as temp_table 
                  WHERE temp_table.rownum < (SELECT COUNT(*) FROM tb_atividade WHERE cd_servico = '".$_SESSION['os_servico']."')";
                  
                //$select_servico = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['servico']."' ORDER BY cd_atividade ASC";
                $result_servico = mysqli_query($conn, $select_servico);
                $count = 0;
                while($row_servico = $result_servico->fetch_assoc()) {
                    $count ++;
                    if($row_servico['titulo_atividade'] == 'A'){
                        $status = 'ENTRADA';
                    }elseif($row_servico['titulo_atividade'] == 'B'){
                        $status = 'EM ANDAMENTO';
                    }elseif($row_servico['titulo_atividade'] == 'C'){
                        $status = 'FINALIZADO';
                    }elseif($row_servico['titulo_atividade'] == 'D'){
                        $status = 'ENTREGUE / DEVOLVIDO';
                    }
                    
                    $this->MultiCell(0, 5, $this->WrapText(utf8_decode($count.' - '. $status.': '.$row_servico['obs_atividade'])), 0, 'C');
                    $this->MultiCell(0, 5, $this->WrapText(utf8_decode('Início:'.date('d/m/Y H:i', strtotime($row_servico['inicio_atividade'])))), 0, 'C');
                    $this->MultiCell(0, 5, $this->WrapText(utf8_decode(' Fim:'.date('d/m/Y H:i', strtotime($row_servico['fim_atividade'])))), 0, 'C');
                    $this->Cell(40, 10, '______________________________________________________________________________________________', 0, 1, 'C');
                }
                $this->Ln(5);

                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 5, utf8_decode('Última atividade'), 0, 1, 'C');
                $this->SetFont('Arial', 'B', 8);
                $select_lastservico = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['os_servico']."' ORDER BY cd_atividade DESC LIMIT 1";


                //$select_servico = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['servico']."' ORDER BY cd_atividade ASC";
                $result_lastservico = mysqli_query($conn, $select_lastservico);
                $count = 0;
                while($row_lastservico = $result_lastservico->fetch_assoc()) {
                    $count ++;
                    if($row_lastservico['titulo_atividade'] == 'A'){
                        $status = 'ENTRADA';
                    }elseif($row_lastservico['titulo_atividade'] == 'B'){
                        $status = 'EM ANDAMENTO';
                    }elseif($row_lastservico['titulo_atividade'] == 'C'){
                        $status = 'FINALIZADO';
                    }elseif($row_lastservico['titulo_atividade'] == 'D'){
                        $status = 'ENTREGUE / DEVOLVIDO';
                    }
                    
                    $this->MultiCell(0, 5, $this->WrapText(utf8_decode($status.': '.$row_lastservico['obs_atividade'])), 0, 'C');
                    $this->MultiCell(0, 5, $this->WrapText(utf8_decode('Início:'.date('d/m/Y H:i', strtotime($row_lastservico['inicio_atividade'])))), 0, 'C');
                    $this->MultiCell(0, 5, $this->WrapText(utf8_decode(' Fim:'.date('d/m/Y H:i', strtotime($row_lastservico['fim_atividade'])))), 0, 'C');
                    //$this->Cell(40, 10, '______________________________________________________________________________________________', 0, 1, 'C');
                }
                $this->Ln(5);


                
                $this->SetFont('Arial', 'B', 8);
                $this->Ln(5);
                $this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->MultiCell(0, 5, $this->WrapText(utf8_decode('NuvemSoft © nuvemsoft.com.br 2023  Version 1.0 | Release: 0.00')), 0, 'C');
                $this->Cell(40, 10, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                //$this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->Ln(5);
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
        }

        // Instanciar a classe MeuPDF e gerar o PDF
        $pdf = new MeuPDF();
        $pdf->GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico);

        // Concatenar o número de telefone com o nome do arquivo
        $nomeArquivo = 'HISTORICO_OS_' . $showcd_servico . '.pdf';

        $pdf->Output($nomeArquivo, 'I');



    } elseif(isset($_POST['rel_fechamento_caixa'])){

        $dt_emissao = $_POST['dt_emissao'];
        $dt_emissao_format = date('d/m/Y', strtotime($dt_emissao));
        
        $dt_inicio = $_POST['dt_inicio'];
        $dt_inicio_format = date('d/m/Y', strtotime($dt_inicio));

        if($_POST['dt_fim'] == false){
            $dt_fim = date('Y-m-d H:i', strtotime('+1 hour'));;
            $dt_fim_format = date('d/m/Y', strtotime($dt_fim));
        }else{
            $dt_fim = $_POST['dt_fim'];
            $dt_fim_format = date('d/m/Y', strtotime($dt_fim));
        }

        
        class MeuPDF extends FPDF {
            function Header() {
                // Seu código de cabeçalho aqui
            }
        
            function Footer() {
                // Seu código de rodapé aqui
            }
        
            function RelFechamentoCaixa($dt_emissao, $dt_inicio, $dt_fim, $dt_emissao_format, $dt_inicio_format, $dt_fim_format) {
                

                $this->AddPage('P', 'A4');
                $this->SetFont('Arial', '', 10);
                
                $this->Ln(20);
                $this->customHeader('A4', 'Relatório de Caixa', $dt_emissao,$dt_inicio_format, $dt_fim_format);

                //$this->dadosCliente('A4', $nome.$sobrenome, $telefone, $showobs_servico);
                
                $this->listaCaixas('A4', $dt_inicio_format, $dt_fim_format);

                //$this->customFooter('A4', '');
        
                //$this->SetFont('Arial', 'B', 20);
                //$this->Cell(0, 5, utf8_decode('Histórico de Caixa'), 0, 1, 'C');
                //$this->Ln(5);
                //$this->SetFont('Arial', 'B', 10);
                //$this->Cell(0, 5, 'dia_caixa '.$_POST['dia_caixa_check'].' / dia_fiscal '.$_POST['dia_fiscal_check'], 0, 1, 'C');
                
                //$this->Cell(0, 5, utf8_decode('Emissão: ') . $dt_emissao, 0, 1, 'C');
                //$this->Cell(0, 5, utf8_decode('Início: ') . $dt_inicio_format, 0, 1, 'C');
                //$this->Cell(0, 5, utf8_decode('Fim: ') . $dt_fim_format, 0, 1, 'C');
                //$this->Ln(5);
        
                
                // Lista de orçamentos feitos
                //session_start();
                //require_once '../../classes/conn.php';
                //include("../../classes/functions.php");
/*
                
                
            if(isset($_POST['dia_fiscal_check'])){


                $this->Ln(1);//se o dia fiscal estiver marcado
                $select_cx_dia_fiscal = "SELECT * FROM tb_caixa_dia_fiscal WHERE status_caixa_dia_fiscal = '2' AND DATE(dt_abertura_dia_fiscal) >= '".$dt_inicio."' AND DATE(dt_abertura_dia_fiscal) <= '".$dt_fim."' ORDER by cd_caixa_dia_fiscal ASC";
                $result_cx_dia_fiscal = mysqli_query($conn, $select_cx_dia_fiscal);
                $count = 0;
                while($row_cx_dia_fiscal = $result_cx_dia_fiscal->fetch_assoc()) {
                    $count ++;
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(0, 1, '__________________________________________________________________________________________________', 0, 1, 'C');
                    $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                    $this->SetFont('Arial', 'B', 12);
                    $this->Cell(0, 5, 'Dia Fiscal  -  '.utf8_decode(date('d/m/Y', strtotime($row_cx_dia_fiscal['dt_abertura_dia_fiscal']))), 0, 1, 'C');
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(0, 3, '__________________________________________________________________________________________________', 0, 1, 'C');
                    $this->SetFont('Arial', 'B', 12);
                    $this->Cell(0, 5, utf8_decode('Analítico'), 0, 1, 'C');
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(0, 5, 'Movimento R$:'.$row_cx_dia_fiscal['movimento_analitico_dia_fiscal'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Total R$:'.$row_cx_dia_fiscal['total_analitico_dia_fiscal'], 0, 1, 'L');
                    $movimento_analitico_cx_dia_fiscal = $movimento_analitico_cx_dia_fiscal + $row_cx_dia_fiscal['movimento_analitico_dia_fiscal'];
                    $total_analitico_cx_dia_fiscal = $total_analitico_cx_dia_fiscal + $row_cx_dia_fiscal['total_analitico_dia_fiscal'];
                    if($row_cx_dia_fiscal['diferenca_caixa_dia_fiscal'] > 0.1){
                        $this->Cell(0, 8, '__________________________________________________________________________________________________', 0, 1, 'C');
                        $this->SetFont('Arial', 'B', 12);
                        $this->Cell(0, 5, utf8_decode('Conferido'), 0, 1, 'C');
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(0, 5, 'Movimento R$:'.$row_cx_dia_fiscal['movimento_conferido_dia_fiscal'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Total R$:'.$row_cx_dia_fiscal['total_conferido_dia_fiscal'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Diferenca:'.$row_cx_dia_fiscal['diferenca_caixa_dia_fiscal'], 0, 1, 'L');
                        //$movimento_conferido_pesquisa_dia_fiscal = $pesquisa_dia_fiscal + $row_cx_dia_fiscal['movimento_conferido_dia_fiscal'];
                        //$total_conferido_pesquisa_dia_fiscal = $pesquisa_dia_fiscal + $row_cx_dia_fiscal['total_conferido_dia_fiscal'];
                        //$diferenca_caixa_pesquisa_dia_fiscal = $pesquisa_dia_fiscal + $row_cx_dia_fiscal['diferenca_caixa_dia_fiscal'];        
                           
                    }
                    //$this->Ln(1);
                }
                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                $this->Cell(0, 1, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 5, utf8_decode('Total do período pesquisado'), 0, 1, 'C');
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 5, utf8_decode('Movimento Analítico R$: ').$movimento_analitico_cx_dia_fiscal, 0, 1, 'C');
                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                $this->Cell(0, 1, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                    
                 


            }
                


            if(isset($_POST['dia_caixa_check'])){
                $this->Ln(1);//se o caixa a caixa estiver marcado
                $select_cx_analitico = "SELECT * FROM tb_caixa WHERE DATE(dt_abertura) >= '".$dt_inicio."' AND DATE(dt_abertura) <= '".$dt_fim."' ORDER by cd_caixa ASC";
                $result_cx_analitico = mysqli_query($conn, $select_cx_analitico);
                $count = 0;
                while($row_cx_analitico = $result_cx_analitico->fetch_assoc()) {
                    $count ++;
                    $this->SetFont('Arial', 'B', 10);
                    $cd_caixa_analitico = $row_cx_analitico['cd_caixa'];
                    $this->Cell(0, 1, '__________________________________________________________________________________________________', 0, 1, 'C');
                    $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                    $this->SetFont('Arial', 'B', 12);
                    $this->Cell(0, 5, $this->WrapText('CX - '.$cd_caixa_analitico), 0, 1, 'C');
                    $this->SetFont('Arial', 'B', 10);
                    if($row_cx_analitico['dt_fechamento'] == null){
                        $dt_fechamento = 'Caixa Aberto';
                    }else{
                        $dt_fechamento = utf8_decode(date('d/m/Y H:i', strtotime($row_cx_analitico['dt_fechamento'])));
                    }
                    $this->Cell(0, 5, utf8_decode('Período: '). utf8_decode(date('d/m/Y H:i', strtotime($row_cx_analitico['dt_abertura']))).' / '.$dt_fechamento, 0, 1, 'L');
                    
                    $select_colab_caixa = "SELECT * FROM tb_pessoa WHERE cd_colab = '".$row_cx_analitico['cd_colab_abertura']."'";
                    $result_colab_caixa = mysqli_query($conn, $select_colab_caixa);
                    while($row_colab_caixa = $result_colab_caixa->fetch_assoc()){


                        if($row_cx_analitico['cd_colab_fechamento'] == null){
                            $colab_fechamento = '';
                        }elseif($row_cx_analitico['cd_colab_fechamento'] == $row_cx_analitico['cd_colab_abertura']){
                            $colab_fechamento = '';
                        }else{


                            $select_colab_caixa_fechamento = "SELECT * FROM tb_pessoa WHERE cd_colab = '".$row_cx_analitico['cd_colab_fechamento']."'";
                            $result_colab_caixa_fechamento = mysqli_query($conn, $select_colab_caixa_fechamento);
                            while($row_colab_caixa_fechamento = $result_colab_caixa_fechamento->fetch_assoc()){
                                $colab_fechamento = '(Fechado por: '.utf8_decode($row_colab_caixa_fechamento['pnome_colab']).' '.utf8_decode($row_colab_caixa_fechamento['snome_colab']).').';
                            }                            
                        }

                        
                        $this->MultiCell(0, 5, utf8_decode('Responsável: ').utf8_decode($row_colab_caixa['pnome_colab']).' '.utf8_decode($row_colab_caixa['snome_colab']).$colab_fechamento, 0, 'L');
                    }//_colab_caixa
                    
                    $this->Cell(0, 8, '__________________________________________________________________________________________________', 0, 1, 'C');
                    $this->SetFont('Arial', 'B', 12);
                    $this->Cell(0, 5, utf8_decode('Analítico'), 0, 1, 'C');
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(0, 5, 'Abertura R$:'.$row_cx_analitico['saldo_abertura'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Dinheiro R$:'.$row_cx_analitico['fpag_dinheiro'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Debito R$:'.$row_cx_analitico['fpag_debito'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Credito R$:'.$row_cx_analitico['fpag_credito'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Pix R$:'.$row_cx_analitico['fpag_pix'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Cofre R$:'.$row_cx_analitico['fpag_cofre'], 0, 1, 'L');
                    //$this->Cell(0, 5, 'Suprimento: '.$row_orcamento['total_suprimento'], 0, 1, 'L');
                    //$this->Cell(0, 5, 'Sangria: '.$row_orcamento['total_sangria'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Movimento R$:'.$row_cx_analitico['total_movimento'], 0, 1, 'L');
                    $this->Cell(0, 5, 'Total R$:'.$row_cx_analitico['saldo_fechamento'], 0, 1, 'L');
                    //$this->Ln(2);
                    $movimento_analitico_cx = $movimento_analitico_cx + $row_cx_analitico['total_movimento'];
                    $total_analitico_cx = $total_analitico_cx + $row_cx_analitico['saldo_fechamento'];
                    
                
                    $select_cx_conferido = "SELECT * FROM tb_caixa_conferido WHERE diferenca_caixa_conferido > 0 AND cd_caixa_analitico = '".$row_cx_analitico['cd_caixa']."'";
                    $result_cx_conferido = mysqli_query($conn, $select_cx_conferido);
                    if($row_cx_conferido = $result_cx_conferido->fetch_assoc()) {
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(0, 8, '__________________________________________________________________________________________________', 0, 1, 'C');
                        $this->SetFont('Arial', 'B', 12);
                        $this->Cell(0, 5, utf8_decode('Conferido'), 0, 1, 'C');
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(0, 5, utf8_decode('Obs Conferência: '). utf8_decode($row_cx_conferido['obs_conferencia']), 0, 1, 'L');
                       
                        $this->SetFont('Arial', 'B', 8);
                        //$this->Cell(0, 5, 'Abertura R$:'.$row_cx_conferido['saldo_abertura_conferido'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Dinheiro R$:'.$row_cx_conferido['fpag_dinheiro_conferido'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Debito R$:'.$row_cx_conferido['fpag_debito_conferido'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Credito R$:'.$row_cx_conferido['fpag_credito_conferido'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Pix R$:'.$row_cx_conferido['fpag_pix_conferido'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Cofre R$:'.$row_cx_conferido['fpag_cofre_conferido'], 0, 1, 'L');
                        //$this->Cell(0, 5, 'Suprimento: '.$row_orcamento['total_suprimento'], 0, 1, 'L');
                        //$this->Cell(0, 5, 'Sangria: '.$row_orcamento['total_sangria'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Movimento R$:'.$row_cx_conferido['saldo_movimento_conferido'], 0, 1, 'L');
                        $this->Cell(0, 5, 'Total R$:'.$row_cx_conferido['saldo_fechamento_conferido'], 0, 1, 'L');
                        $this->Cell(0, 5, utf8_decode('Diferença R$:').$row_cx_conferido['diferenca_caixa_conferido'], 0, 1, 'L');
                        //$this->Ln(2);
                    }
                    $this->Cell(0, 1, '__________________________________________________________________________________________________', 0, 1, 'C');
                    $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C');
                    $this->Ln(5);
                }

                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                $this->Cell(0, 1, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 5, utf8_decode('Total do período pesquisado'), 0, 1, 'C');
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 5, utf8_decode('Movimento Analítico R$: ').$movimento_analitico_cx, 0, 1, 'C');
                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                $this->Cell(0, 1, '__________________________________________________________________________________________________', 0, 1, 'C');
                $this->Cell(0, 3, '_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-', 0, 1, 'C'); 
                
                
            }
*/
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
        }
        
        $pdf = new MeuPDF();
        $pdf->RelFechamentoCaixa($dt_emissao, $dt_inicio, $dt_fim, $dt_emissao_format, $dt_inicio_format, $dt_fim_format);
        
        $nomeArquivo = 'HISTORICO_DE_CAIXA_' . $dt_emissao . '.pdf';
        
        //$pdf->Output($nomeArquivo, 'I');
        ob_end_clean();
        //$pdf->Output($nomeArquivo, 'I');


     // Gerar base64 do PDF
$pdfString = $pdf->Output('S');
$pdfBase64 = base64_encode($pdfString);

echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Abrindo PDF</title>
</head>
<body>
<script>
    window.onload = function() {
        const pdfBase64 = "' . $pdfBase64 . '";
        const blob = b64toBlob(pdfBase64, "application/pdf");
        const blobUrl = URL.createObjectURL(blob);
        window.location.href = blobUrl; // Abre na mesma aba
    };

    function b64toBlob(b64Data, contentType = "", sliceSize = 512) {
        const byteCharacters = atob(b64Data);
        const byteArrays = [];

        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);
            const byteNumbers = new Array(slice.length);
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            byteArrays.push(new Uint8Array(byteNumbers));
        }

        return new Blob(byteArrays, { type: contentType });
    }
</script>
</body>
</html>';




    }elseif(isset($_POST['comprovante_pagamento'])){
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






