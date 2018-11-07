<?php

    //Init variables
	session_start();
	$id 				= $_SESSION['id'];
	$cantidadFrios 	    = 5;
	$cantidadCalientes  = 5;
	$cantidadHistorial  = 10;

	//Monedero
	$client = new SoapClient('http://localhost/source/server/setMonedero.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
	$monedero = $client->setMonedero($id);


	//Historial
	$url    	= getUrlBase()."source/apis/apiHistorial.php?cantidad=$cantidadHistorial";
    $client 	= curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	$response 	= curl_exec($client);	
	$result 	= json_decode($response);
	$historial  = $result->data; 


	//Números calientes
	$client = new SoapClient('http://localhost/source/server/setCalientes.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
	$calientes = $client->setCalientes($cantidadCalientes);
    $calientes = json_decode($calientes);

	//Números fríos
	
	$client = new SoapClient('http://localhost/source/server/setFrios.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
	$frios = $client->setFrios($cantidadCalientes);
	$frios = json_decode($frios);

?>
<script>


$(document).ready(function(){

	var sessionId = "<?php echo $_SESSION['id']; ?>";

    //Contar apuestas
    //Touch chip
    $('.chip').click(function() {
        
        //Get id
        var value = $(this).attr('id');
        
        //Change cursor
        $("#layout").css({ 'cursor': "url('assets/chips/cursors/"+value+".svg'), auto" });
        
        //Touch target
        $('.target').unbind().click(function() {

            //Get data of target
            var bet      = $(this).attr('id');
            var position = $(this).offset();
            var top      = position.top;
            var left     = position.left;
            var addTop   = aleatorio(0,30);
            var addLeft   = aleatorio(0,16);

            //Create and put chips
            var chip                    = document.createElement('img');
            chip.src                    = "assets/chips/mini/"+value+".svg";
            chip.style.position         = "absolute";
            chip.style.pointerEvents    = "none"; //Esto es muy importante
            chip.style.top              = top  + addTop  + "px";
            chip.style.left             = left + addLeft + "px";
        
            //Apostar
            var kross = {
                target : bet,
                plata  : value
            };
            $.ajax({
                type: "post",
                data : {
                     kriss : kross
                },
                dataType: "json",
				async: false,
                url: "source/server/guardarApuesta.php",
				success: function (response) {
					if(response){
						//Monedero
						$.ajax({
						  type: "post",
						  url: "source/apis/apiMonedero.php?id=<?php echo $_SESSION['id'] ?>",
						  async: true,
						  dataType: 'json',
						  async: false,
						  success: function (response) {
							document.body.appendChild(chip);
							$("#monedero").text("$" + response["data"]);
						  }
						});
					}else{
						alert("No tienes dinero suficiente para realizar esta apuesta");
					}
				}
            });
            
        });
    });
	
	//Bet
    $('#betButton').click(function() {
        window.location.href = "/result.php";
    });

});

</script>

<div class="wrapper">
		<div class="container">

			<div class="number center-xs row" id="layout">

			<div class="bottom-3 col-xs-12 row around-xs center-xs">
			<div class="col-xs-1">	
				</div>
					<div class="col-xs-7">	
						<h3>Historial</h3>
						<div class="group-box-numbers group-box-numbers-history">	
							<div><span class="<?php echo $historial->color[0] ?>" id="historial-1"><?php echo $historial->numero[0] ?></span></div>
							<div><span class="<?php echo $historial->color[1] ?>" id="historial-2"><?php echo $historial->numero[1] ?></span></div>
							<div><span class="<?php echo $historial->color[2] ?>" id="historial-3"><?php echo $historial->numero[2] ?></span></div>
							<div><span class="<?php echo $historial->color[3] ?>" id="historial-4"><?php echo $historial->numero[3] ?></span></div>
							<div><span class="<?php echo $historial->color[4] ?>" id="historial-5"><?php echo $historial->numero[4] ?></span></div>
						    <div><span class="<?php echo $historial->color[5] ?>" id="historial-6"><?php echo $historial->numero[5] ?></span></div>
							<div><span class="<?php echo $historial->color[6] ?>" id="historial-7"><?php echo $historial->numero[6] ?></span></div>
							<div><span class="<?php echo $historial->color[7] ?>" id="historial-8"><?php echo $historial->numero[7] ?></span></div>
							<div><span class="<?php echo $historial->color[8] ?>" id="historial-9"><?php echo $historial->numero[8] ?></span></div>
						</div>
					</div>

				<div class="col-xs-1">	
					<h3>Monedero</h3>
						<div class="golden-box row middle-xs">
    						<div class="col-xs">
        						<div class="box">
									<h3 class="golden" id="monedero"><?php echo "$".$monedero ?></h3>
        						</div>
    					</div>
					</div>
				</div>
				<div class="col-xs-1">	
				</div>
			</div>	


			<!-- ceros -->
			<div class="number col-xs-1">
				<div class="row center-xs">
					<div class="target col-xs-offset-6 col-xs-6 green vertical_text" id="37">00</div>
				</div>
				<div class="row center-xs">
					<div class="target col-xs-offset-6 col-xs-6 green vertical_text" id="0">0</div>
				</div>
			</div>
			
			<!-- nums -->
			<div class="number col-xs-10">
				<div class="row">
					<div class="target col-xs-1 red" id="3">3</div>
					<div class="target col-xs-1 black" id="6">6</div>
					<div class="target col-xs-1 red" id="9">9</div>
					<div class="target col-xs-1 red" id="12">12</div>
					<div class="target col-xs-1 black" id="15">15</div>
					<div class="target col-xs-1 red" id="18">18</div>
					<div class="target col-xs-1 red" id="21">21</div>
					<div class="target col-xs-1 black" id="24">24</div>
					<div class="target col-xs-1 red" id="27">27</div>
					<div class="target col-xs-1 red" id="30">30</div>
					<div class="target col-xs-1 black" id="33">33</div>
					<div class="target col-xs-1 red" id="36">36</div>
				</div>
				<div class="row">
					<div class="target col-xs-1 black" id="2">2</div>
					<div class="target col-xs-1 red" id="5">5</div>
					<div class="target col-xs-1 black" id="8">8</div>
					<div class="target col-xs-1 black" id="11">11</div>
					<div class="target col-xs-1 red" id="14">14</div>
					<div class="target col-xs-1 black" id="17">17</div>
					<div class="target col-xs-1 black" id="20">20</div>
					<div class="target col-xs-1 red" id="23">23</div>
					<div class="target col-xs-1 black" id="26">26</div>
					<div class="target col-xs-1 black" id="29">29</div>
					<div class="target col-xs-1 red" id="32">32</div>
					<div class="target col-xs-1 black" id="35">35</div>
				</div>
				<div class="row">
					<div class="target col-xs-1 red" id="1">1</div>
					<div class="target col-xs-1 black" id="4">4</div>
					<div class="target col-xs-1 red" id="7">7</div>
					<div class="target col-xs-1 black" id="10">10</div>
					<div class="target col-xs-1 black" id="13">13</div>
					<div class="target col-xs-1 red" id="16">16</div>
					<div class="target col-xs-1 red" id="19">19</div>
					<div class="target col-xs-1 black" id="22">22</div>
					<div class="target col-xs-1 red" id="25">25</div>
					<div class="target col-xs-1 black" id="28">28</div>
					<div class="target col-xs-1 black" id="31">31</div>
					<div class="target col-xs-1 red" id="34">34</div>
				</div>
				<div class="row">
					<div class="target green col-xs-4" id="1st12">1st 12</div>
					<div class="target green col-xs-4" id="2nd12">2nd 12</div>
					<div class="target green col-xs-4" id="3rd12">3rd 12</div>
				</div>
				<div class="row">
						<div class="target green col-xs-2" id="1to18">1-18</div>
						<div class="target green col-xs-2" id="par">PAR</div>
						<div class="target red col-xs-2" id="red"></div>
						<div class="target black col-xs-2" id="black"></div>
						<div class="target green col-xs-2" id="impar">IMPAR</div>
						<div class="target green col-xs-2" id="19to36">19-36</div>						
				</div>			
			</div>

			<!-- 2:1 -->
			<div class="number col-xs-1">
				<div class="row">
					<div class="target col-xs-6 green vertical_text" id="2to1_1">2:1</div>
				</div>
				<div class="row">
					<div class="target col-xs-6 green vertical_text" id="2to1_2">2:1</div>
				</div>
				<div class="row">
					<div class="target col-xs-6 green vertical_text" id="2to1_3">2:1</div>
				</div>
			</div>

			<!-- Hot and cold numbers -->
				<div class="col-xs-10 row around-xs center-xs">
					<div class="col-xs">	
						<h3>Números calientes</h3>
						<div class="group-box-numbers group-box-numbers-hot">	
							<div><span class="hot" id="hot-1"><?php echo $calientes[0] ?></span></div>
							<div><span class="hot" id="hot-2"><?php echo $calientes[1] ?></span></div>
							<div><span class="hot" id="hot-3"><?php echo $calientes[2] ?></span></div>
							<div><span class="hot" id="hot-4"><?php echo $calientes[3] ?></span></div>
							<div><span class="hot" id="hot-5"><?php echo $calientes[4] ?></span></div>
						</div>
					</div>				
					<div class="col-xs">
						<h3>Números frios</h3>
						<div class="group-box-numbers group-box-numbers-cold">	
							<div><span class="cold" id="cold-1"><?php echo $frios[0] ?></span></div>
							<div><span class="cold" id="cold-2"><?php echo $frios[1] ?></span></div>
							<div><span class="cold" id="cold-3"><?php echo $frios[2] ?></span></div>
							<div><span class="cold" id="cold-4"><?php echo $frios[3] ?></span></div>
							<div><span class="cold" id="cold-5"><?php echo $frios[4] ?></span></div>
						</div>
					</div>
				</div>			
			
			<!-- Chips -->
			<div class="top-3 center-xs row around-xs">
				<div class="col-xs">
					<img class="chip" id="100" src="assets/chips/images/100.svg" />
				</div>
				<div class="col-xs">
					<img class="chip" id="500" src="assets/chips/images/500.svg" />
				</div>
				<div class="col-xs">			
					<img class="chip" id="1000" src="assets/chips/images/1000.svg" />
				</div>
				<div class="col-xs">			
					<img class="chip" id="5000" src="assets/chips/images/5000.svg" />
				</div>
				<div class="col-xs">			
					<img class="chip" id="10000" src="assets/chips/images/10000.svg" />
				</div>				
			</div>


			<!-- Button -->
			<div class="center-xs row around-xs col-xs-12">
				<div class="col-xs">
					<a id="betButton" class="button button-highlight button-giant">Girar</a>
				</div>
			</div>
			
			
			</div>

		</div>
</div>
