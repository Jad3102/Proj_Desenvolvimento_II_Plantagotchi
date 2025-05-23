function exibirAlertaCEP(mensagem) {
    const container = document.getElementById("cepAlertContainer");
    if (!container) {
        alert(mensagem);
        return;
    }

    container.innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            ${mensagem}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    `;
}

function buscarCEP() {
    const cepInput = document.getElementById("cep");
    let cep = cepInput.value.replace(/\D/g, "");

    if (cep.length !== 8) {
        exibirAlertaCEP("CEP inválido. Insira um CEP com 8 dígitos.");
        return;
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
                exibirAlertaCEP("CEP não localizado ou incorreto.");
            }
        })
        .catch(error => {
            console.error("Erro ao buscar o CEP:", error);
            exibirAlertaCEP("Erro ao buscar o CEP. Tente novamente mais tarde.");
        });
}