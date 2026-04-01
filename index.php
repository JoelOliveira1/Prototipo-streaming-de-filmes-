<?php
include "proteger.php";
include "conectar.php";


// Busca o ID do usuário logado
$nome = $_SESSION['usuario'];
$sql_usuario = "SELECT id FROM usuarios WHERE nome = '$nome'";
$resultado   = $conn->query($sql_usuario);
$usuario     = $resultado->fetch_assoc();
$usuario_id  = $usuario['id'];

// Busca todos os filmes e séries do banco
$sql_filmes = "SELECT * FROM filmes ORDER BY tipo, titulo";
$filmes     = $conn->query($sql_filmes);

// Busca os IDs dos filmes que o usuário favoritou
$sql_favoritos = "SELECT filme_id FROM favoritos WHERE usuario_id = $usuario_id";
$res_fav       = $conn->query($sql_favoritos);
$favoritos_ids = [];
while ($fav = $res_fav->fetch_assoc()) {
    $favoritos_ids[] = $fav['filme_id'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nityfrix</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Cabeçalho com menu de navegação -->
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

    <!-- Mensagem de boas-vindas -->
    <section class="boas-vindas">
        <h2>Boas-vindas, <?php echo htmlspecialchars($nome); ?>!</h2>
        <p>Escolha um título para começar a assistir.</p>
    </section>

    <!-- Filtro por tipo (filmes ou séries) -->
    <?php
    // Verifica se há filtro ativo na URL 
    $filtro = isset($_GET['tipo']) ? $_GET['tipo'] : '';

    // Monta a query com ou sem filtro
    if ($filtro === 'filme' || $filtro === 'serie') {
        $sql_filmes = "SELECT * FROM filmes WHERE tipo = '$filtro' ORDER BY titulo";
        $titulo_secao = ($filtro === 'filme') ? 'Filmes' : 'Séries';
    } else {
        $sql_filmes   = "SELECT * FROM filmes ORDER BY tipo, titulo";
        $titulo_secao = 'Todos os Títulos';
    }
    $filmes = $conn->query($sql_filmes);
    ?>

    
    <main>
        <h3 class="titulo-secao"><?php echo $titulo_secao; ?></h3>

        <section class="container-filmes">
            <?php while ($filme = $filmes->fetch_assoc()): ?>

                <!-- Card de cada filme/série -->
                <article class="box-filme">

                    <!-- Clique no card leva para a página de detalhes -->
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

                    <!-- Botão de favoritar (coração) -->
                    <button
                        class="btn-favoritar <?php echo in_array($filme['id'], $favoritos_ids) ? 'favoritado' : ''; ?>"
                        data-id="<?php echo $filme['id']; ?>"
                        title="Favoritar"
                    >
                        ♥
                    </button>

                </article>

            <?php endwhile; ?>
        </section>
    </main>

    <script>
    // Script para favoritar sem recarregar a página
    document.querySelectorAll('.btn-favoritar').forEach(function(botao) {
        botao.addEventListener('click', function() {
            const filmeId = this.dataset.id;
            const btnAtual = this;

            // Envia uma requisição para favoritar.php
            fetch('favoritar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'filme_id=' + filmeId
            })
            .then(function(resposta) { return resposta.text(); })
            .then(function(resultado) {
                // Alterna a classe 'favoritado' no botão
                if (resultado === 'adicionado') {
                    btnAtual.classList.add('favoritado');
                    btnAtual.title = 'Remover dos favoritos';
                } else {
                    btnAtual.classList.remove('favoritado');
                    btnAtual.title = 'Favoritar';
                }
            });
        });
    });
    </script>

</body>
</html>