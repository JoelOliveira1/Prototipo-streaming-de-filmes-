<?php
include "conectar.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha)
VALUES ('$nome','$email','$senhaHash')";

if($conn->query($sql) === TRUE){
    echo "Cadastro realizado com sucesso";
}else{
    echo "Erro: " . $conn->error;
}

?>