<?php
session_start();

// evita erro se não existir
$categoria = $_SESSION['categoria'] ?? 'normal';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Upgrade - Nityfrix</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header class="menu">
    <h1 class="logo">Nityfrix</h1>
    <nav>
        <a href="index.php">Início</a>
        <a href="perfil.php">Perfil</a>
        <button id="tema">☀️</button>
    </nav>
</header>

<main style="margin-top: 120px; display:flex; justify-content:center;">

    <div style="
        background: #141414;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 8px 30px rgba(0,0,0,0.6);
    ">

        <h2 style="color:#c084fc; margin-bottom:10px;">🚀 Vire Premium</h2>

        <p style="color:#aaa; font-size:0.9rem; margin-bottom:20px;">
            Desbloqueie todos os recursos do Nityfrix
        </p>

        <ul style="
            list-style:none;
            padding:0;
            margin-bottom:25px;
            color:#ccc;
            font-size:0.9rem;
        ">
            <li style="margin:8px 0;">📌 Assistir Filmes</li>
            <li style="margin:8px 0;">🔥 Conteúdos exclusivos</li>
        </ul>

        <!-- BOTÃO INTELIGENTE -->
        <?php if ($categoria == 'premium'): ?>
            <button onclick="mostrarJaPremium()" class="btn-assistir">
                Já sou Premium
            </button>
        <?php else: ?>
            <a href="assinar.php" class="btn-assistir">
                Virar Premium
            </a>
        <?php endif; ?>

    </div>

</main>

<!-- POPUP: JÁ É PREMIUM -->
<div id="popupJaPremium" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:2000;
">
    <div style="
        background:#141414;
        padding:30px;
        border-radius:12px;
        text-align:center;
        max-width:350px;
        width:90%;
    ">
        <h2 style="color:#c084fc;">😎 Ei!</h2>
        <p style="color:#ccc; margin:15px 0;">
            Você já é <strong>Premium</strong>!
        </p>

        <button onclick="fecharPopup('popupJaPremium')" class="btn-assistir">
            Fechar
        </button>
    </div>
</div>

<!-- POPUP: SUCESSO -->
<div id="popupSucesso" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:2000;
">
    <div style="
        background:#141414;
        padding:30px;
        border-radius:12px;
        text-align:center;
        max-width:350px;
        width:90%;
    ">
        <h2 style="color:#22c55e;">🎉 Parabéns!</h2>
        <p style="color:#ccc; margin:15px 0;">
            Agora você é <strong>Premium</strong>!
        </p>
    </div>
</div>

<!-- POPUP: ERRO -->
<div id="popupErro" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:2000;
">
    <div style="
        background:#141414;
        padding:30px;
        border-radius:12px;
        text-align:center;
        max-width:350px;
        width:90%;
    ">
        <h2 style="color:#ef4444;">❌ Erro</h2>
        <p style="color:#ccc; margin:15px 0;">
            Algo deu errado. Tente novamente.
        </p>

        <button onclick="fecharPopup('popupErro')" class="btn-assistir">
            Fechar
        </button>
    </div>
</div>

<script>
function mostrarJaPremium() {
    document.getElementById("popupJaPremium").style.display = "flex";
}

function fecharPopup(id) {
    document.getElementById(id).style.display = "none";
}

// controle pelos parâmetros da URL
<?php if (isset($_GET['sucesso'])): ?>
    document.getElementById("popupSucesso").style.display = "flex";
    setTimeout(() => {
        window.location.href = "index.php";
    }, 2000);
<?php endif; ?>

<?php if (isset($_GET['ja'])): ?>
    document.getElementById("popupJaPremium").style.display = "flex";
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
    document.getElementById("popupErro").style.display = "flex";
<?php endif; ?>
</script>

<script src="acessibilidade.js"></script>
</body>
</html>