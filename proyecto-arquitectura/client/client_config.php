<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$wsdl = 'http://localhost/proyecto-arquitectura/pacientes.wsdl'; // ajusta si mueves a htdocs
try {
    $client = new SoapClient($wsdl, ['trace' => true]);
} catch (SoapFault $e) {
    die('No se pudo conectar al servicio: ' . $e->getMessage());
}
