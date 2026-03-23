<?php
include "proteger.php";
include "conectar.php";

$nome = $_SESSION['usuario'];

$sql = "SELECT * FROM usuarios WHERE nome='$nome'";
$result = $conn->query($sql);

$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Perfil</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header class="menu">
<h1>Nityfrix</h1>

<nav>
<a href="index.php">Início</a>
<a href="#">Filmes</a>
<a href="#">Séries</a>
<a href="#">Minha Lista</a>
<a href="perfil.php">Perfil</a>
<a href="logout.php"class= "Logout">Sair</a>
</nav>

</header>


<div class="perfil-container">

<h2>Perfil do usuário</h2>

<p><strong>Nome:</strong> <?php echo $usuario['nome']; ?></p>

<p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>

</div>

</body>
</html>