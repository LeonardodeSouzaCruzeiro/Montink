<!DOCTYPE html>
<html>
<head>
    <title>Carrinho</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tabela-carrinho td {
            vertical-align: middle;
        }
        .resumo-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="container py-4">
<?php $this->load->view('layouts/header'); ?>
<br><hr>
<?php if (empty($carrinho)): ?>
    <div class="alert alert-info">Seu carrinho está vazio.</div>
<?php else: ?>
<div class="row g-4">
    <div class="col-lg-8">
        <h2>Carrinho de Compras</h2>
        <table class="table table-bordered tabela-carrinho">
            <thead class="table-light">
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Qtd</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrinho as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nome']) ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($item['quantidade']) ?></td>
                    <td>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></td>
                    <td>
                        <a href="<?= site_url('index.php/carrinho/remover/' . $item['id']) ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?= site_url('index.php/carrinho/limpar') ?>" class="btn btn-sm btn-outline-warning mt-2">Esvaziar carrinho</a>
    </div>

    <div class="col-lg-4">
        <div class="resumo-box">
            <h5>Resumo do Pedido</h5>
            <p><strong>Subtotal:</strong> R$ <?= number_format($subtotal, 2, ',', '.') ?></p>
            <p><strong>Frete:</strong> R$ <?= number_format($frete, 2, ',', '.') ?></p>

            <?php if (!empty($desconto)): ?>
            <p><strong>Desconto:</strong> -R$ <?= number_format($desconto, 2, ',', '.') ?></p>
            <?php endif; ?>

            <p><strong>Total:</strong> <span class="text-success fw-bold">R$ <?= number_format($total, 2, ',', '.') ?></span></p>

            <form id="cepForm" class="mb-3">
                <input type="text" name="cep" id="cep" class="form-control mb-2" placeholder="Digite seu CEP" required>
                <button type="submit" class="btn btn-primary w-100">Verificar CEP</button>
                <div id="cepResult" class="alert alert-light d-none mt-2"></div>
            </form>

            <form method="post" action="<?= base_url('index.php/carrinho/aplicar_cupom') ?>" class="mb-3">
                <input type="text" name="codigo_cupom" class="form-control mb-2" placeholder="Cupom de desconto" required>
                <button type="submit" class="btn btn-outline-primary w-100">Aplicar Cupom</button>
            </form>

            <?php if (isset($_SESSION['cupom_aplicado'])): ?>
            <div class="alert alert-success">
                Cupom <strong><?= htmlspecialchars($_SESSION['cupom_aplicado']['codigo']) ?></strong> aplicado: -R$ <?= number_format($_SESSION['cupom_aplicado']['valor'], 2, ',', '.') ?>
            </div>
            <?php endif; ?>

            <form id="finalizarPedidoForm" method="post" action="<?= site_url('index.php/pedido/finalizar') ?>">
                <input type="hidden" name="cep" id="finalCep">
                <input type="hidden" name="endereco" id="finalEndereco">

                <div class="row g-2 mb-2">
                    <div class="col">
                        <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                    </div>
                    <div class="col">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Finalizar Pedido</button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#cepForm').on('submit', function(e) {
    e.preventDefault();
    const cep = $('#cep').val().replace(/\D/g, '');

    $.post("<?= site_url('index.php/carrinho/verificar_cep') ?>", { cep }, function(data) {
        const info = JSON.parse(data);
        const cepResult = $('#cepResult');

        if (info.erro) {
            cepResult.removeClass('d-none alert-success').addClass('alert-danger').text('CEP inválido!');
        } else {
            cepResult.removeClass('d-none alert-danger').addClass('alert-success')
                .html(`Endereço: ${info.logradouro}, ${info.bairro}, ${info.localidade} - ${info.uf}`);
        }
    });
});

$('#finalizarPedidoForm').on('submit', function(e) {
    const cep = $('#cep').val();
    const enderecoTexto = $('#cepResult').text();

    if (!cep || !enderecoTexto || enderecoTexto.includes('CEP inválido')) {
        alert('Por favor, verifique seu CEP antes de finalizar o pedido.');
        e.preventDefault();
        return false;
    }

    $('#finalCep').val(cep);
    $('#finalEndereco').val(enderecoTexto);
});
</script>

<?php $this->load->view('layouts/footer'); ?>
</body>
</html>
