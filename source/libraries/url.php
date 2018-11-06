<?php

/**
 * Permite conocer el nombre del server actual
 *
 * @return String $dominio : dominio actual
 */
function getUrlBase() {
	return $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."/";
}