<?php
	require_once('SistemaFCE/util/Configuracion.class.php');

	SistemaFCE::initSistema();
	require_once dirname(__DIR__).'/vendor/autoload.php';
	SistemaFCE::ejecutarSistema();