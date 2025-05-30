<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Obrigado pelo seu pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<?php $this->load->view('layouts/header'); ?>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="card-title text-success">🎉 Pedido realizado com sucesso!</h2>
            <p class="card-text">Obrigado, <strong><?= htmlspecialchars($pedido->nome) ?></strong>!</p>

            <ul class="list-group">
                <li class="list-group-item"><strong>Nº do Pedido:</strong> <?= $pedido->id ?></li>
                <li class="list-group-item"><strong>Endereço:</strong> <?= $pedido->endereco ?> - CEP: <?= $pedido->cep ?></li>
                <li class="list-group-item"><strong>Total:</strong> R$ <?= number_format($pedido->total, 2, ',', '.') ?></li>
                <li class="list-group-item"><strong>Status:</strong> <?= ucfirst($pedido->status) ?></li>
            </ul>

            <a href="<?= site_url('index.php/produtos') ?>" class="btn btn-primary mt-3">Voltar para a loja</a>
        </div>
    </div>
</div>
<?php $this->load->view('layouts/footer'); ?>
</body>
</html>
