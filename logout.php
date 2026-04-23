<?php
session_start();
session_destroy();
session_start(); // Inicia uma nova só para a mensagem de tchau
$_SESSION['mensagem'] = "Você saiu do sistema.";
$_SESSION['tipo_mensagem'] = "info";
header('Location: index.php');
exit;