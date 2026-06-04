document.addEventListener("DOMContentLoaded", () => {

    const tamanho_normal = 16;
    const tamanho_aumentado = 20;

    // Contraste
    let ativo = localStorage.getItem('acessibilidade') === 'true';
    const checkboxContraste = document.getElementById("contraste");

    function aplicarEstado() {
        if (ativo) {
            document.documentElement.style.fontSize = tamanho_aumentado + 'px';
            document.body.classList.add('alto-contraste');
        } else {
            document.documentElement.style.fontSize = tamanho_normal + 'px';
            document.body.classList.remove('alto-contraste');
        }
    }

    aplicarEstado();
    checkboxContraste.checked = ativo;

    checkboxContraste.addEventListener("change", () => {
        ativo = checkboxContraste.checked;
        localStorage.setItem('acessibilidade', ativo);
        aplicarEstado();
    });

    // Tema
    const checkboxTema = document.getElementById("tema");
    const temaSalvo = localStorage.getItem("tema");

    if (temaSalvo === "claro") {
        document.body.classList.add("claro");
        checkboxTema.checked = true;
    }

    checkboxTema.addEventListener("change", () => {
        document.body.classList.toggle("claro");
        if (document.body.classList.contains("claro")) {
            localStorage.setItem("tema", "claro");
        } else {
            localStorage.setItem("tema", "escuro");
        }
    });

    // Painel
    document.getElementById("btn-acessibilidade").addEventListener("click", (e) => {
        e.stopPropagation();
        const painel = document.getElementById("painel-acessibilidade");
        painel.classList.toggle("painel-oculto");
        painel.classList.toggle("painel-visivel");
    });

    document.getElementById("painel-acessibilidade").addEventListener("click", (e) => {
        e.stopPropagation();
    });

    document.addEventListener("click", () => {
        const painel = document.getElementById("painel-acessibilidade");
        painel.classList.add("painel-oculto");
        painel.classList.remove("painel-visivel");
    });

});