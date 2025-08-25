<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Local</title>
    <style>
        /* Estilos para o formulário */
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { text-align: center; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input[type="text"], input[type="number"], textarea {
            width: 100%; padding: 0.5rem; box-sizing: border-box;
        }
        button { padding: 0.7rem 1.5rem; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        .back-link { display: inline-block; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Novo Local/Quadra</h1>

        <form action="<?php echo BASE_URL; ?>/quadras/salvar" method="POST">
            <div class="form-group">
                <label for="name">Nome do Local:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="address">Endereço:</label>
                <input type="text" id="address" name="address">
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
                <input type="text" id="floor_type" name="floor_type" placeholder="Ex: Areia, Grama Sintética...">
            </div>

            <div class="form-group">
                <label>É Coberto?</label>
                <input type="radio" id="is_covered_yes" name="is_covered" value="1"> <label for="is_covered_yes">Sim</label>
                <input type="radio" id="is_covered_no" name="is_covered" value="0" checked> <label for="is_covered_no">Não</label>
            </div>

            <button type="submit">Salvar Local</button>
        </form>

        <a href="<?php echo BASE_URL; ?>/quadras" class="back-link">Voltar para a lista</a>
    </div>
</body>
</html>
