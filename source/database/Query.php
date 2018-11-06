<?php

require_once("Model.php");

class Query extends Model {

    /**
    * Permite obtener los últimos números 
    * que han caído en la ruleta
 	*
  	* @param String $cantidad : cantidad de numeros generados	
 	* 
 	* @return Array $data: resultado de la operación
    */	
    public function getHistorial($cantidad){
        //Traer los datos
        $select     = "SELECT numero, color FROM historial_apuesta ORDER BY id DESC LIMIT $cantidad";
        $result     = $this->connection->query($select);
        $historial  = mysqli_fetch_all($result, MYSQLI_ASSOC);  
        //Convert to JSON
        $j = 0;
        foreach ($historial as $key => $value) {
            if($value['numero'] == 37){
                $json['numero'][$j] = '00';
            }else{
                $json['numero'][$j] = $value['numero'];
            }
            $json['color'][$j]  = $value['color'];
            $j++;
        }
        //Do return
        return json_encode($json);        
    } 

    /**
    * Permite obtener los números
    * que más veces han caído en la ruleta
 	*
  	* @param String $cantidad : cantidad de numeros generados	
 	* 
 	* @return Array $data: resultado de la operación
    */	
    public function getNumerosCalientes($cantidad){
        //Do query
        $select     = "SELECT num FROM numero ORDER BY (cantidad) DESC LIMIT $cantidad";
        $result     = $this->connection->query($select);
        $calientes  = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //Crete json
        $j = 0;
        foreach ($calientes as $key => $value) {
            $json[$j] = $value['num'];
            $j++;
        }
        //Print json
        return json_encode($json);     
    } 

    /**
    * Permite obtener los números
    * que menos veces han caído en la ruleta
 	*
  	* @param String $cantidad : cantidad de numeros generados	
 	* 
 	* @return Array $data: resultado de la operación
    */	
    public function getNumerosFrios($cantidad){
        //Do query
        $select     = "SELECT num FROM numero ORDER BY (cantidad) ASC LIMIT $cantidad";
        $result     = $this->connection->query($select);
        $calientes  = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //Crete json
        $j = 0;
        foreach ($calientes as $key => $value) {
            $json[$j] = $value['num'];
            $j++;
        }
        //Print json
        return json_encode($json);     
    } 

    /**
    * Permite obtener la cantidad de plata 
    * que cierto usuario tiene en el monedero
 	*
  	* @param String $id : id del usuario implicado
 	* 
 	* @return Array $data: resultado de la operación
    */	
    public function getMonedero($id){
		//Get data
		$select 	= "SELECT billetera FROM usuario WHERE id = '".$id."'";
		$result 	= $this->connection->query($select);
		$plata  	= mysqli_fetch_all($result, MYSQLI_ASSOC);
		$cantidad 	= $plata[0]['billetera'];
        //Print cantidad
		return $cantidad;   
    }     

    /**
    * Guardar el numero ganador en el historial de apuestas
 	*
  	* @param Integer $number : numero ganador
 	* @param String $color : color del numero ganador
    * @param String $tipo : tipo del numero ganador
    *
    */	
    public function setHistorialApuesta($number, $color, $tipo){
		$insert = "INSERT INTO historial_apuesta (numero, color, tipo) VALUES ('$number', '$color', '$tipo')";
		$this->connection->query($insert); 
    }
    
    /**
    * Guardar el numero ganador en la tabla de fichas
 	*
  	* @param Integer $number : numero ganador
 	* @param Integer $id : id del jugador
    *
    */	
    public function setGanadorOnFichas($number, $id){
		$target = 'ganador';
		$update = "UPDATE fichas SET value = $number WHERE target =  '".$target."' AND usuario_id = '".$id."'";
		$this->connection->query($update);
    }    
    
    /**
    * Actualizza la tabla de números calientes
 	*
  	* @param Integer $number : numero ganador
    *
    */	
    public function updateCalientes($number){
		$update = "UPDATE numero SET cantidad = cantidad + 1 WHERE num =  '".$number."'";
		$this->connection->query($update);
    }      

    /**
    * Permite obtener la tabla de fichas
 	*
  	* @param String $id : id del usuario
 	* 
 	* @return Array $data: resultado de la operación
    */	
    public function getFichas($id){
        //Declare query
        $select = "SELECT * FROM fichas WHERE usuario_id = '".$id."'";
        $result = $this->connection->query($select);
        $json   = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //Crete json
        foreach ($json as $key => $value) {
            $data[$value['target']] = $value['value'];
        }
        //Return json
        return $data;
    }

    /**
    * Guardar la actualización en el historial de billetera
 	*
  	* @param Integer $id : id del usuario
 	* @param String $tipo : tipo de actualización
    * @param String $cantidad : cantidad
    *
    */	
    public function setHistorialBilletera($id, $tipo, $cantidad){
		$insert = "INSERT INTO historial_billetera (`usuario_id`, `ingreso`, `cantidad`) VALUES ('$id', '$tipo', '$cantidad')";
        $this->connection->query($insert);
    }

    /**
    * Sumar cierta cantidad a la billetara 
    *
  	* @param Integer $id : id del usuario
    * @param String $cantidad : cantidad
    *
    */	
    public function sumarBilletera($id, $cantidad){
        $update = "UPDATE usuario SET billetera = billetera + $cantidad WHERE id = '".$id."'";
        $this->connection->query($update);
    }

    /**
    * Restar cierta cantidad a la billetara 
    *
  	* @param Integer $id : id del usuario
    * @param String $cantidad : cantidad
    *
    */	
    public function restarBilletera($id, $cantidad){
        $update = "UPDATE usuario SET billetera = billetera - $cantidad WHERE id = '".$id."'";
        $this->connection->query($update);
    }

    /**
    * Resetea la tabla fichas
    *
  	* @param Integer $id : id del usuario
    *
    */	
    public function resetTableFichas($id){
        $update = "UPDATE fichas SET value = 0 WHERE usuario_id = '".$id."'";
        $this->connection->query($update);
    }

}
