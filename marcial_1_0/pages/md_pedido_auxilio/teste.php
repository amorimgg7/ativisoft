<?php
require_once('fpdf/fpdf.php');

    if (isset($_POST['imprimir_os'])) {
        $showcd_servico = $_POST['showcd_servico'];
        $nome = $_POST['showpnome_cliente'];
        $sobrenome = $_POST['showsnome_cliente'];
        $telefone = $_POST['showtel_cliente'];
    
        $showtitulo_servico = $_POST['showtitulo_servico'];
        $showobs_servico = $_POST['showobs_servico'];
        $showprioridade_servico = $_POST['showprioridade_servico'];
        $showprazo_servico = $_POST['showprazo_servico'];
        $showorcamento_servico = $_POST['showorcamento_servico'];
        $showvpag_servico = $_POST['showvpag_servico'];

        // Criação da classe MeuPDF que estende a classe FPDF
        class MeuPDF extends FPDF {
            function Header() {
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(58, 10, utf8_decode('Ordem de serviço'), 0, 1, 'C');
                $this->Ln(5);
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

                // Cabeçalho com informações do cliente
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, 'OS: '.$showcd_servico, 0, 1, 'L');
                $this->Cell(0, 5, 'Cliente: ' . utf8_decode($nome) . ' ' . utf8_decode($sobrenome), 0, 1, 'L');
                $this->Cell(0, 4, 'Telefone: ' . $telefone, 0, 1, 'L');
                $this->Ln(5);

                // Observações
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, utf8_decode('Título: ') . utf8_decode($showtitulo_servico), 0, 1, 'L');
                $this->Cell(0, 5, 'OBS:', 0, 1, 'L');
                $this->SetFont('Arial', '', 8);
                $this->MultiCell(30, 5, utf8_decode($this->WrapText($showobs_servico)), 0, 'L');
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
                $this->Cell(0, 5, 'Prazo: ' . $showprazo_servico, 0, 1, 'L');
                $this->Ln(5);

                // FINANCEIRO
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, utf8_decode('Orçamento: ') . $showorcamento_servico, 0, 1, 'L');
                $this->Cell(0, 5, 'Valor pago: ' . $showvpag_servico, 0, 1, 'L');
                $this->Ln(5);

                $this->SetFont('Arial', 'B', 8);
                $this->Ln(5);
                $this->Cell(40, 10, '-----------------------', 0, 1, 'L');
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

    } elseif (isset($_POST['via_cliente'])) {
        $showcd_servico = $_POST['showcd_servico'];
        
        $showdtinicio_atividade = $_POST['showinicio_atividade'];
        $showobs_servico = $_POST['showobs_servico'];
        $showprioridade_servico = $_POST['showprioridade_servico'];
        $showprazo_servico = $_POST['showprazo_servico'];
        $showorcamento_servico = $_POST['showorcamento_servico'];
        $showvpag_servico = $_POST['showvpag_servico'];
        session_start();
        $nfantasia_filial = $_SESSION['nfantasia_filial'];
        $cnpj_filial = $_SESSION['cnpj_filial'];
        $endereco_filial = $_SESSION['endereco_filial'];
        $saudacoes_filial = $_SESSION['saudacoes_filial'];


        $falta_pagar = $showorcamento_servico - $showvpag_servico;

        // Criação da classe MeuPDF que estende a classe FPDF
        class MeuPDF extends FPDF {
            function Header() {
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(58, 10, utf8_decode('Via do cliente'), 0, 1, 'C');
                $this->Ln(5);
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

                // Cabeçalho com informações do cliente
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, utf8_decode('Nome Fantasia: '), 0, 1, 'L');
                $this->Cell(0, 5, utf8_decode('Endereço > Telefone '), 0, 1, 'L');
                $this->Cell(0, 5, utf8_decode($nfantasia_filial), 0, 1, 'L');
                $this->Cell(0, 5, utf8_decode($cnpj_filial), 0, 1, 'L');
                $this->Cell(0, 5, utf8_decode($endereco_filial), 0, 1, 'L');
                $this->Cell(0, 5, utf8_decode($saudacoes_filial), 0, 1, 'L');
                
                $this->Cell(0, 4, 'Telefone: ', 0, 1, 'L');
                $this->Ln(5);
                
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, 'OS: '.$showcd_servico, 0, 1, 'L');
                $this->Ln(5);

                // Observações
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, 'Data de entrada: ', 0, 1, 'L');
                $this->MultiCell(30, 5, $this->WrapText($showdtinicio_atividade), 0, 'L');
                $this->Cell(0, 5, utf8_decode('Previsão de entrega: '), 0, 1, 'L');
                $this->MultiCell(30, 5, $this->WrapText($showprazo_servico), 0, 'L');
                $this->Cell(0, 5, 'OBS:', 0, 1, 'L');
                $this->SetFont('Arial', '', 8);
                $this->MultiCell(30, 5, utf8_decode($this->WrapText($showobs_servico)), 0, 'L');
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
                $this->Ln(5);

                // FINANCEIRO
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(0, 5, utf8_decode('Orçamento: ') . $showorcamento_servico, 0, 1, 'L');
                $this->Cell(0, 5, 'Valor pago: ' . $showvpag_servico, 0, 1, 'L');
                $this->Cell(0, 5, 'Falta pagar: ' . $falta_pagar, 0, 1, 'L');
                $this->Ln(5);

                $this->SetFont('Arial', 'B', 8);
                $this->Ln(5);
                $this->Cell(40, 10, '-----------------------', 0, 1, 'L');
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
        $nomeArquivo = 'OS_' . $showcd_servico . '.pdf';

        $pdf->Output($nomeArquivo, 'I');
    } elseif (isset($_POST['historico'])) {
        // Handle the "Histórico" button click
        // Code to print the relevant data for the history
        // For example:
        // $historyData = $_POST['showcd_cliente'] . ' - ' . $_POST['showobs_servico'];
        // ... (print $historyData or any other logic for printing history)
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
          }
?>



