<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Nova Quadra</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 800px; margin: auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 6px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #212529; }
        h2 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-top: 2rem; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 0.75rem;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 6px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input:focus { border-color: #80bdff; outline: 0; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
        .radio-group label { font-weight: normal; margin-right: 15px; }
        button { display: block; width: 100%; padding: 0.8rem 1.5rem; background-color: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 1.1rem; font-weight: bold; margin-top: 2rem; }
        button:hover { background-color: #218838; }
        .back-link { display: inline-block; margin-top: 1.5rem; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Nova Quadra</h1>

        <form action="<?php echo BASE_URL; ?>/quadras/salvar" method="POST" enctype="multipart/form-data">
            
            <h2>Dados da Quadra</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nome do Local:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="average_price_per_hour">Preço Médio por Hora:</label>
                    <input type="number" step="0.01" id="average_price_per_hour" name="average_price_per_hour">
                </div>
                <div class="form-group">
                    <label for="court_capacity">Capacidade da Quadra:</label>
                    <input type="number" id="court_capacity" name="court_capacity">
                </div>
                <div class="form-group">
                    <label for="leisure_area_capacity">Capacidade da Área de Lazer:</label>
                    <input type="number" id="leisure_area_capacity" name="leisure_area_capacity">
                </div>
                <div class="form-group">
                    <label for="floor_type">Tipo de Piso:</label>
                    <select id="floor_type" name="floor_type">
                        <option value="grama natural">Grama Natural</option>
                        <option value="grama sintética">Grama Sintética</option>
                        <option value="cimento">Cimento</option>
                        <option value="areia">Areia</option>
                        <option value="saibro">Saibro</option>
                    </select>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group radio-group">
                    <label>Possui Área de Lazer?</label>
                    <input type="radio" id="has_leisure_area_yes" name="has_leisure_area" value="1"> <label for="has_leisure_area_yes">Sim</label>
                    <input type="radio" id="has_leisure_area_no" name="has_leisure_area" value="0" checked> <label for="has_leisure_area_no">Não</label>
                </div>
                <div class="form-group radio-group">
                    <label>Possui Iluminação?</label>
                    <input type="radio" id="has_lighting_yes" name="has_lighting" value="1"> <label for="has_lighting_yes">Sim</label>
                    <input type="radio" id="has_lighting_no" name="has_lighting" value="0" checked> <label for="has_lighting_no">Não</label>
                </div>
                <div class="form-group radio-group">
                    <label>É Coberto?</label>
                    <input type="radio" id="is_covered_yes" name="is_covered" value="1"> <label for="is_covered_yes">Sim</label>
                    <input type="radio" id="is_covered_no" name="is_covered" value="0" checked> <label for="is_covered_no">Não</label>
                </div>
            </div>

            <h2>Endereço</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep">
                </div>
                <div class="form-group">
                    <label for="street">Rua/Avenida:</label>
                    <input type="text" id="street" name="street">
                </div>
                <div class="form-group">
                    <label for="number">Número:</label>
                    <input type="text" id="number" name="number">
                </div>
                <div class="form-group">
                    <label for="neighborhood">Bairro:</label>
                    <input type="text" id="neighborhood" name="neighborhood">
                </div>
                <div class="form-group">
                    <label for="complement">Complemento:</label>
                    <input type="text" id="complement" name="complement">
                </div>
                <div class="form-group">
                    <label for="city">Cidade:</label>
                    <input type="text" id="city" name="city">
                </div>
                <div class="form-group">
                    <label for="state">Estado:</label>
                    <input type="text" id="state" name="state">
                </div>
                <h2>Imagens da Quadra</h2>
    <div class="form-group">
        <label for="images">Selecione uma ou mais imagens:</label>
        <input type="file" id="images" name="images[]" multiple accept="image/jpeg, image/png">
            </div>
            
            <button type="submit">Salvar Local</button>
        </form>

        <a href="<?php echo BASE_URL; ?>/quadras" class="back-link">Voltar para a lista</a>
    </div>

    <script>
        // Adiciona um "escutador de eventos" ao campo CEP.
        // A função será executada quando o utilizador clicar fora do campo (evento 'blur').
        document.getElementById('cep').addEventListener('blur', function() {
            // Pega o valor do CEP e remove caracteres que não são números.
            const cep = this.value.replace(/\D/g, '');

            // Verifica se o CEP tem 8 dígitos.
            if (cep.length === 8) {
                // Faz uma requisição para a API ViaCEP.
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json()) // Converte a resposta para JSON.
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
                            alert('CEP não encontrado.');
                            clearAddressFields();
                        }
                    })
                    .catch(error => {
                        // Em caso de erro na rede, exibe no console.
                        console.error('Erro ao buscar o CEP:', error);
                    });
            }
        });

        // Função para limpar os campos de endereço.
        function clearAddressFields() {
            document.getElementById('street').value = '';
            document.getElementById('neighborhood').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
        }
    </script>
</body>
</html>
