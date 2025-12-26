<!-- ============================================ -->
<!-- logout.php - Cerrar sesión -->
<!-- ============================================ -->
<?php
// logout.php
session_start();
session_destroy();
header('Location: ../index.php');
exit;
?>