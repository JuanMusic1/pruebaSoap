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
    $client=new SoapClient('http://localhost/source/server/setNumero.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
    $resp=$client->Generar($id);
    $resp=json_decode($resp);
    $premioNumero    = $resp->cantidadPago;
    $apuestaNumero   = $resp->cantidadApostada;


    //Analizar premio por tipo
    $client=new SoapClient('http://localhost/source/server/setTipo.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
    $resp=$client->Generar($id);
    $resp=json_decode($resp);
    $premioTipo    = $resp->cantidadPago;
    $apuestaTipo   = $resp->cantidadApostada;


    //Analizar premio por color
    $client=new SoapClient('http://localhost/source/server/setColor.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
    $resp=$client->Generar($id);
    $resp=json_decode($resp);
    $premioColor    = $resp->cantidadPago;
    $apuestaColor   = $resp->cantidadApostada;

    //Analizar premio por fila
  
    $client=new SoapClient('http://localhost/source/server/setFilas.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
    $resp=$client->Generar($id);
    $resp=json_decode($resp);
    $premioFilas    = $resp->cantidadPago;
    $apuestaFilas   = $resp->cantidadApostada;

    //Analizar premio por docena
    $client=new SoapClient('http://localhost/source/server/setDocenas.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
    $resp=$client->Generar($id);
    $resp=json_decode($resp);
    $premioDocenas    = $resp->cantidadPago;
    $apuestaDocenas   = $resp->cantidadApostada;

    //Analizar premio por mitad
    $client=new SoapClient('http://localhost/source/server/setMitad.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
    $resp=$client->Generar($id);
    $resp=json_decode($resp);
    $premioMitad    = $resp->cantidadPago;
    $apuestaMitad   = $resp->cantidadApostada;

    //Resetar tabla fichas
    $Query = new Query();
    $Query->resetTableFichas($id);

    //Calcular total
    $premioTotal = $premioNumero + $premioTipo + $premioColor + $premioFilas + $premioDocenas + $premioMitad;
    $apuestaTotal = $apuestaNumero + $apuestaTipo + $apuestaColor + $apuestaFilas + $apuestaDocenas + $apuestaMitad;
    
    //Actualizar la billetera
    $client = new SoapClient('http://localhost/source/server/setActualizarBilletera.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
    $resp = $client->Generar($apuestaTotal, $premioTotal, $id);
    $resp=json_decode($resp);
    
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

