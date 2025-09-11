// Garante que o script só rode após o carregamento completo do HTML.
document.addEventListener('DOMContentLoaded', function() {

    const cepInput = document.getElementById('cep');

    if (cepInput) {
        // Adiciona um "escutador de eventos" ao campo CEP.
        // A função será executada quando o utilizador clicar fora do campo (evento 'blur').
        cepInput.addEventListener('blur', function() {
            // Pega o valor do CEP e remove caracteres que não são números.
            const cep = this.value.replace(/\D/g, '');

            // Verifica se o CEP tem 8 dígitos.
            if (cep.length === 8) {
                // Faz uma requisição para a API ViaCEP.
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro na requisição da API.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Se a API não retornar um erro...
                        if (!data.erro) {
                            // Preenche os campos do formulário com os dados recebidos.
                            document.getElementById('street').value = data.logradouro;
                            document.getElementById('neighborhood').value = data.bairro;
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;
                            
                            // Move o foco para o campo "Número" para facilitar a digitação.
                            document.getElementById('number').focus();
                        } else {
                            // Se o CEP não for encontrado, limpa os campos e avisa o utilizador.
                            alert('CEP não encontrado. Por favor, verifique o número digitado.');
                            clearAddressFields();
                        }
                    })
                    .catch(error => {
                        // Em caso de erro na rede, exibe no console.
                        console.error('Erro ao buscar o CEP:', error);
                        alert('Não foi possível buscar o CEP. Verifique sua conexão com a internet.');
                    });
            }
        });
    }

    // Função para limpar os campos de endereço.
    function clearAddressFields() {
        document.getElementById('street').value = '';
        document.getElementById('neighborhood').value = '';
        document.getElementById('city').value = '';
        document.getElementById('state').value = '';
    }
});