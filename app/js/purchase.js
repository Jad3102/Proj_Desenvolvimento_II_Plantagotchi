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