<?php
$host    = "sql306.infinityfree.com";     // Database Hostname do painel
$usuario = "if0_41557948";               // Username da conta
$senha   = "Dick5920";         // Senha da conta de hospedagem
$banco   = "if0_41557948_nityfrix";      // Nome completo do banco, com prefixo

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>