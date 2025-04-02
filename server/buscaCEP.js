function buscarCEP() {
    let cep = document.getElementById("cep").value.replace(/\D/g, ""); // Remove caracteres não numéricos
    
    if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
        fetch(`https://viacep.com.br/ws/${cep}/json/`) // Faz uma requisição para a API do ViaCEP
            .then(response => response.json()) // Converte a resposta em JSON
            .then(data => {
                if (!data.erro) { // Se o CEP for válido
                    document.getElementById("rua").value = data.logradouro;
                    document.getElementById("bairro").value = data.bairro;
                    document.getElementById("cidade").value = data.localidade;
                    document.getElementById("estado").value = data.uf;
                } else {
                    alert("CEP não encontrado.");
                }
            })
            .catch(error => console.error("Erro ao buscar o CEP:", error)); // Caso haja erro na requisição
    }
}