<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Loja Montink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(-45deg,  black, white,black);
            background-size: 400% 400%;
            animation: gradient 10s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .product-card {
            transition: transform 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .product-img {
            height: 180px;
            object-fit: cover;
            border-radius: .5rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php $this->load->view('layouts/header'); ?>
    <!-- Conteúdo da loja -->
    <div class="container my-5">
        <?php if (!empty($produtos)): ?>
            <div class="row g-4">
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card product-card h-100">
                            <?php if (!empty($produto->foto)): ?>
                                <img src="<?= base_url('uploads/produtos/' . $produto->foto) ?>" alt="<?= htmlspecialchars($produto->nome) ?>" class="card-img-top product-img">
                            <?php else: ?>
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:180px;">
                                    Sem Foto
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($produto->nome) ?></h5>
                                <p class="card-text text-success fw-bold mb-3">R$ <?= number_format($produto->preco, 2, ',', '.') ?></p>
                                <div class="mt-auto d-grid gap-2">
                                    <a href="<?= site_url('index.php/carrinho/adicionar/' . $produto->id) ?>" class="btn btn-success">Comprar</a>
                                    
                                    <?php if ($this->session->userdata('logado')): ?>
                                        <a href="<?= base_url('index.php/produtos/form/' . $produto->id) ?>" class="btn btn-warning">Editar</a>
                                        <a href="<?= base_url('index.php/produtos/delete/' . $produto->id) ?>" class="btn btn-danger" onclick="return confirm('Deseja excluir este produto?')">Excluir</a>
                                    <?php endif; ?>    
                                
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">Nenhum produto cadastrado.</div>
        <?php endif; ?>
    </div>

    <!-- Rodapé -->
    <?php $this->load->view('layouts/footer'); ?>
</body>
</html>
