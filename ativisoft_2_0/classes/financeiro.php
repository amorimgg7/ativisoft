<?php
    $u = new Usuario;
    class Financeiro  
    {
        public function movimentoFinanceiro($tipo, $cd_empresa, $cd_caixa, $cd_cliente, $cd_colab, $cd_servico, $cd_venda, $fpag_movimento, $vpag_movimento) 
        {
            global $conn;
            

            $conn->autocommit(false); // Desliga o autocommit
            $conn->begin_transaction(); // Inicia a transação manualmente


            if($tipo == 'R'){
                
    
                if($cd_servico != '') {

                    $insert_movimento_financeiro = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_filial, cd_caixa_movimento, cd_cliente_movimento, cd_colab_movimento, cd_os_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                    1,
                    '".$cd_empresa."',
                    '".$cd_caixa."',
                    '".$cd_cliente."',
                    '".$cd_colab."',
                    '".$cd_servico."',
                    '".$fpag_movimento."',
                    '".$vpag_movimento."',
                    now(),
                    'PAGAMENTO DA OS: ".$cd_servico."'
                )";
                echo "<script>window.alert(" . json_encode(    $insert_movimento_financeiro) . ");</script>";


                    $update_servico = "UPDATE tb_servico SET
                    vpag_servico = vpag_servico + ".$vpag_movimento."
                    WHERE cd_servico = ".$cd_servico."";
                    
                    $select_servico = "SELECT vpag_servico FROM tb_servico WHERE cd_servico = '".$cd_servico."'";
                    //$vpag_servico = $vpag_servico + $vpag_movimento;
                    //$_SESSION['falta_pagar_servico'] = $_SESSION['vcusto_orcamento'] - $_SESSION['vpag_servico'];
                    //echo  '<script>document.getElementById("btn_falta_pagar_orcamento").value = "'.$_SESSION['falta_pagar_servico'].'";</script>';
    
                    //if($_SESSION['falta_pagar_servico'] == 0){
                    //    echo '<script>document.getElementById("tela_pagamento").style.display = "none";</script>';//tela_pagamento
                    //}
    
                    //echo  '<script>document.getElementById("btnvpag_orcamento").value = "'.$_POST['btnvpag_orcamento'].'";</script>';
                    //header("location: consulta_servico.php");
                }else if($cd_venda != '') {
                    $insert_movimento_financeiro = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_filial, cd_caixa_movimento, cd_cliente_movimento, cd_colab_movimento, cd_venda_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                    1,
                    '".$cd_empresa."',
                    '".$cd_caixa."',
                    '".$cd_cliente."',
                    '".$cd_colab."',
                    '".$cd_venda."',
                    '".$fpag_movimento."',
                    '".$vpag_movimento."',
                    now(),
                    'PAGAMENTO DA VENDA: ".$cd_venda."'
                )";
                echo "<script>window.alert(" . json_encode(    $insert_movimento_financeiro) . ");</script>";


                    $update_venda = "UPDATE tb_venda SET
                    vpag_venda = vpag_venda + ".$vpag_movimento."
                    WHERE cd_venda = ".$cd_venda."";
                    
                    $select_venda = "SELECT vpag_venda FROM tb_venda WHERE cd_venda = '".$cd_venda."'";
                    //$vpag_servico = $vpag_servico + $vpag_movimento;
                    //$_SESSION['falta_pagar_servico'] = $_SESSION['vcusto_orcamento'] - $_SESSION['vpag_servico'];
                    //echo  '<script>document.getElementById("btn_falta_pagar_orcamento").value = "'.$_SESSION['falta_pagar_servico'].'";</script>';
    
                    //if($_SESSION['falta_pagar_servico'] == 0){
                    //    echo '<script>document.getElementById("tela_pagamento").style.display = "none";</script>';//tela_pagamento
                    //}
    
                    //echo  '<script>document.getElementById("btnvpag_orcamento").value = "'.$_POST['btnvpag_orcamento'].'";</script>';
                    //header("location: consulta_servico.php");
                }else{
                    return [
                        'status'        => 'Preencha Serviço ou Venda'
                    ];
                }
    
    
    
    
               
                try {
                    // Executa os comandos
                    mysqli_query($conn, $insert_movimento_financeiro);

                    if($cd_venda != ''){
                        mysqli_query($conn, $update_venda);
                        $result_venda = $conn->query($select_venda);

                        if ($result_venda->num_rows > 0) {
                            $row_venda = $result_venda->fetch_assoc(); // Pega a linha como array associativo
                            
                            $conn->commit(); // ❗ Se quiser salvar de verdade, troque por $conn->commit();
                            return [
                                'status'        => 'sucesso',
                                'vpag'  => $row_venda['venda']
                            ];

                        } else {
                            $conn->rollback();
                            return [
                                'status'        => 'Venda ('.$cd_venda.') não encontrada',
                                'vpag'  => '0'
                            ];
                        }

                    }else if($cd_servico != ''){
                        mysqli_query($conn, $update_servico);
                        $result_servico = $conn->query($select_servico);

                        if ($result_servico->num_rows > 0) {
                            $row_servico = $result_servico->fetch_assoc(); // Pega a linha como array associativo
                            
                            $conn->commit(); // ❗ Se quiser salvar de verdade, troque por $conn->commit();
                            return [
                                'status'        => 'sucesso',
                                'vpag'  => $row_servico['servico']
                            ];

                        } else {
                            $conn->rollback();
                            return [
                                'status'        => 'Servico ('.$cd_servico.') não encontrado',
                                'vpag'  => '0'
                            ];
                        }

                    } else {
                        $conn->rollback();
                        return [
                            'status'        => 'Preencha Serviço ou Venda',
                            'vpag'  => '0'
                        ];
                    }
                
                } catch (Exception $e) {
                    // Se algum der erro, desfaz tudo
                    $conn->rollback();
                    return [
                        'status'        => addslashes($e->getMessage()),
                        'vpag'  => '0'
                    ];
                }

            }else if($tipo == 'D'){
                
            }else{
                return [
                    'status'        => '$tipo(R: RECEITA. D: DESPEZA.)'
                ];
            }
            

            



		   





        }

    }