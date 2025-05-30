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
![image](https://github.com/user-attachments/assets/5d19ea1e-012c-47fc-8f1d-9c9ec59d972b)![image](https://github.com/user-attachments/assets/b05dc9db-c930-45f9-a0f7-10d3c5eb9a02)

## • Crie uma tela simples, que permita a criação de produtos, com as seguintes informações: Nome, Preço, Variações e Estoque. O resultado do cadastro, deve gerar associações entre as tabelas produtos e estoques. Permitir o cadastro de variações, e o controle de seus estoques, é um bônus.
![image](https://github.com/user-attachments/assets/a3d5879e-dda6-41d5-8543-addff885a354)![image](https://github.com/user-attachments/assets/e400f87d-01dc-4a7e-a454-6aa3ff24cb15)

## • Na mesma tela, permita a opção de update dos dados do produto e do estoque.
![image](https://github.com/user-attachments/assets/abd7dfda-d5ac-4281-b4ce-d62e54df0cb2)

## • Com o produto salvo, adicione na mesma tela um botão de Comprar. Ao clicar nesse botão, gerencie um carrinho em sessão, controlando o estoque e valores do pedido. Caso o subtotal do pedido tenha entre R$52,00 e R$166,59, o frete do pedido deve ser R$15,00. Caso o subtotal seja maior que R$200,00, frete grátis. Para outros valores, o frete deve custar R$20,00.

![image](https://github.com/user-attachments/assets/ebd4b266-2889-452e-bab8-11af89d38a60)
![image](https://github.com/user-attachments/assets/75e38bb8-5a17-46f2-8871-52b2e6664a11)

## • Adicione uma verificação de CEP, utilizando o https://viacep.com.br/

![image](https://github.com/user-attachments/assets/babd2f66-b113-42be-87b0-09a0737ea4e9)
![image](https://github.com/user-attachments/assets/0636b549-d14b-47a9-b9b9-684d9555bcc3)

## • ⁠Crie cupons que podem ser gerenciados por uma tela ou migração. Os cupons devem ter validade e regras de valores mínimos baseadas no subtotal do carrinho.
![image](https://github.com/user-attachments/assets/fd0d3ac0-5902-4737-bd23-8dafadb41a84)
![image](https://github.com/user-attachments/assets/50e3167a-24dc-4738-87ca-354fd3978cbc)

## • ⁠Adicione um script de envio de e-mail ao finalizar o pedido, com o endereço preenchido pelo cliente.
![image](https://github.com/user-attachments/assets/142b89dc-2e0e-4964-85f0-449b39634dd7)
![image](https://github.com/user-attachments/assets/ba4abe85-c76c-498e-ae4d-2654cb25fe05)

## •⁠Crie um webhook que receberá o ID e o status do Pedido. Caso o status seja cancelado, remova o pedido. Caso o status seja outro, atualize o status em seu pedido.

![image](https://github.com/user-attachments/assets/f7c19e0d-3585-459b-b4f1-f134e26edbc8)

---

## •⁠ 🚀 Como Rodar o Projeto

1. Instale o [XAMPP](https://www.apachefriends.org/pt_br/index.html).
2. Copie o projeto para: C:\xampp8\htdocs\
3. Crie o banco de dados no `phpMyAdmin` com o nome:montink
4. ![image](https://github.com/user-attachments/assets/82ab39cb-12ce-421a-86a9-96bbbf8b5cfb)

    ` CREATE TABLE `cupons` (
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




