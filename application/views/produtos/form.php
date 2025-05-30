<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= isset($produto) ? 'Editar Produto' : 'Cadastrar Produto' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #f8f9fa, #e9ecef, #fdfdfd);
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .form-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="p-4">
<?php $this->load->view('layouts/header'); ?>

<div class="container mt-5">
    <h6 class="text-center mb-4"><?= isset($produto) ? 'Editar Produto' : 'Novo Produto' ?></h6>

    <div class="card p-4">
        <form action="<?= base_url('index.php/produtos/save') ?>" method="post" enctype="multipart/form-data">
            
            <!-- Informações do Produto -->
            <div class="mb-3">
                <label for="nome" class="form-label">📝 Nome do Produto</label>
                <input type="text" class="form-control" id="nome" name="nome" required value="<?= isset($produto) ? $produto->nome : '' ?>">
            </div>
            <div class="row mb-2 variacao-item">
                <div class="col">
                    <label for="preco" class="form-label">💰 Preço</label>
                    <input type="number" step="0.01" class="form-control" id="preco" name="preco" required value="<?= isset($produto) ? $produto->preco : '' ?>">
                </div>

                <div class="col">
                    <label for="foto" class="form-label">📷 Foto do Produto</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                    <?php if (isset($produto) && $produto->foto): ?>
                        <img src="<?= base_url('uploads/produtos/' . $produto->foto) ?>" alt="Foto do Produto" class="img-thumbnail mt-2" width="150">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Variações e Estoque -->
            <hr>
            <div class="form-label">📦 Variações e Estoque</div>
            <div id="variacoes-container">
                <?php if (isset($estoque) && count($estoque) > 0): ?>
                    <?php foreach ($estoque as $index => $item): ?>
                        <div class="row mb-2 variacao-item">
                            <div class="col">
                                <input type="text" name="variacoes[<?= $index ?>][nome]" class="form-control" value="<?= $item->variacao ?>" required placeholder="Ex: Tamanho M">
                            </div>
                            <div class="col">
                                <input type="number" name="variacoes[<?= $index ?>][quantidade]" class="form-control" value="<?= $item->quantidade ?>" required placeholder="Quantidade">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row mb-2 variacao-item">
                        <div class="col">
                            <input type="text" name="variacoes[0][nome]" class="form-control" required placeholder="Ex: Tamanho M">
                        </div>
                        <div class="col">
                            <input type="number" name="variacoes[0][quantidade]" class="form-control" required placeholder="Quantidade">
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <button type="button" class="btn btn-outline-secondary btn-sm mb-3" onclick="addVariacao()">
                ➕ Adicionar Variação
            </button>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    💾 Salvar Produto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let count = <?= isset($estoque) ? count($estoque) : 1 ?>;
function addVariacao() {
    const html = `
    <div class="row mb-2 variacao-item">
        <div class="col">
            <input type="text" name="variacoes[${count}][nome]" class="form-control" required placeholder="Variação">
        </div>
        <div class="col">
            <input type="number" name="variacoes[${count}][quantidade]" class="form-control" required placeholder="Quantidade">
        </div>
    </div>`;
    document.getElementById('variacoes-container').insertAdjacentHTML('beforeend', html);
    count++;
}
</script>

<?php $this->load->view('layouts/footer'); ?>
</body>
</html>
