<?php
include "proteger.php";
include "conectar.php";

$nome = $_SESSION['usuario'];

// Busca os dados do usuário
$sql_user = "SELECT * FROM usuarios WHERE nome = '$nome'";
$res_user = $conn->query($sql_user);
$usuario  = $res_user->fetch_assoc();

// Busca os filmes favoritados pelo usuário
// O JOIN combina as tabelas favoritos e filmes
$sql_favoritos = "
    SELECT f.*
    FROM filmes f
    INNER JOIN favoritos fav ON fav.filme_id = f.id
    WHERE fav.usuario_id = {$usuario['id']}
    ORDER BY f.tipo, f.titulo
";
$favoritos = $conn->query($sql_favoritos);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Nityfrix</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Cabeçalho -->
    <header class="menu">
        <h1 class="logo">Nityfrix</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href ="upgrade.php">Vire Premium</a>
            <a href="index.php?tipo=filme">Filmes</a>
            <a href="index.php?tipo=serie">Séries</a>
            <a href="perfil.php">Perfil</a>
        </nav>
    </header>

    <main class="perfil-pagina">

        <!-- Informações do usuário -->
        <section class="perfil-container">
            <h2>Perfil do Usuário</h2>

            <div class="perfil-dados">
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
                <p><strong>Categoria:</strong> <?php echo htmlspecialchars($usuario['categoria']); ?></p>
            </div>

            <form action="logout.php" method="POST">
                <button class="btn-logout" type="submit">Sair da Conta</button>
            </form>
        </section>

        <!-- Lista de favoritos do usuário -->
        <section class="favoritos-secao">
            <h3>Minha Lista ♥</h3>

            <?php if ($favoritos->num_rows === 0): ?>
                <p class="sem-favoritos">Você ainda não favoritou nenhum título. <a href="index.php">Explorar títulos</a></p>

            <?php else: ?>
                <div class="container-filmes">
                    <?php while ($filme = $favoritos->fetch_assoc()): ?>

                        <article class="box-filme">
                            <a href="filme.php?id=<?php echo $filme['id']; ?>" class="link-filme">
                                <img
                                    src="imagens/<?php echo $filme['imagem']; ?>"
                                    alt="<?php echo htmlspecialchars($filme['titulo']); ?>"
                                    class="capa-filme"
                                >
                                <div class="info-filme">
                                    <h4><?php echo htmlspecialchars($filme['titulo']); ?></h4>
                                    <span class="badge-tipo"><?php echo ucfirst($filme['tipo']); ?></span>
                                    <span class="ano"><?php echo $filme['ano']; ?></span>
                                </div>
                            </a>

                            <!-- Coração já preenchido pois está favoritado -->
                            <button
                                class="btn-favoritar favoritado"
                                data-id="<?php echo $filme['id']; ?>"
                                title="Remover dos favoritos"
                            >
                                ♥
                            </button>
                        </article>

                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <script>
    // Remove favorito diretamente da lista do perfil
    document.querySelectorAll('.btn-favoritar').forEach(function(botao) {
        botao.addEventListener('click', function() {
            const filmeId = this.dataset.id;
            const card    = this.closest('.box-filme');

            fetch('favoritar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'filme_id=' + filmeId
            })
            .then(function(r) { return r.text(); })
            .then(function(resultado) {
                if (resultado === 'removido') {
                    // Remove o card da tela com animação
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(function() { card.remove(); }, 300);
                }
            });
        });
    });
    </script>

</body>
</html>