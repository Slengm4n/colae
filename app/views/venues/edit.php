<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Quadra</title>
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
        button { display: block; width: 100%; padding: 0.8rem 1.5rem; background-color: #ffc107; color: #212529; border: none; border-radius: 6px; cursor: pointer; font-size: 1.1rem; font-weight: bold; margin-top: 2rem; }
        button:hover { background-color: #e0a800; }
        .back-link { display: inline-block; margin-top: 1.5rem; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Quadra: <?php echo htmlspecialchars($venue['name']); ?></h1>

        <form action="<?php echo BASE_URL; ?>/quadras/atualizar/<?php echo $venue['id']; ?>" method="POST">
            
            <!-- Campo oculto para enviar o ID do endereço -->
            <input type="hidden" name="address_id" value="<?php echo $venue['address_id']; ?>">

            <h2>Dados da Quadra</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nome do Local:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($venue['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="average_price_per_hour">Preço Médio por Hora:</label>
                    <input type="number" step="0.01" id="average_price_per_hour" name="average_price_per_hour" value="<?php echo htmlspecialchars($venue['average_price_per_hour']); ?>">
                </div>
                <div class="form-group">
                    <label for="court_capacity">Capacidade da Quadra:</label>
                    <input type="number" id="court_capacity" name="court_capacity" value="<?php echo htmlspecialchars($venue['court_capacity']); ?>">
                </div>
                <div class="form-group">
                    <label for="leisure_area_capacity">Capacidade da Área de Lazer:</label>
                    <input type="number" id="leisure_area_capacity" name="leisure_area_capacity" value="<?php echo htmlspecialchars($venue['leisure_area_capacity']); ?>">
                </div>
                <div class="form-group">
                    <label for="floor_type">Tipo de Piso:</label>
                    <select id="floor_type" name="floor_type">
                        <option value="grama natural" <?php echo ($venue['floor_type'] == 'grama natural') ? 'selected' : ''; ?>>Grama Natural</option>
                        <option value="grama sintética" <?php echo ($venue['floor_type'] == 'grama sintética') ? 'selected' : ''; ?>>Grama Sintética</option>
                        <option value="cimento" <?php echo ($venue['floor_type'] == 'cimento') ? 'selected' : ''; ?>>Cimento</option>
                        <option value="areia" <?php echo ($venue['floor_type'] == 'areia') ? 'selected' : ''; ?>>Areia</option>
                        <option value="saibro" <?php echo ($venue['floor_type'] == 'saibro') ? 'selected' : ''; ?>>Saibro</option>
                    </select>
                </div>
                 <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="available" <?php echo ($venue['status'] == 'available') ? 'selected' : ''; ?>>Disponível</option>
                        <option value="unavailable" <?php echo ($venue['status'] == 'unavailable') ? 'selected' : ''; ?>>Indisponível</option>
                        <option value="in_maintenance" <?php echo ($venue['status'] == 'in_maintenance') ? 'selected' : ''; ?>>Em Manutenção</option>
                    </select>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group radio-group">
                    <label>Possui Área de Lazer?</label>
                    <input type="radio" id="has_leisure_area_yes" name="has_leisure_area" value="1" <?php echo ($venue['has_leisure_area'] == 1) ? 'checked' : ''; ?>> <label for="has_leisure_area_yes">Sim</label>
                    <input type="radio" id="has_leisure_area_no" name="has_leisure_area" value="0" <?php echo ($venue['has_leisure_area'] == 0) ? 'checked' : ''; ?>> <label for="has_leisure_area_no">Não</label>
                </div>
                <div class="form-group radio-group">
                    <label>Possui Iluminação?</label>
                    <input type="radio" id="has_lighting_yes" name="has_lighting" value="1" <?php echo ($venue['has_lighting'] == 1) ? 'checked' : ''; ?>> <label for="has_lighting_yes">Sim</label>
                    <input type="radio" id="has_lighting_no" name="has_lighting" value="0" <?php echo ($venue['has_lighting'] == 0) ? 'checked' : ''; ?>> <label for="has_lighting_no">Não</label>
                </div>
                <div class="form-group radio-group">
                    <label>É Coberto?</label>
                    <input type="radio" id="is_covered_yes" name="is_covered" value="1" <?php echo ($venue['is_covered'] == 1) ? 'checked' : ''; ?>> <label for="is_covered_yes">Sim</label>
                    <input type="radio" id="is_covered_no" name="is_covered" value="0" <?php echo ($venue['is_covered'] == 0) ? 'checked' : ''; ?>> <label for="is_covered_no">Não</label>
                </div>
            </div>

            <h2>Endereço</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($venue['cep']); ?>">
                </div>
                <div class="form-group">
                    <label for="street">Rua/Avenida:</label>
                    <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($venue['street']); ?>">
                </div>
                <div class="form-group">
                    <label for="number">Número:</label>
                    <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($venue['number']); ?>">
                </div>
                <div class="form-group">
                    <label for="neighborhood">Bairro:</label>
                    <input type="text" id="neighborhood" name="neighborhood" value="<?php echo htmlspecialchars($venue['neighborhood']); ?>">
                </div>
                <div class="form-group">
                    <label for="complement">Complemento:</label>
                    <input type="text" id="complement" name="complement" value="<?php echo htmlspecialchars($venue['complement'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="city">Cidade:</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($venue['city']); ?>">
                </div>
                <div class="form-group">
                    <label for="state">Estado:</label>
                    <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($venue['state']); ?>">
                </div>
            </div>
            
            <button type="submit">Atualizar Local</button>
        </form>

        <a href="<?php echo BASE_URL; ?>/quadras" class="back-link">Voltar para a lista</a>
    </div>

    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('street').value = data.logradouro;
                            document.getElementById('neighborhood').value = data.bairro;
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;
                            document.getElementById('number').focus();
                        } else {
                            alert('CEP não encontrado.');
                        }
                    });
            }
        });
    </script>
</body>
</html>
