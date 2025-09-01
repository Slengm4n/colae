<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF--8">
    <title>Cadastrar Nova Quadra</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>

<body>
    <div class="container">
        <h1>Cadastrar Nova Quadra</h1>

        <form action="<?php echo BASE_URL; ?>/quadras/salvar" method="POST" enctype="multipart/form-data">

            <h2>Dados da Quadra</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nome do Local:</label>
                    <input type="text" id="name" name="name" required minlength="3">
                </div>
                <div class="form-group">
                    <label for="average_price_per_hour">Preço Médio por Hora:</label>
                    <input type="number" step="0.01" min="0.01" id="average_price_per_hour" name="average_price_per_hour" placeholder="Ex: 50.00">
                </div>
                <div class="form-group">
                    <label for="court_capacity">Capacidade da Quadra:</label>
                    <input type="number" id="court_capacity" name="court_capacity" min="1">
                </div>
                <div class="form-group">
                    <label for="leisure_area_capacity">Capacidade da Área de Lazer:</label>
                    <input type="number" id="leisure_area_capacity" name="leisure_area_capacity" min="1">
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
                <fieldset class="form-group radio-group">
                    <legend>Possui Área de Lazer?</legend>
                    <div class="radio-options">
                        <input type="radio" id="has_leisure_area_yes" name="has_leisure_area" value="1">
                        <label for="has_leisure_area_yes">Sim</label>
                        <input type="radio" id="has_leisure_area_no" name="has_leisure_area" value="0" checked>
                        <label for="has_leisure_area_no">Não</label>
                    </div>
                </fieldset>
                <fieldset class="form-group radio-group">
                    <legend>Possui Iluminação?</legend>
                    <div class="radio-options">
                        <input type="radio" id="has_lighting_yes" name="has_lighting" value="1">
                        <label for="has_lighting_yes">Sim</label>
                        <input type="radio" id="has_lighting_no" name="has_lighting" value="0" checked>
                        <label for="has_lighting_no">Não</label>
                    </div>
                </fieldset>
                <fieldset class="form-group radio-group">
                    <legend>É Coberto?</legend>
                    <div class="radio-options">
                        <input type="radio" id="is_covered_yes" name="is_covered" value="1">
                        <label for="is_covered_yes">Sim</label>
                        <input type="radio" id="is_covered_no" name="is_covered" value="0" checked>
                        <label for="is_covered_no">Não</label>
                    </div>
                </fieldset>
            </div>

            <h2>Endereço</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" required pattern="\d{5}-?\d{3}" maxlength="9" placeholder="00000-000">
                </div>
                <div class="form-group">
                    <label for="street">Rua/Avenida:</label>
                    <input type="text" id="street" name="street" required>
                </div>
                <div class="form-group">
                    <label for="number">Número:</label>
                    <input type="text" id="number" name="number" required>
                </div>
                <div class="form-group">
                    <label for="neighborhood">Bairro:</label>
                    <input type="text" id="neighborhood" name="neighborhood" required>
                </div>
                <div class="form-group">
                    <label for="city">Cidade:</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="state">Estado:</label>
                    <input type="text" id="state" name="state" required>
                </div>
                <div class="form-group">
                    <label for="complement">Complemento:</label>
                    <input type="text" id="complement" name="complement">
                </div>
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

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</body>

</html>