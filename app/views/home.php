<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Colaê</title>
    <!-- Incluindo Bootstrap para um estilo moderno -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background-color: #ffffff;
            padding: 4rem 2rem;
            margin-top: 5rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.25rem;
            color: #6c757d;
        }
        .btn-primary {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero">
            <h1>Bem-vindo ao Colaê!</h1>
            <p class="lead">O seu sistema de gestão desportiva simplificado.</p>
            <hr class="my-4">
            <p>Comece por gerir os utilizadores do sistema.</p>
            <a class="btn btn-primary btn-lg" href="/colae/usuarios" role="button">Gerir Utilizadores</a>
        </div>
    </div>
</body>
</html>
