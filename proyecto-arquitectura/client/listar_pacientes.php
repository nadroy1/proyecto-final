<?php
include __DIR__ . '/client_config.php';
$pacientes = [];
$error = '';
try {
    $res = $client->ListarTodosLosPacientes();
    if (is_object($res) && isset($res->paciente)) {
        $pacientes = is_array($res->paciente) ? $res->paciente : [$res->paciente];
    } elseif (is_array($res)) {
        $pacientes = $res;
    }
} catch (SoapFault $e) {
    $error = 'Error SOAP: ' . $e->getMessage();
}
include __DIR__ . '/../assets/style_header.php';
?>
<h1>Pacientes</h1>
<a class="btn secondary" href="index.php">Volver al Inicio</a>
<?php if ($error): ?><div class="alert"><?php echo $error; ?></div><?php endif; ?>
<table class="table">
  <thead><tr><th>Cédula</th><th>Nombre</th><th>Apellido</th><th>Teléfono</th><th>Email</th><th>Acciones</th></tr></thead>
  <tbody>
  <?php foreach ($pacientes as $p): $p = (array)$p; ?>
    <tr>
      <td><?php echo htmlspecialchars($p['cedula']); ?></td>
      <td><?php echo htmlspecialchars($p['nombre']); ?></td>
      <td><?php echo htmlspecialchars($p['apellido']); ?></td>
      <td><?php echo htmlspecialchars($p['telefono']); ?></td>
      <td><?php echo htmlspecialchars($p['email']); ?></td>
      <td>
        <a class="link" href="editar_paciente.php?cedula=<?php echo urlencode($p['cedula']); ?>">Editar</a>
        <button class="link danger" onclick="confirmarEliminar('<?php echo htmlspecialchars($p['cedula']); ?>')">Eliminar</button>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<script src="../assets/main.js"></script>
<?php include __DIR__ . '/../assets/style_footer.php'; ?>
