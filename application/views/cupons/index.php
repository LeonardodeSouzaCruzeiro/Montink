<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cupons de Desconto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #f8f9fa, #e9ecef, #fdfdfd);
        }
        .cupom-card {
            border-radius: 1rem;
            border: 1px solid #dee2e6;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            background: white;
        }
        .cupom-codigo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .cupom-info small {
            color: #6c757d;
        }
    </style>
</head>
<body class="p-4">
<?php $this->load->view('layouts/header'); ?>
<br><hr>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">🎟 Cupons de Desconto</h2>
        <a href="<?= site_url('index.php/cupons/form') ?>" class="btn btn-dark"><b><i class="bi bi-plus"></i></b></a></a>
    </div>

    <div class="row">
        <?php foreach ($cupons as $c): ?>
            <div class="col-md-4 mb-4">
                <div class="p-3 cupom-card h-100">
                    <div class="cupom-codigo"><?= $c->codigo ?></div>
                    <div class="cupom-info mt-2">
                        <p class="mb-1">💸 Valor: <strong>R$ <?= number_format($c->valor, 2, ',', '.') ?></strong></p>
                        <p class="mb-1">📉 Mínimo: <strong>R$ <?= number_format($c->minimo, 2, ',', '.') ?></strong></p>
                        <p class="mb-3">📅 Validade: <strong><?= date('d/m/Y', strtotime($c->validade)) ?></strong></p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?= site_url('index.php/cupons/form/' . $c->id) ?>" class="btn btn-sm btn-outline-primary w-100">✏️ Editar</a>
                        <a href="<?= site_url('index.php/cupons/delete/' . $c->id) ?>" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Excluir?')">🗑️ Excluir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($cupons)): ?>
            <div class="col-12 text-center text-muted">
                <p>🚫 Nenhum cupom cadastrado ainda.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
</body>
</html>
