<?php

//---------------Funções para junção dos inputs com os IPs-----------------------------//

    function ipv4($ip1, $ip2, $ip3, $ip4){

        // Recebe os valores dos inputs separados e coloca num array
        // Junta todos os valores em uma string, utilizando a função "implode()"

        $ip = array($ip1, $ip2, $ip3, $ip4);
        $ip_final = implode('.', $ip );

        return $ip_final;
    }

    function ipv4_FL($ip1, $ip2, $ip3){

        // Recebe os valores dos 3 primeiros inputs separados e coloca num array
        // Junta todos os valores em uma string, utilizando a função "implode()"

        $ip = array($ip1, $ip2, $ip3);
        $ip_final = implode('.', $ip );

        return $ip_final;
    }





//-----------------Funções de quantidade----------------------------------------//

    function quantidade_subredes( $mask){

        // Recebe a máscara de parâmetro
        // A variável "total" representa o valor de máscara máximo, ou seja /32
        // A variável "total_4" representa a quantidade de bits máxima da quarta divisão do IP
        // É feita a diminuição do total pela máscara, gerando um número entre 0-8 (dependendo da máscara)
        // É feita a diminuição do total de bits (8) pelo total de bits zerados
        // Por fim, o resultado é colocado como expoente da base 2, assim resultando na quantidade de sub-redes

        $total = 32;
        $total_4 = 8;
        $bits_zerados = $total - $mask;
        $bits_setados = $total_4 - $bits_zerados;
        $qtd_redes = pow(2, $bits_setados);

        return $qtd_redes;
    }

    function quantidade_hosts($mask){

        // Recebe a máscara de parâmetro
        // A variável "total" representa o valor de máscara máximo, ou seja /32
        // A diferença do cálculo (total - máscara) é colocada como expoente na base 2
        // São diminuídos 2 endereços do valor final

        if ($mask == 31) {
            return 0;
        }elseif ($mask == 32) {
            return 0;
        }else{
            $total = 32;
            $bits_zerados = $total - $mask;
            $qtd_hosts = pow(2, $bits_zerados);
            $qtd_hosts -= 2;

        return $qtd_hosts;

        }
    }

    function quantidade_enderecos($mask){

        // Recebe a máscara de parâmetro
        // A variável "total" representa o valor de máscara máximo, ou seja /32
        // A diferença do cálculo (total - máscara) é colocada como expoente na base 2

        
        $total = 32;
        $bits_zerados = $total - $mask;
        $qtd_enderecos = pow(2, $bits_zerados);

        return $qtd_enderecos;
        
    }

//------------------Primeiro e ultimo host----------------------------------------//

    function primeiro_host($mask){

        $qtd = quantidade_enderecos($mask);

        $posicao_rede = (int) (256/$qtd);
        $primeiro_host = ($posicao_rede * $qtd) + 1;

        return $primeiro_host;
    }

    function ultimo_host($mask){

        $qtd = quantidade_enderecos($mask);

        $ultimo_host = $qtd - 2;
        return $ultimo_host;
    }

//BroadCast

    function broadcast($ip1, $ip2, $ip3, $ip4, $mask){
        $broadcast = (ipv4_FL($ip1,$ip2, $ip3).'.'.(ultimo_host($mask) + 1));

        return $broadcast;
    }

//Máscara

    function calculo_mask( $input_4, $mask){

        $mascara = '255.255.255';
        $mask = (256 - ultimo_host($mask));
        $mascara_final = $mascara.".".($mask-2);

        return $mascara_final;
    }


//Classe do IP

    function define_classe( $input_1){

        $classe = "";

        if ($input_1 > 0 and $input_1 < 127){

            $classe = "A";

        }elseif ($input_1 > 127 and $input_1 < 192){
            $classe = "B";

        }elseif ($input_1 > 191 and $input_1 < 224){

            $classe = "C";

        }elseif ($input_1 > 223 and $input_1 < 240){

            $classe = "D";

        }elseif ($input_1 > 239 and $input_1 < 256){

            $classe = "E";

        }else{
            $classe = "N/E";
        }

        return $classe;
    }

//Privado ou Público

    function calc_privacidade( $input_1,  $input_2){

          $privacidade = "";

          if ($input_1 == 10){

              $privacidade = "Privado";

          }elseif ($input_1 == 172 and $input_2 > 15 and $input_2 <31){

              $privacidade = "Privado";

          }elseif ($input_1 == 192 and $input_2 == 168){

              $privacidade = "Privado";

          }elseif($input_1 == 127 OR $input_1 == 169 and $input_1 == 254){
              $privacidade = "Reservado";
          }else{

              $privacidade = "Público";

          }

          return $privacidade;
    }


//Função para listar cada subrede e achar a qual o IP pertence

     function subredes($ip1, $ip2, $ip3, $ip4, $mask){

        $qtd_redes = quantidade_subredes($mask);
        $broadcast = broadcast($ip1, $ip2, $ip3, $ip4, $mask);
        $fragmentos_ip = explode(".", $broadcast);

        $semi_ip = $fragmentos_ip[0] . "." . $fragmentos_ip[1] . "." . $fragmentos_ip[2];

        $primeiro_host = 0;

    
        for ($i=0; $i < $qtd_redes; $i++) { 

            if ($mask <= 30) {

                $ultimo_host = $primeiro_host + $fragmentos_ip[3];

                $primeiroHost_Final = $semi_ip . "." . $primeiro_host;
                $ultimoHost_Final = $semi_ip . "." . $ultimo_host;

                $intervalo1 = $primeiro_host + 1;
                $intervalo2 = $ultimo_host - 1;

                $Intervalo1_Final = $semi_ip . "." . $intervalo1;
                $Intervalo2_Final = $semi_ip . "." . $intervalo2;

                $intervalos[$i] = $primeiroHost_Final . ' - ' . $Intervalo1_Final . ' - ' . $Intervalo2_Final . ' - ' . $ultimoHost_Final."<br>";
                
                $primeiro_host += $fragmentos_ip[3] + 1;

            }elseif ($mask == 31) {

                $ultimo_host = $primeiro_host + $fragmentos_ip[3];

                $primeiroHost_Final = $semi_ip . "." . $primeiro_host;
                $ultimoHost_Final = $semi_ip . "." . $ultimo_host;

                $intervalo1 = $primeiro_host + 1;
                $intervalo2 = $ultimo_host - 1;

                $Intervalo1_Final = $semi_ip . "." . $intervalo1;
                $Intervalo2_Final = $semi_ip . "." . $intervalo2;

                $intervalos[$i] = $primeiroHost_Final . ' - ' . $Intervalo2_Final . ' - ' . $Intervalo1_Final . ' - ' . $ultimoHost_Final."<br>";
                
                $primeiro_host += $fragmentos_ip[3] + 1;

            }else{
                $ultimo_host = $primeiro_host + $fragmentos_ip[3];

                $primeiroHost_Final = $semi_ip . "." . $primeiro_host;
                $ultimoHost_Final = $semi_ip . "." . $ultimo_host;

                $intervalo1 = $primeiro_host + 1;
                $intervalo2 = $ultimo_host - 1;

                $Intervalo1_Final = $semi_ip . "." . $intervalo1;
                $Intervalo2_Final = $semi_ip . "." . $intervalo2;

                $intervalos[$i] = $primeiroHost_Final . ' - ' . $primeiroHost_Final . ' - ' . $primeiroHost_Final . ' - ' . $primeiroHost_Final."<br>";
                
                $primeiro_host += $fragmentos_ip[3] + 1;
            }
                                    
        } 

        return $intervalos;   
    }

    function procuraSubrede($ip1, $ip2, $ip3, $ip4, $mask){

        $subredes = subredes($ip1, $ip2, $ip3, $ip4, $mask);
        $subrede_do_ip = '';

                foreach ($subredes as $linha) {

                    $intervalo =  explode('-', $linha);

                    

                    $intervalo_ip1 = explode('.', $intervalo[0]);
                    $intervalo_ip2 = explode('.', $intervalo[3]);

            

                    if ($intervalo_ip1[3] <= $ip4 and $intervalo_ip2[3] >= $ip4) {
                        $subrede_do_ip = $linha;

                    }

                }

                return $subrede_do_ip;
                

    }

//Função de segurança

    function secure($ip_1,$ip_2,$ip_3,$ip_4){

        if ( preg_match('/[a-zA-Z]/', $ip_1) or preg_match('/[a-zA-Z]/', $ip_2) or preg_match('/[a-zA-Z]/', $ip_3) or preg_match('/[a-zA-Z]/', $ip_4) or ( $ip_1 < 0 ) or ( $ip_2 < 0 ) or ( $ip_3 < 0 ) or ( $ip_4 < 0 ) or ( $ip_1 > 255 ) or ( $ip_2 > 255 ) or ( $ip_3 > 255 ) or ( $ip_4 > 255 ) ) {

                return 0;


            }else{

                return 1;
            }

    }

?>