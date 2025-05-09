//função serve para mostrar de forma visual o CPF formatato corretamente
function formatarCPF(cpf) {
    cpf = cpf.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Insere o primeiro ponto (###.###.###-##)
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Insere o segundo ponto (###.###.###-##)
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Insere o traço (###.###.###-##)
    return cpf;
}