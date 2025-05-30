<!DOCTYPE html>
<html>
<head>
    <title>Lista de Pedidos</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pedido-card {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .pedido-card .titulo {
            font-size: 1.25rem;
            font-weight: 500;
        }
        .pedido-card .status {
            font-weight: 600;
        }
    </style>
</head>
<body class="container py-4">
<?php $this->load->view('layouts/header'); ?>

<h2 class="mb-4">Lista de Pedidos</h2>

<?php foreach ($pedidos as $pedido): ?>
    <div class="pedido-card" id="pedido-<?= $pedido->id ?>">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <div class="titulo">Pedido #<?= $pedido->id ?> - <?= htmlspecialchars($pedido->nome) ?></div>
                <div class="text-muted small">Realizado em <?= date('d/m/Y H:i', strtotime($pedido->data_criacao)) ?></div>
                <div class="mt-2">Status: <span class="status text-primary"><?= $pedido->status ?></span></div>
            </div>
            <div class="d-flex gap-2 mt-3 mt-sm-0">
                <?php if (strtolower($pedido->status) !== 'aprovado'): ?>
                    <button class="btn btn-success btn-sm atualizar-status" data-id="<?= $pedido->id ?>" data-status="Aprovado">Aprovar</button>
                <?php endif; ?>
                <?php if (strtolower($pedido->status) !== 'cancelado'): ?>
                    <button class="btn btn-danger btn-sm atualizar-status" data-id="<?= $pedido->id ?>" data-status="Cancelado">Cancelar</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.atualizar-status').click(function() {
        var id = $(this).data('id');
        var status = $(this).data('status');

        if (!confirm('Tem certeza que deseja mudar o status para "' + status + '"?')) {
            return;
        }

        $.post('<?= site_url('index.php/pedido/webhook') ?>', { id: id, status: status }, function(response) {
            alert(response.message);
            location.reload();
        }, 'json').fail(function(xhr) {
            alert('Erro: ' + xhr.responseText);
        });
    });
});
</script>

<?php $this->load->view('layouts/footer'); ?>
</body>
</html>
