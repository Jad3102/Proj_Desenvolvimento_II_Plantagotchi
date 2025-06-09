 function aumentarQuantidade() {
    let quantidade = parseInt(document.getElementById("quantidade").value);
    document.getElementById("quantidade").value = quantidade + 1;
    };

function diminuirQuantidade() {
    let quantidade = parseInt(document.getElementById("quantidade").value);
    if (quantidade > 1) {
        document.getElementById("quantidade").value = quantidade - 1;
    }
};

document.addEventListener("DOMContentLoaded", function () {
    calcularValores(); // Atualiza os valores ao carregar
});

function aumentarQuantidade() {
    const quantidadeInput = document.getElementById("quantidade");
    quantidadeInput.value = parseInt(quantidadeInput.value) + 1;
    calcularValores();
}

function diminuirQuantidade() {
    const quantidadeInput = document.getElementById("quantidade");
    if (parseInt(quantidadeInput.value) > 1) {
        quantidadeInput.value = parseInt(quantidadeInput.value) - 1;
        calcularValores();
    }
}
