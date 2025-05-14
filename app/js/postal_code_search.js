function buscarCEP() {
    const cepInput = document.getElementById("cep");
    let cep = cepInput.value.replace(/\D/g, "");

    // Evita buscar CEPs com menos de 8 dígitos
    if (cep.length !== 8) {
        return; // Não faz nada
    }

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.getElementById("rua").value = data.logradouro;
                document.getElementById("bairro").value = data.bairro;
                document.getElementById("cidade").value = data.localidade;
                document.getElementById("estado").value = data.uf;
                document.getElementById("cepAlertContainer").innerHTML = "";
            } else {
                exibirAlertaCEP("CEP não encontrado. Verifique e tente novamente.");
            }
        })
        .catch(error => {
            console.error("Erro ao buscar o CEP:", error);
            exibirAlertaCEP("Erro ao buscar o CEP. Tente novamente mais tarde.");
        });
}