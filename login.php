<?php
include "conectar.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if($result->num_rows > 0){

    $usuario = $result->fetch_assoc();

    if(password_verify($senha, $usuario['senha'])){
        echo "Login correto";
    } else {
        echo "Senha incorreta";
    }

}else{
    echo "Usuário não encontrado";
}

?>