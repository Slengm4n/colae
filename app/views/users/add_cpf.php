<?php AuthHelper::start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar CPF</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            padding: 20px 0;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h1 {
            margin-bottom: 1.5rem;
        }

        p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            box-sizing: border-box;
            margin-bottom: 1rem;
            border: 1px solid #ced4da;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 0.7rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: .25rem;
        }

        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Valide seu Cadastro</h1>
        <p>Para começar a cadastrar suas quadras, precisamos que você informe um CPF válido. Este passo é importante para a segurança da plataforma.</p>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/dashboard/cpf" method="POST">
            <div class="form-group">
                <label for="cpf" style="display:none;">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
            </div>
            <button type="submit">Validar e Salvar CPF</button>
        </form>
        <a href="<?php echo BASE_URL; ?>/dashboard" class="back-link">Voltar ao Painel</a>
    </div>

    <script>
        // Máscara simples para o campo CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            var value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    </script>
</body>

</html>