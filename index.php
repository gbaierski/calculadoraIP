<!DOCTYPE html>
<html lang="en">
<head>
	<title>Calculadora IP</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="images/icons/icon.ico" />
<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--===============================================================================================-->
	<?php include "php/funcoes.php" ?>

</head>
<body>


	<?php

		$ip = '';
		$qtd_redes = '';
		$broadcast = '';
		$qtd_end = '';
		$qtd_hosts = '';
		$ipF = '';
		$ph = '';
		$uh = '';
		$ipL = '';
		$maskDec = '';
		$classe = '';
		$privacidade = '';

		
	?>


	<div class="container-contact100" style="background-image: url('images/calculo.jpg');">

		<div class="wrap-contact100">


			<div class="contact100-form validate-form branco">
				<span class="contact100-form-title">
					Calculadora IP
				</span>

				<div class="label-input100 subtitle">Insira seu endereço IP e sua máscara:</div>


				<div class="clear"></div>
				

	<!--=============================== Início do Form =====================================-->

				<form action="" method="post">

				<div class="wrap-input100 rs1-wrap-input100  div_ip " id="ip_1_div">
					<input id="ip_1" class="input100" type="text" name="ip_1" maxlength='3' required>
					<span class="focus-input100 input_ip"></span>
				</div>
   	
				<div class="wrap-input100 rs1-wrap-input100  div_ip ">
					<input id="ip_2" class="input100" type="text" name="ip_2" maxlength='3' required>
					<span class="focus-input100 input_ip"></span>
				</div>

				<div class="wrap-input100 rs1-wrap-input100  div_ip ">
					<input id="ip_3" class="input100" type="text" name="ip_3" maxlength='3' required>
					<span class="focus-input100 input_ip"></span>
				</div>

				<div class="wrap-input100 rs1-wrap-input100  div_ip ">
					<input id="ip_4" class="input100" type="text" name="ip_4" maxlength='3' required>
					<span class="focus-input100 input_ip"></span>
				</div>

				
				
				
				<select class="wrap-input100 rs1-wrap-input100  div_ip " name="mask" id="mask" required>
					<option value="24">/24</option>
					<option value="25">/25</option>
					<option value="26">/26</option>
					<option value="27">/27</option>
					<option value="28">/28</option>
					<option value="29">/29</option>
					<option value="30">/30</option>
					<option value="31">/31</option>
					<option value="32">/32</option>
				</select>




				<div class="container-contact100-form-btn">
					<input type="submit" name="calcular" id="calcular" class="contact100-form-btn" value="calcular">
				</div>

				<input type="hidden" name="action" value="calcula">

				</form>

				<p id="creditos">  Gustavo Baierski & Daniela Buzzi </p>
				<p id="turma_ano"> 3info1 - 2019 </p>
			</div>


			<div class="resultados_section">


				 <h2 id="resultados_title">Resultados:</h2>

				 <div class="result" id="result">

					
		<?php

		if(@$_POST['action'] == 'calcula'){ 

			$ip_1 = $_POST["ip_1"];
    		$ip_2 = $_POST["ip_2"];
			$ip_3 = $_POST["ip_3"];
			$ip_4 = $_POST["ip_4"];
			$mascara = $_POST["mask"];

			$validacao = secure($ip_1,$ip_2,$ip_3,$ip_4);

			 if ($validacao == 1) {

        if ($ip_1 != NULL and $ip_2 != NULL and $ip_3 != NULL and $ip_4 != NULL and $mascara != NULL){

            
            $ip = ipv4($ip_1,$ip_2,$ip_3,$ip_4);
            $qtd_redes = quantidade_subredes($mascara);
            $broadcast = broadcast($ip_1, $ip_2, $ip_3, $ip_4, $mascara);
            $qtd_end = quantidade_enderecos($mascara);
            $qtd_hosts = quantidade_hosts($mascara);
            $ipF = ipv4_FL($ip_1,$ip_2,$ip_3);
            $ph = primeiro_host($mascara);
            $uh = ultimo_host($mascara);
            $ipL = ipv4_FL($ip_1,$ip_2,$ip_3);
            $maskDec = calculo_mask($ip_4,$mascara);
            $classe = define_classe($ip_1);
            $privacidade = calc_privacidade($ip_1, $ip_2);
            

          ?>

    <div class='resultados' style="font-size: 25px;"><?=$ip?></div> 

	<br><div class="clear"></div>

	<div class='resultados'>Quantidade de sub-redes:<?=" ".$qtd_redes?> </div>

	

	<div class='resultados'>Quantidade de endereços: <?=" ".$qtd_end?> </div>

	<div class="clear"></div>

	<div class='resultados'>Número de Hosts:<?=" ".$qtd_hosts?> </div>

	<div class="clear"></div>

	<div class='resultados'>Máscara Decimal:<?=" ".$maskDec?>  </div>

	<div class="clear"></div>

	<div class='resultados'>Classe:<?=" ".$classe?>  </div>

	<div class="clear"></div>

	<div class='resultados'>Privacidade:<?=" ".$privacidade?> </div>

          <?php

        }else{
            echo "<h1 class='error'>Preencha todos os campos</h1>";
        }

    }else{
           echo "<h1 class='error'>Informe um endereço de IP válido</h1>";
    }
}



		?>					
				
				 </div>

 			</div> 

		</div>

		<div style="width: 80%; text-align: center; background-color: #333333; margin-top: 20px; color: white">

			
			
			<?php 

			@$validacao = secure($ip_1,$ip_2,$ip_3,$ip_4);
			
			if(@$_POST['action'] == 'calcula' and $ip_1 != NULL and $ip_2 != NULL and $ip_3 != NULL and $ip_4 != NULL and $mascara != NULL and $validacao == 1){

				echo "<h2 id='resultados_title'>Intervalos das sub-redes:</h2><br><div class='resultados'>Seu endereço está no intervalo: </div>";


				$subrede = procuraSubrede($ip_1, $ip_2, $ip_3, $ip_4, $mascara);
				echo $subrede."<br>";



				$subredes = subredes($ip_1, $ip_2, $ip_3, $ip_4, $mascara);
				foreach ($subredes as $linha) {
					echo "$linha";
				}
			}

			?>
		</div>

	</div>

</body>
</html>
