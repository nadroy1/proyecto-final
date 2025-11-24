function confirmarEliminar(cedula) {
  if (confirm('¿Seguro que deseas eliminar este paciente?')) {
    window.location.href = 'eliminar_paciente.php?cedula=' + encodeURIComponent(cedula);
  }
}
