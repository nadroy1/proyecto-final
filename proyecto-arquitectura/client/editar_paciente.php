<?php
include __DIR__ . '/client_config.php';
$mensaje = '';
$paciente = null;

if (!isset($_GET['cedula'])) {
    die('Cédula no proporcionada');
}
$cedula = $_GET['cedula'];

try {
    $paciente = $client->BuscarPacientePorCedula($cedula);
    if ($paciente) {
        $paciente = (array)$paciente;
    } else {
        $mensaje = 'No se encontró el paciente';
    }
} catch (SoapFault $e) {
    $mensaje = 'Error SOAP: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $ok = $client->ModificarPaciente(
            $cedula,
            $_POST['nombre'],
            $_POST['apellido'],
            $_POST['telefono'],
            $_POST['email']
        );
        $mensaje = $ok ? 'Paciente actualizado' : 'No se pudo actualizar';
    } catch (SoapFault $e) {
        $mensaje = 'Error SOAP: ' . $e->getMessage();
    }
}

include __DIR__ . '/../assets/style_header.php';
?>
<h1>Editar Paciente</h1>
<?php if ($mensaje): ?><div class="alert"><?php echo $mensaje; ?></div><?php endif; ?>
<?php if ($paciente): ?>
<form method="post" class="form">
  <label>Cédula (no editable) <input value="<?php echo htmlspecialchars($paciente['cedula']); ?>" disabled></label>
  <label>Nombre <input name="nombre" value="<?php echo htmlspecialchars($paciente['nombre']); ?>" required></label>
  <label>Apellido <input name="apellido" value="<?php echo htmlspecialchars($paciente['apellido']); ?>" required></label>
  <label>Teléfono <input name="telefono" value="<?php echo htmlspecialchars($paciente['telefono']); ?>" required></label>
  <label>Email <input name="email" type="email" value="<?php echo htmlspecialchars($paciente['email']); ?>" required></label>
  <button class="btn" type="submit">Guardar Cambios</button>
  <a class="btn secondary" href="index.php">Volver al Inicio</a>
</form>
<?php endif; ?>
<?php include __DIR__ . '/../assets/style_footer.php'; ?>
