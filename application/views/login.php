<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f6fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            border-radius: 8px;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        .error-msg {
            color: #dc3545;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php $this->load->view('layouts/header'); ?>
<div class="card p-4">
    <div class="text-center">
        <img src="<?= base_url('uploads/logo_login.png') ?>" class="logo" alt="Logo"></a>
        <h4 class="mb-4">Acesso ao Sistema</h4>
    </div>

    <?php if ($this->session->flashdata('erro')): ?>
        <div class="error-msg">
            <?= $this->session->flashdata('erro') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('index.php/auth/login') ?>">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" name="senha" id="senha" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Entrar</button>
    </form>
</div>
<?php $this->load->view('layouts/footer'); ?>
</body>
</html>
