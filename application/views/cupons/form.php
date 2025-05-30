<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $cupom ? 'Editar Cupom' : 'Novo Cupom' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #f8f9fa, #e9ecef, #fdfdfd);
        }
        .card-form {
            max-width: 600px;
            margin: auto;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.06);
        }
        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>
<body class="p-4">
<?php $this->load->view('layouts/header'); ?>
<hr>
<div class="container">
    <div class="card card-form p-4 mt-5">
        <div class="form-title mb-3 text-center">
            <?= $cupom ? '✏️ Editar Cupom' : '🎟️ Novo Cupom' ?>
        </div>

        <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

        <form method="post" action="<?= site_url('index.php/cupons/save') ?>">
            <input type="hidden" name="id" value="<?= $cupom->id ?? '' ?>">

            <div class="mb-3">
                <label class="form-label">🆔 Código do Cupom</label>
                <input type="text" name="codigo" class="form-control" value="<?= set_value('codigo', $cupom->codigo ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">💸 Valor do Desconto (R$)</label>
                <input type="number" step="0.01" name="valor" class="form-control" value="<?= set_value('valor', $cupom->valor ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">📉 Valor Mínimo do Pedido (R$)</label>
                <input type="number" step="0.01" name="minimo" class="form-control" value="<?= set_value('minimo', $cupom->minimo ?? '0') ?>">
            </div>

            <div class="mb-4">
                <label class="form-label">📅 Validade</label>
                <input type="date" name="validade" class="form-control" value="<?= set_value('validade', $cupom->validade ?? '') ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary w-50 me-2">💾 Salvar</button>
                <a href="<?= site_url('index.php/cupons') ?>" class="btn btn-outline-secondary w-50">↩️ Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
</body>
</html>
