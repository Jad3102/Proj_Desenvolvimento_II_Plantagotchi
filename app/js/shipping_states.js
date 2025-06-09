const fretePorEstado = {
    "AC": 35.00,
    "AL": 25.00,
    "AP": 38.00,
    "AM": 42.00,
    "BA": 22.00,
    "CE": 24.00,
    "DF": 20.00,
    "ES": 18.00,
    "GO": 20.00,
    "MA": 30.00,
    "MT": 28.00,
    "MS": 25.00,
    "MG": 18.00,
    "PA": 36.00,
    "PB": 24.00,
    "PR": 16.00,
    "PE": 24.00,
    "PI": 26.00,
    "RJ": 15.00,
    "RN": 23.00,
    "RS": 17.00,
    "RO": 33.00,
    "RR": 40.00,
    "SC": 18.00,
    "SP": 12.00,
    "SE": 22.00,
    "TO": 30.00
};

function calcularValores() {
    const estado = document.getElementById("estadoUsuario").value;
    const quantidade = parseInt(document.getElementById("quantidade").value);
    const precoUnitario = 250.00;
    const precoComDesconto = precoUnitario * 0.9;
    const valorProduto = precoComDesconto * quantidade;
    const frete = fretePorEstado[estado] || 30.00; // padrão se estado não encontrado
    const total = valorProduto + frete;

    document.getElementById("valor-frete").textContent = `Valor do Frete: R$ ${frete.toFixed(2)}`;
    document.getElementById("valor-total").textContent = `Valor Total: R$ ${total.toFixed(2)}`;
}
