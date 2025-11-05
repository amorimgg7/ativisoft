<?php


require_once('fpdf/fpdf.php');

    if (isset($_POST['imprimir_os'])) {
        $showcd_servico = $_POST['btncd_servico'];
        $nome = $_POST['btnpnome_cliente'];
        $sobrenome = $_POST['btnsnome_cliente'];
        $telefone = $_POST['btntel_cliente'];
    
        $showtitulo_servico = "abc";//$_POST['btntitulo_servico'];
        $showobs_servico = $_POST['btnobs_servico'];
        $showprioridade_servico = $_POST['btnprioridade_servico'];
        $showprazo_servico = $_POST['btnprazo_servico'];
        $showorcamento_servico = $_POST['btnvtotal_orcamento'];
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
        ////$prazoDatetime = date_create_from_format('d/m/Y H:i', $showprazo_servico);
        ////$dataPrazo_formatada = date_format($prazoDatetime, 'd/m/Y');
        ////$horaPrazo_formatada = date_format($prazoDatetime, 'H:i');
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
                //$this->Ln(3);
                $this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');

                
                $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$showcd_servico."' ORDER BY cd_orcamento ASC";
                $result_orcamento = mysqli_query($conn, $select_orcamento);
                $count = 0;
                while($row_orcamento = $result_orcamento->fetch_assoc()) {
                    $count ++;
                    $this->MultiCell(0, 5, $this->WrapText($count .'__'. utf8_decode($row_orcamento['titulo_orcamento']).'__R$:'.$row_orcamento['vtotal_orcamento']), 0, 'L');
                    $this->Cell(40, 10, '__________________________________________________________________________________________________', 0, 1, 'C');
                    //$this->Ln(2);
                }
                $this->Ln(5);

                // FINANCEIRO
                $this->SetFont('Arial', 'B', 15);
                // Converter as variáveis para números usando floatval() antes de subtrair
                $faltapagar = floatval($showorcamento_servico) - floatval($showvpag_servico);

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

        $pdf->Output($nomeArquivo, 'D');

    } elseif (isset($_POST['via_cliente'])) {
        
        
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
        
        $showorcamento_servico = $_POST['btnvtotal_orcamento'];
        $showvpag_servico = $_POST['btnvpag_orcamento'];
        session_start();
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
                //session_start();
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
                    $this->MultiCell(0, 5, $this->WrapText($count .' - '. utf8_decode($row_orcamento['titulo_orcamento']).' - R$:'.$row_orcamento['vtotal_orcamento']), 0, 'L');
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
                    WHERE cd_servico = '".$_SESSION['cd_servico']."' 
                    ORDER BY cd_atividade ASC
                  ) as temp_table 
                  WHERE temp_table.rownum < (SELECT COUNT(*) FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."')";
                  
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
                $select_lastservico = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_atividade DESC LIMIT 1";


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






