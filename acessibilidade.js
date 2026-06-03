
// Modo claro e escuro
const btnTema = document.getElementById("tema");
const temaSalvo = localStorage.getItem("tema");

if (temaSalvo === "claro") {
    document.body.classList.add("claro");
}

if (btnTema) {
    btnTema.addEventListener("click", () => {document.body.classList.toggle("claro");
        if (document.body.classList.contains("claro")) {
            localStorage.setItem("tema", "claro");
        } else {
            localStorage.setItem("tema", "escuro");
        }
    });
}
