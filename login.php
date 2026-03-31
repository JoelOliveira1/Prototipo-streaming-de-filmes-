<?php
session_start();
include "conectar.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if($result->num_rows > 0){

    $usuario = $result->fetch_assoc();

    if(password_verify($senha, $usuario['senha'])){

        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['usuario_id'] = $usuario['id'];

        header("Location: index.php");
        exit();

    } else {

        header("Location: login.html?erro=senha");
        exit();

    }

}else{

    header("Location: login.html?erro=usuario");
    exit();

}

?>