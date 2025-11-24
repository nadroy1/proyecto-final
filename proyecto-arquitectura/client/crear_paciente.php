<?php
include __DIR__ . '/client_config.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $ok = $client->RegistrarPaciente(
            $_POST['cedula'],
            $_POST['nombre'],
            $_POST['apellido'],
            $_POST['telefono'],
            $_POST['email']
        );
        $mensaje = $ok ? 'Paciente registrado' : 'La cédula ya existe o error al registrar';
    } catch (SoapFault $e) {
        $mensaje = 'Error SOAP: ' . $e->getMessage();
    }
}
include __DIR__ . '/../assets/style_header.php';
?>
<h1>Registrar Paciente</h1>
<?php if ($mensaje): ?><div class="alert"><?php echo $mensaje; ?></div><?php endif; ?>
<form method="post" class="form">
  <label>Cédula <input name="cedula" required></label>
  <label>Nombre <input name="nombre" required></label>
  <label>Apellido <input name="apellido" required></label>
  <label>Teléfono <input name="telefono" required></label>
  <label>Email <input name="email" type="email" required></label>
  <button class="btn" type="submit">Guardar</button>
  <a class="btn secondary" href="index.php">Volver al Inicio</a>
</form>
<?php include __DIR__ . '/../assets/style_footer.php'; ?>
