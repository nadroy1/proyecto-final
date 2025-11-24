<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/PacienteLogic.php';

$wsdl = __DIR__ . '/../pacientes.wsdl';
$options = [
    'uri' => 'http://example.org/pacientes',
    'trace' => true,
];

$server = new SoapServer($wsdl, $options);
$server->setClass('PacienteLogic');
$server->handle();
