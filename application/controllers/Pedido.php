<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('Pedido_model');
        $this->load->library('session');
    }
    public function index() {
        $data['pedidos'] = $this->db->get('pedidos')->result();
        $this->load->view('pedidos/index', $data);
    }

    public function finalizar() {
        $nome     = $this->input->post('nome');
        $email    = $this->input->post('email');
        $cep      = $this->input->post('cep');
        $endereco = $this->input->post('endereco');

        if (!$nome || !$email || !$cep || !$endereco) {
            show_error('Dados incompletos para finalizar o pedido.', 400);
            return;
        }

        $carrinho = $this->session->userdata('carrinho');

        if (empty($carrinho)) {
            show_error('Carrinho vazio.', 400);
            return;
        }

     
        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
        $frete = 15.00;  
        $desconto = 0.00; 

        $total = $subtotal + $frete - $desconto;

       
        $pedidoData = [
            'nome'       => $nome,
            'email'      => $email,
            'cep'        => $cep,
            'endereco'   => $endereco,
            'subtotal'   => $subtotal,
            'frete'      => $frete,
            'desconto'   => $desconto,
            'total'      => $total,
            'status'     => 'pendente',
            'data_criacao' => date('Y-m-d H:i:s'),
        ];

        
        $pedido_id = $this->Pedido_model->inserirPedido($pedidoData);

        if (!$pedido_id) {
            show_error('Erro ao salvar pedido.', 500);
            return;
        }

        
        foreach ($carrinho as $item) {
            $this->Pedido_model->inserirItemPedido($pedido_id, $item);
        }

        
        $this->session->unset_userdata('carrinho');

        
        $this->load->library('email');

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

if (!$this->email->send()) {
    log_message('error', "Falha ao enviar e-mail do pedido #$pedido_id: " . $this->email->print_debugger());
}

        
        redirect(site_url('index.php/pedido/obrigado/' . $pedido_id));
    }
    public function webhook() {
            header('Content-Type: application/json');

            $id = $this->input->post('id');
            $status = $this->input->post('status');

            if (!$id || !$status) {
                http_response_code(400);
                echo json_encode(['message' => 'ID e status são obrigatórios.']);
                return;
            }

            
            $pedido = $this->db->get_where('pedidos', ['id' => $id])->row();
            if (!$pedido) {
                http_response_code(404);
                echo json_encode(['message' => 'Pedido não encontrado.']);
                return;
            }

            if (strtolower($status) === 'cancelado') {
               
                $this->db->delete('pedidos', ['id' => $id]);
                echo json_encode(['message' => 'Pedido cancelado e removido com sucesso.']);
            } else {
                
                $this->db->update('pedidos', ['status' => $status], ['id' => $id]);
                echo json_encode(['message' => 'Status do pedido atualizado para "' . $status . '".']);
            }
    }

    public function obrigado($id) {
       
        $pedido = $this->Pedido_model->buscarPedidoPorId($id);

        if (!$pedido) {
            show_404();
        }

        $this->load->view('pedidos/obrigado', ['pedido' => $pedido]);
    }



}
