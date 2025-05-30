<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Montink</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding-top: 60px; 
        }

        .navbar-custom {
            background: linear-gradient(to bottom, #000000, #444);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            padding: 0.5rem 1rem;
        }

        .navbar-custom .navbar-brand {
            font-weight: bold;
            color: #fff;
            font-size: 1.5rem;
        }

        .navbar-custom .user-info {
            color: #fff;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .navbar-custom .user-info a {
            color: #fff;
            text-decoration: none;
        }

        .navbar-custom .user-info a:hover {
            color: #f0f0f0;
        }
        .dropdown-menu.custom-dropdown {
            background: linear-gradient(to bottom, #000000, #444);
            color: #fff;
            border: none;
        }

        .dropdown-menu.custom-dropdown a.dropdown-item {
            color: #fff;
        }

        .dropdown-menu.custom-dropdown a.dropdown-item:hover {
            background-color: #222;
            color: #fff;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
    <div class="navbar-left">
         <a href="<?= base_url('/') ?>">
        <img src="<?= base_url('uploads/logo.png') ?>" width="150" height="50"></a>
    </div>
    <div class="navbar-center text-center flex-grow-1">
        <?php if ($this->session->userdata('logado')): ?>
            <a href="<?= base_url('index.php/produtos/form') ?>" class="btn btn-dark"><b><i class="bi bi-plus"></i> Produto</b></a>
        <?php endif; ?>
        <?php if ($this->session->userdata('logado')): ?>
            <a href="<?= base_url('index.php/cupons') ?>" class="btn btn-dark"><b><i class="bi bi-plus"></i> Cupons</b></a>
        <?php endif; ?>
        <?php if ($this->session->userdata('logado')): ?>
            <a href="<?= base_url('index.php/pedido') ?>" class="btn btn-dark"><b><i class="bi bi-cash-coin me-2"></i>Pedidos</b></a>
        <?php endif; ?>
    </div>
    <div class="user-info dropdown">
        <?php if ($this->session->userdata('logado')): ?>
            <a href="#" class="dropdown-toggle d-flex align-items-center text-white text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
               <i class="bi bi-person-circle me-2 fs-3"></i>
                <?= $this->session->userdata('usuario_nome') ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="<?= site_url('index.php/auth/logout') ?>">Sair</a></li>
            </ul>
        <?php else: ?>
            <a href="<?= site_url('index.php/auth') ?>" class="text-white d-flex align-items-center text-decoration-none">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </a>
        <?php endif; ?>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
