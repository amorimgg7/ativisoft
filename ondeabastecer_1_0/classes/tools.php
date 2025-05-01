
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
            "255" => "Tanzânia"
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
            $lista_paises .= '<option value="' . $codigo . '"' . $selected . '>+' . $codigo . ' ' . $nome . '</option>';
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


}