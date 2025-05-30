# Mini ERP Montink

> Projeto de teste técnico com controle de pedidos, produtos, cupons e estoque. Desenvolvido com CodeIgniter, PHP e MySQL.

## 📦 Tecnologias Utilizadas

- PHP 8.1.12
- MySQL (via XAMPP)
- CodeIgniter
- HTML, CSS, JavaScript
- phpMyAdmin
- Brevo (SMTP - envio de e-mails)
- ViaCEP (API de verificação de CEP)
- 
## • Crie um banco de dados com 4 tabelas: pedidos, produtos, cupons, estoque
![image](https://github.com/user-attachments/assets/83cc2daa-cdc1-4ff2-8569-92af6e689c0e)![image](https://github.com/user-attachments/assets/0559b7c2-6cf5-4703-a307-8b519edb1ea9)



## • Crie uma tela simples, que permita a criação de produtos, com as seguintes informações: Nome, Preço, Variações e Estoque. O resultado do cadastro, deve gerar associações entre as tabelas produtos e estoques. Permitir o cadastro de variações, e o controle de seus estoques, é um bônus.
![image](https://github.com/user-attachments/assets/27f65d5e-2daa-4fa3-8a62-1423be555638)
![image](https://github.com/user-attachments/assets/21d002ca-6250-4cdb-adf7-641c3ca7c73c)



## • Na mesma tela, permita a opção de update dos dados do produto e do estoque.
![image](https://github.com/user-attachments/assets/f3a26c7a-9daf-4a0d-961b-1634412cbe2d)


## • Com o produto salvo, adicione na mesma tela um botão de Comprar. Ao clicar nesse botão, gerencie um carrinho em sessão, controlando o estoque e valores do pedido. Caso o subtotal do pedido tenha entre R$52,00 e R$166,59, o frete do pedido deve ser R$15,00. Caso o subtotal seja maior que R$200,00, frete grátis. Para outros valores, o frete deve custar R$20,00.

![image](https://github.com/user-attachments/assets/c3fcdf17-b715-4998-9f17-af48a5d23966)![image](https://github.com/user-attachments/assets/74946639-313a-4cc9-b08b-f1af5842983c)
![image](https://github.com/user-attachments/assets/75e38bb8-5a17-46f2-8871-52b2e6664a11)

## • Adicione uma verificação de CEP, utilizando o https://viacep.com.br/
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
![image](https://github.com/user-attachments/assets/651a9227-8276-461c-8f70-f58083b73305)


## • ⁠Crie cupons que podem ser gerenciados por uma tela ou migração. Os cupons devem ter validade e regras de valores mínimos baseadas no subtotal do carrinho.
![image](https://github.com/user-attachments/assets/fc1a0623-4af8-45bb-a9ec-679e18bf6e89)

![image](https://github.com/user-attachments/assets/50e3167a-24dc-4738-87ca-354fd3978cbc)
![image](https://github.com/user-attachments/assets/3efc40fc-ebea-44ee-af35-5dcb19b1a11b)


## • ⁠Adicione um script de envio de e-mail ao finalizar o pedido, com o endereço preenchido pelo cliente.
        $config = [
                   'protocol'    => 'smtp',
                   'smtp_host'   => 'smtp-relay.brevo.com',
                   'smtp_port'   => 587,
                   'smtp_user'   => '8e4e07001@smtp-brevo.com',
                   'smtp_pass'   => 'TNAhb8rPkxKEny2V',
                   'smtp_crypto' => 'tls',
                   'mailtype'    => 'html',
                   'charset'     => 'utf-8',
                   'newline'     => "\r\n",
                   'crlf'        => "\r\n",
            
        ];

        $this->email->initialize($config);
        $this->email->from('cruzeirosouza3@gmail.com', 'Loja Exemplo');
        $this->email->to($email);
        $this->email->subject('Confirmação do pedido #' . $pedido_id);

        $mensagem = "
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <style>
                        body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; color: #333; }
                        .container { background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
                        .titulo { font-size: 20px; font-weight: bold; margin-bottom: 20px; color: #2c3e50; }
                        .info { margin-bottom: 15px; }
                        .label { font-weight: bold; color: #555; }
                        .footer { margin-top: 30px; font-size: 14px; color: #777; text-align: center; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='titulo'>Olá, {$nome}!</div>

                        <p>Seu pedido foi <strong>recebido com sucesso</strong> e está sendo processado.</p>

                        <div class='info'><span class='label'>Pedido nº:</span> {$pedido_id}</div>
                        <div class='info'><span class='label'>Endereço:</span> {$endereco}</div>
                        <div class='info'><span class='label'>CEP:</span> {$cep}</div>
                        <div class='info'><span class='label'>Total:</span> R$ " . number_format($total, 2, ',', '.') . "</div>

                        <p>Você receberá atualizações por e-mail à medida que o status do pedido mudar.</p>

                        <div class='footer'>
                            Obrigado pela sua preferência!<br>
                            <strong>Equipe Montink</strong>
                            
                            
                        </div>
                    </div>
                </body>
                </html>
                ";

        $this->email->message($mensagem);
![image](https://github.com/user-attachments/assets/ba4abe85-c76c-498e-ae4d-2654cb25fe05)

## •⁠Crie um webhook que receberá o ID e o status do Pedido. Caso o status seja cancelado, remova o pedido. Caso o status seja outro, atualize o status em seu pedido.

![image](https://github.com/user-attachments/assets/f7c19e0d-3585-459b-b4f1-f134e26edbc8)

---

## •⁠ 🚀 Como Rodar o Projeto

1. Instale o [XAMPP](https://www.apachefriends.org/pt_br/index.html).
2. Copie o projeto para: C:\xampp8\htdocs\
3. Crie o banco de dados no `phpMyAdmin` com o nome:montink
4. ![image](https://github.com/user-attachments/assets/82ab39cb-12ce-421a-86a9-96bbbf8b5cfb)

       CREATE TABLE `cupons` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `codigo` varchar(50) NOT NULL UNIQUE,
          `valor` decimal(10,2) NOT NULL,
          `validade` date NOT NULL,
          `minimo` decimal(10,2) NOT NULL,
          `created_at` datetime DEFAULT current_timestamp(),
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE `produtos` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `nome` varchar(100) NOT NULL,
          `preco` decimal(10,2) NOT NULL,
          `created_at` datetime DEFAULT current_timestamp(),
          `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `foto` varchar(255),
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE `estoque` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `produto_id` int(11) NOT NULL,
          `variacao` varchar(100),
          `quantidade` int(11) DEFAULT 0,
          PRIMARY KEY (`id`),
          KEY (`produto_id`),
          CONSTRAINT `fk_estoque_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE `usuarios` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `nome` varchar(100),
          `email` varchar(100) UNIQUE,
          `senha` varchar(255),
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE `pedidos` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `nome` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `cep` varchar(20) NOT NULL,
          `endereco` text NOT NULL,
          `subtotal` decimal(10,2) NOT NULL,
          `frete` decimal(10,2) NOT NULL,
          `desconto` decimal(10,2) NOT NULL DEFAULT 0.00,
          `total` decimal(10,2) NOT NULL,
          `status` varchar(50) NOT NULL DEFAULT 'pendente',
          `data_criacao` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE `itens_pedido` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `pedido_id` int(11) NOT NULL,
          `produto_id` int(11),
          `nome_produto` varchar(255) NOT NULL,
          `preco_unitario` decimal(10,2) NOT NULL,
          `quantidade` int(11) NOT NULL,
          `subtotal` decimal(10,2) NOT NULL,
          PRIMARY KEY (`id`),
          KEY (`pedido_id`),
          CONSTRAINT `fk_itens_pedido_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ` 


       
## • Agora Acesse 
    http://localhost/montink/
  ![image](https://github.com/user-attachments/assets/e488d171-3129-494a-abb7-4874d7eef583)

## • Acesse como admin 
         E-mail: admin@admin.com
         Senha:  admin

 ![image](https://github.com/user-attachments/assets/94236a16-1529-4ded-aa1c-83ca4ef9ea16)




