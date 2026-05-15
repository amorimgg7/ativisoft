<?php
//session_start();
//require_once 'conn.php';
//include("functions.php");
$u = new Usuario;

class Tools  
{
    public function telefone($telefone) 
    {
        // Lista de códigos de países com nomes
        $paises = [
            "1"   => "EUA/Canadá",
            "7"   => "Rússia/Kazaquistão",
            "20"  => "Egito",
            "27"  => "África do Sul",
            "30"  => "Grécia",
            "31"  => "Holanda",
            "32"  => "Bélgica",
            "33"  => "França",
            "34"  => "Espanha",
            "36"  => "Hungria",
            "39"  => "Itália",
            "40"  => "Romênia",
            "41"  => "Suíça",
            "43"  => "Áustria",
            "44"  => "Reino Unido",
            "45"  => "Dinamarca",
            "46"  => "Suécia",
            "47"  => "Noruega",
            "48"  => "Polônia",
            "49"  => "Alemanha",
            "51"  => "Peru",
            "52"  => "México",
            "53"  => "Cuba",
            "54"  => "Argentina",
            "55"  => "Brasil",
            "56"  => "Chile",
            "57"  => "Colômbia",
            "58"  => "Venezuela",
            "60"  => "Malásia",
            "61"  => "Austrália",
            "62"  => "Indonésia",
            "63"  => "Filipinas",
            "64"  => "Nova Zelândia",
            "65"  => "Cingapura",
            "66"  => "Tailândia",
            "81"  => "Japão",
            "82"  => "Coreia do Sul",
            "84"  => "Vietnã",
            "86"  => "China",
            "90"  => "Turquia",
            "91"  => "Índia",
            "92"  => "Paquistão",
            "93"  => "Afeganistão",
            "94"  => "Sri Lanka",
            "95"  => "Myanmar",
            "98"  => "Irã",
            "212" => "Marrocos",
            "213" => "Argélia",
            "216" => "Tunísia",
            "218" => "Líbia",
            "220" => "Gâmbia",
            "221" => "Senegal",
            "222" => "Mauritânia",
            "223" => "Mali",
            "224" => "Guiné",
            "225" => "Costa do Marfim",
            "226" => "Burkina Faso",
            "227" => "Níger",
            "228" => "Togo",
            "229" => "Benin",
            "230" => "Maurício",
            "231" => "Libéria",
            "232" => "Serra Leoa",
            "233" => "Gana",
            "234" => "Nigéria",
            "235" => "Chade",
            "236" => "Rep. Centro-Africana",
            "237" => "Camarões",
            "238" => "Cabo Verde",
            "239" => "São Tomé e Príncipe",
            "240" => "Guiné Equatorial",
            "241" => "Gabão",
            "242" => "Rep. do Congo",
            "243" => "RD do Congo",
            "244" => "Angola",
            "245" => "Guiné-Bissau",
            "246" => "Território Britânico do Oceano Índico",
            "247" => "Ilha de Ascensão",
            "248" => "Seicheles",
            "249" => "Sudão",
            "250" => "Ruanda",
            "251" => "Etiópia",
            "252" => "Somália",
            "253" => "Djibouti",
            "254" => "Quênia",
            "255" => "Tanzânia",
            "593" => "Equador"
        ];
        
        if($telefone == 0){
            // Identificando o código do país (1, 2 ou 3 dígitos)
            $codigo_pais = '55';
            $numero_restante = '';
            $nome_pais = '+55 Brasil';
            
            // Extraindo o DDD (2 primeiros dígitos do restante)
            $ddd = '';
            $numero_final = '';
        }else{
            // Identificando o código do país (1, 2 ou 3 dígitos)
            $codigo_pais = '';
            $numero_restante = $telefone;
            $nome_pais = 'Desconhecido';
            for ($i = 1; $i <= 3; $i++) {
                $codigo_pais_test = substr($telefone, 0, $i);
                if (array_key_exists($codigo_pais_test, $paises)) {
                    $codigo_pais = $codigo_pais_test;
                    $nome_pais = $paises[$codigo_pais];
                    $numero_restante = substr($telefone, $i);
                    break;
                }
            }
            // Extraindo o DDD (2 primeiros dígitos do restante)
            $ddd = substr($numero_restante, 0, 2);
            $numero_final = substr($numero_restante, 2); 
        }

        // Gerando a lista de países no formato <option>
        $lista_paises = "";
        foreach ($paises as $codigo => $nome) {
            $selected = ($codigo == $codigo_pais) ? ' selected="selected"' : '';
            $lista_paises .= '<option value="' . $codigo . '"' . $selected . '>' . $codigo . ' ' . $nome . '</option>';
        }


        // Retornando os dados como array associativo
        return [
            'codigo_pais' => $codigo_pais,
            'nome_pais'   => $nome_pais,
            'ddd'         => $ddd,
            'numero'      => $numero_final,
            'lista_paises' => $lista_paises
        ];

    }

    function validarCPF($cpf) {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);
    
        // Verifica se tem 11 dígitos
        if (strlen($cpf) !== 11) {
            return [
                'cpf_formatado' => null,
                'bloco1' => null,
                'bloco2' => null,
                'bloco3' => null,
                'digito_verificador' => null,
                'valido' => false
            ];
        }
    
        // Formatar CPF
        $cpf_formatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        $bloco1 = substr($cpf, 0, 3);
        $bloco2 = substr($cpf, 3, 3);
        $bloco3 = substr($cpf, 6, 3);
        $digito_verificador = substr($cpf, 9, 2);
    
        // Verificar se todos os números são iguais (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return [
                'cpf_formatado' => $cpf_formatado,
                'bloco1' => $bloco1,
                'bloco2' => $bloco2,
                'bloco3' => $bloco3,
                'digito_verificador' => $digito_verificador,
                'valido' => false
            ];
        }
    
        // Cálculo dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }
            $digito = ($soma * 10) % 11;
            if ($digito == 10) $digito = 0;
            if ($digito != $cpf[$t]) {
                return [
                    'cpf_formatado' => $cpf_formatado,
                    'bloco1' => $bloco1,
                    'bloco2' => $bloco2,
                    'bloco3' => $bloco3,
                    'digito_verificador' => $digito_verificador,
                    'valido' => false
                ];
            }
        }
    
        // CPF válido
        return [
            'cpf_formatado' => $cpf_formatado,
            'bloco1' => $bloco1,
            'bloco2' => $bloco2,
            'bloco3' => $bloco3,
            'digito_verificador' => $digito_verificador,
            'valido' => true
        ];
    }
    



    function validarCNPJ($cnpj) {
        global $conn;
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/\D/', '', $cnpj);
    
        // Verifica se tem 14 dígitos
        if (strlen($cnpj) !== 14) {
            return [
                'cnpj_formatado' => null,
                'raiz' => null,
                'sufixo' => null,
                'digito_verificador' => null,
                'valido' => false
            ];
        }
    
        // Formatar CNPJ
        $cnpj_formatado = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
        $raiz = substr($cnpj, 0, 8);
        $sufixo = substr($cnpj, 8, 4);
        $digito_verificador = substr($cnpj, 12, 2);
    
        // Verificar se todos os números são iguais (ex: 11111111111111)
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return [
                'cnpj_formatado' => $cnpj_formatado,
                'raiz' => $raiz,
                'sufixo' => $sufixo,
                'digito_verificador' => $digito_verificador,
                'valido' => false
            ];
        }
    
        // Cálculo dos dígitos verificadores
        $pesos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $pesos2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    
        function calcularDigito($cnpj, $pesos) {
            $soma = 0;
            for ($i = 0; $i < count($pesos); $i++) {
                $soma += $cnpj[$i] * $pesos[$i];
            }
            $resto = $soma % 11;
            return ($resto < 2) ? 0 : (11 - $resto);
        }
    
        $digito1 = calcularDigito($cnpj, $pesos1);
        $digito2 = calcularDigito($cnpj . $digito1, $pesos2);
    
        if ($digito1 != $cnpj[12] || $digito2 != $cnpj[13]) {
            return [
                'cnpj_formatado' => $cnpj_formatado,
                'raiz' => $raiz,
                'sufixo' => $sufixo,
                'digito_verificador' => $digito_verificador,
                'valido' => false
            ];
        }

        // Consultar no banco de dados

        $query = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '".$cnpj."'";
		$result = mysqli_query($conn, $query);
		//$row = mysqli_fetch_assoc($result);
        $result = $conn->query($query);
		if ($result->num_rows > 0){
        

            
            $mensagem = "<div class='alert alert-warning'>CNPJ já cadastrado!</div>";
            return [
                'cnpj_formatado' => $cnpj_formatado,
                'raiz' => $raiz,
                'sufixo' => $sufixo,
                'digito_verificador' => $digito_verificador,
                'valido' => false
            ];

        } else {
            return [
                'cnpj_formatado' => $cnpj_formatado,
                'raiz' => $raiz,
                'sufixo' => $sufixo,
                'digito_verificador' => $digito_verificador,
                'valido' => true
            ];
        }

    
        
    }
    
    
    

}