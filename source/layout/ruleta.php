<?php

    //Main

    //Requere
    require_once("database/Query.php");

    //Init variables
	session_start();
	$id 				= $_SESSION['id'];

    //Call girar
    $url    	= getUrlBase()."source/apis/apiGirar.php?id=$id";
    $client 	= curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	= curl_exec($client);	
	$result 	= json_decode($response);
    $ganador    = $result->data; 

    //Premio
    //Analizar premio números
    $url    	    = getUrlBase()."source/apis/apiNumero.php?id=$id";
    $client 	    = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	    = curl_exec($client);	
	$result 	    = json_decode($response);
    $premioNumero   = $result->data->cantidadPago; 
    $apuestaNumero  = $result->data->cantidadApostada;


    //Analizar premio por tipo
    $url    	    = getUrlBase()."source/apis/apiTipo.php?id=$id";
    $client 	    = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	    = curl_exec($client);	
	$result 	    = json_decode($response);
    $premioTipo     = $result->data->cantidadPago; 
    $apuestaTIpo    = $result->data->cantidadApostada;

    //Analizar premio por color
    $url    	    = getUrlBase()."source/apis/apiColor.php?id=$id";
    $client 	    = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	    = curl_exec($client);	
	$result 	    = json_decode($response);
    $premioColor    = $result->data->cantidadPago;      
    $apuestaColor   = $result->data->cantidadApostada;

    //Analizar premio por fila
    $url    	    = getUrlBase()."source/apis/apiFilas.php?id=$id";
    $client 	    = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	    = curl_exec($client);	
	$result 	    = json_decode($response);
    $premioFilas    = $result->data->cantidadPago;
    $apuestaFilas   = $result->data->cantidadApostada;

    //Analizar premio por docena
    $url    	        = getUrlBase()."source/apis/apiDocenas.php?id=$id";
    $client 	        = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	        = curl_exec($client);	
	$result 	        = json_decode($response);
    $premioDocenas      = $result->data->cantidadPago;     
    $apuestaDocenas     = $result->data->cantidadApostada;

    //Analizar premio por mitad
    $url    	    = getUrlBase()."source/apis/apiMitad.php?id=$id";
    $client 	    = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	    = curl_exec($client);	
	$result 	    = json_decode($response);
    $premioMitad    = $result->data->cantidadPago;      
    $apuestaMitad   = $result->data->cantidadApostada;

    //Resetar tabla fichas
    $Query = new Query();
    $Query->resetTableFichas($id);

    //Calcular total
    $premioTotal = $premioNumero + $premioTipo + $premioColor + $premioFilas + $premioDocenas + $premioMitad;
    $apuestaTotal = $apuestaNumero + $apuestaTipo + $apuestaColor + $apuestaFilas + $apuestaDocenas + $apuestaMitad;
    
    //Actualizar la billetera
    $url    	    = getUrlBase()."source/apis/apiActualizarBilletera.php?id=$id&cantidadApostada=$apuestaTotal&cantidadPago=$premioTotal";
    $client 	    = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	    = curl_exec($client);	
	$result 	    = json_decode($response);
    $response       = $result->data;     
    
?>
<div class="wrapper">
		<div class="container">
			<div class="row around-xs">
				<div class="col-xs-12">
					<!-- Roulette -->
					<div class="roulette">
						<img id="wheel" src="assets/wheel.svg" />
						<img id="bola" src="assets/bola.svg" />
					</div>
				</div>
				<div class="col-xs-12">
					<!-- Mesagge and button -->
					<div class="roulette_data top-2">
						<h1 id="statusRoulette" class="white-text">Cargando...</h1>					
						<a id="backButtonRoulette" class="button button-highlight button-giant">Volver a jugar</a>
					</div>
				</div>
			</div>
	    </div>
	</div>

    
    <script>

    //Numero ganador
    var winner = <?php echo $ganador ?>;

    //Win? 
    var win = <?php echo $premioTotal ?>;

    //Only if page has fully loaded
    window.onload = function () {    

        //Get shit
        var wheel       = document.getElementById('wheel');
        var bola        = document.getElementById('bola');
        var number      = winner;
        var arreglo     = [37,1,13,36,24,3,15,34,22,5,17,32,20,7,11,30,26,9,28,0,2,14,35,23,4,16,33,21,6,18,31,19,8,12,29,25,10,27];
        var multiplo    = 180/38;
        var grados      = multiplo * arreglo.indexOf(number) + 360 * aleatorio(5,10);

        if(arreglo.indexOf(number) != -1){
            spinRoulette(grados);
            spinBola(grados);

            $("#wheel").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
            function(event) {
                //Cambiar esta línea para chequear si el usuario ganó
                if(win>0){
                    $("#statusRoulette").text("¡Ganaste $" + win + "!");   
                }else{
                    $("#statusRoulette").text("Perdiste");
                }
            });
        }

        function spinRoulette(deg) {
            wheel.removeAttribute('style');
            css = '-webkit-transform: rotate(' + deg + 'deg);';
            wheel.setAttribute(
                'style', css
            );
        }

        function spinBola(deg) {
            bola.removeAttribute('style');
            var deg = deg * (-1);    
            var css = '-webkit-transform: rotate(' + deg + 'deg);';
            bola.setAttribute(
                'style', css
            );  
        }

    }
    </script>



	<script>
	$(document).ready(function(){
		$('#backButtonRoulette').click(function() {
			window.location.href = '/';
		});
	});
	</script>

