<?php
include __DIR__ . '/client_config.php';
if (!isset($_GET['cedula'])) {
    die('Cédula no proporcionada');
}
try {
    $client->EliminarPaciente($_GET['cedula']);
} catch (SoapFault $e) {
    // se ignora el error para redirigir de todos modos
}
header('Location: listar_pacientes.php');
exit;
