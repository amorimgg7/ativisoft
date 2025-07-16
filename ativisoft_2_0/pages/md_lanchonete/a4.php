<?php



require_once('fpdf/fpdf.php');
ob_start();
    if (isset($_POST['imprimir_venda'])) {
        unset($_POST['imprimir_venda']);
        $showcd_venda = $_POST['btncd_venda'];
        $nome = $_POST['btnpnome_cliente'];
        $sobrenome = $_POST['btnsnome_cliente'];
        $telefone = $_POST['btntel_cliente'];
        $showabertura_venda = $_POST['btnabertura_venda'];
        $showfechamento_venda = $_POST['btnfechamento_venda'];
        
        //$showvpag_servico = $_POST['btnvpag_orcamento'];
        //$showdtinicio_atividade = $_POST['btnentrada_servico'];
        $inicioDatetime = date_create_from_format('d/m/Y H:i', $showabertura_venda);
        if ($inicioDatetime !== false) {
            $dataInicio_formatada = date_format($inicioDatetime, 'd/m/Y');
            $horaInicio_formatada = date_format($inicioDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }
        $fimDatetime = date_create_from_format('d/m/Y H:i', $showfechamento_venda);
        if ($fimDatetime !== false) {
            $dataFim_formatada = date_format($fimDatetime, 'd/m/Y');
            $horaFim_formatada = date_format($fimDatetime, 'H:i');
        } else {
            // Tratar caso em que a data de início não pôde ser criada corretamente
            // Por exemplo, lançar uma exceção, registrar um erro, ou definir uma data padrão
        }
    
        
        class MeuPDF extends FPDF {
            
            function Header() {
            }

            function Footer() {  
            }

            function GerarOrdemVenda($showcd_venda, $nome, $sobrenome, $telefone, $showabertura_venda, $showfechamento_venda) {
                
                $this->AddPage('P', 'A4');
                $this->SetFont('Arial', '', 10);
                
                $this->Ln(20);
                $this->customHeader('A4', 'Venda', $showcd_venda );

                $this->dadosCliente('A4', $nome.$sobrenome, $telefone, '');
                
                $this->detalheVenda('A4', $showabertura_venda, $showfechamento_venda, $showcd_venda);

                $this->customFooter('A4', '');

            }
            

        }
        $pdf = '';
        $pdf = new MeuPDF();
        $pdf->GerarOrdemVenda($showcd_venda, $nome, $sobrenome, $telefone, $showabertura_venda, $showfechamento_venda);
        $nomeArquivo = 'VENDA_' . $showcd_venda . '.pdf';
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




    } elseif (isset($_POST['via_cliente'])) {
        unset($_POST['via_cliente']);
        
        $showcd_servico = $_POST['btncd_servico'];
        $nome = $_POST['btnpnome_cliente'];
        $sobrenome = $_POST['btnsnome_cliente'];
        $telefone = $_POST['btntel_cliente'];

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

            }

            function Footer() {

            }

            function GerarViaCliente($nome, $sobrenome, $telefone, $nfantasia_filial, $cnpj_filial, $endereco_filial, $saudacoes_filial, $showcd_servico, $showdtinicio_atividade, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico, $falta_pagar) {
                $this->AddPage('P', 'A4'); // Tamanho do papel em milímetros
                $this->SetFont('Arial', '', 10);
                // Cabeçalho
                
                $this->Ln(20);
                $this->customHeader('A4', 'Via do cliente', $showcd_servico, );

                $this->dadosEmpresa('A4', $nfantasia_filial, $cnpj_filial, $endereco_filial);

                
                $this->dadosCliente('A4', $nome.$sobrenome, $telefone, $showobs_servico);
                
                $this->detalheServico('A4', $showprioridade_servico, $showprazo_servico, $showcd_servico);


                
                //$this->detalheServico('A4', $showprioridade_servico, $showprazo_servico, $showcd_servico);
                
                //$this->dadosFinanceiros('A4', $showorcamento_servico, $showvpag_servico);

                $this->customFooter('A4', $saudacoes_filial);




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
        $pdf->GerarViaCliente($nome, $sobrenome, $telefone, $nfantasia_filial, $cnpj_filial, $endereco_filial, $saudacoes_filial, $showcd_servico, $showdtinicio_atividade, $showobs_servico, $showprioridade_servico, $showprazo_servico, $showorcamento_servico, $showvpag_servico, $falta_pagar);

        // Concatenar o número de telefone com o nome do arquivo
        $nomeArquivo = 'VIA_CLIENTE_OS_' . $showcd_servico . '.pdf';
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
        //ob_end_clean();
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
            }

            function Footer() {
            }

            function GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico) {
                $this->AddPage('P', 'A4'); // Tamanho do papel em milímetros
                $this->SetFont('Arial', '', 10);
                                
                $this->Ln(20);
                $this->customHeader('A4', 'Histórico do serviço', $showcd_servico);

                $this->dadosCliente('A4',$nome.$sobrenome, $telefone, $showobs_servico );
                
                $this->detalhesAtividadesServico('A4', $showcd_servico);
                
                $this->customFooter('A4', ''); 
            }

        }
        $pdf = '';
        
        $pdf = new MeuPDF();
        $pdf->GerarOrdemServico($showcd_servico, $nome, $sobrenome, $telefone, $showtitulo_servico, $showobs_servico, $showprioridade_servico, $showprazo_servico);

       
        $nomeArquivo = 'HISTORICO_OS_' . $showcd_servico . '.pdf';
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


//ob_end_clean(); // limpa o buffer de saída antes de enviar o PDF
//$pdf->Output();

?>






