<?php
include "proteger.php";
include "conectar.php";

// Pega o ID do filme pela URL (?id=1)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Busca o filme no banco de dados
$sql    = "SELECT * FROM filmes WHERE id = $id";
$result = $conn->query($sql);

// Se não encontrar o filme, redireciona para a home
if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$filme = $result->fetch_assoc();

// Busca o ID do usuário logado
$nome       = $_SESSION['usuario'];
$sql_user   = "SELECT id FROM usuarios WHERE nome = '$nome'";
$res_user   = $conn->query($sql_user);
$usuario    = $res_user->fetch_assoc();
$usuario_id = $usuario['id'];
$filme_id   = $filme['id'];

// Verifica se este filme já está nos favoritos do usuário
$sql_fav  = "SELECT id FROM favoritos WHERE usuario_id = $usuario_id AND filme_id = $filme_id";
$res_fav  = $conn->query($sql_fav);
$favoritado = $res_fav->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($filme['titulo']); ?> - Nityfrix</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Cabeçalho -->
    <header class="menu">
        <h1 class="logo">Nityfrix</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="index.php?tipo=filme">Filmes</a>
            <a href="index.php?tipo=serie">Séries</a>
            <a href="perfil.php">Perfil</a>
        </nav>
    </header>

    <!-- Página de detalhes do filme/série -->
    <main class="detalhe-container">

        <!-- Imagem da capa -->
        <div class="detalhe-capa">
            <img
                src="imagens/<?php echo $filme['imagem']; ?>"
                alt="<?php echo htmlspecialchars($filme['titulo']); ?>"
            >
        </div>

        <!-- Informações do filme -->
        <div class="detalhe-info">
            <h2><?php echo htmlspecialchars($filme['titulo']); ?></h2>

            <div class="detalhe-tags">
                <span class="badge-tipo"><?php echo ucfirst($filme['tipo']); ?></span>
                <span class="ano"><?php echo $filme['ano']; ?></span>
            </div>

            <p class="sinopse"><?php echo htmlspecialchars($filme['sinopse']); ?></p>
            <a 
            href="https://youtu.be/0V4TiaU06uo?si=Jj4yjc1ekEaTr5Bk" 
            target="_blank" 
            class="btn-assistir"
        >
            ▶ Assistir
        </a>

            <!-- Botão de favoritar na página de detalhes -->
            <button
                class="btn-favoritar-detalhe <?php echo $favoritado ? 'favoritado' : ''; ?>"
                id="btn-fav"
                data-id="<?php echo $filme['id']; ?>"
            >
                <span class="icone-coracao">♥</span>
                <span id="texto-fav"><?php echo $favoritado ? 'Favoritado' : 'Favoritar'; ?></span>
            </button>

            <a href="index.php" class="btn-voltar">← Voltar</a>
        </div>

    </main>

    <script>
    // Botão de favoritar na página de detalhes
    document.getElementById('btn-fav').addEventListener('click', function() {
        const filmeId = this.dataset.id;
        const btn     = this;
        const texto   = document.getElementById('texto-fav');

        fetch('favoritar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'filme_id=' + filmeId
        })
        .then(function(r) { return r.text(); })
        .then(function(resultado) {
            if (resultado === 'adicionado') {
                btn.classList.add('favoritado');
                texto.textContent = 'Favoritado';
            } else {
                btn.classList.remove('favoritado');
                texto.textContent = 'Favoritar';
            }
        });
    });
    </script>

</body>
</html>