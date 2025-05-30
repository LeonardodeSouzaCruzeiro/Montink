<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrinho extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Cupom_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    private function calcularSubtotal()
    {
        $carrinho = $this->session->userdata('carrinho') ?? [];
        $subtotal = 0;

        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        return $subtotal;
    }

    private function calcularFrete($subtotal)
    {
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            return 15.00;
        } elseif ($subtotal > 200) {
            return 0.00;
        } else {
            return 20.00;
        }
    }

   public function index()
    {
        $carrinho = $this->session->userdata('carrinho') ?? [];

        $subtotal = $this->calcularSubtotal();
        $frete = $this->calcularFrete($subtotal);

        $cupom = $this->session->userdata('cupom_aplicado');
        $valor_cupom = $cupom['valor'] ?? 0;

        $data = [
            'carrinho' => $carrinho,
            'subtotal' => $subtotal,
            'frete'    => $frete,
            'cupom'    => $cupom,
            'desconto' => $valor_cupom,
            'total'    => max(0, $subtotal + $frete - $valor_cupom)
        ];

        $this->load->view('carrinho/index', $data);
    }

    public function adicionar($produto_id)
    {
        $produto = $this->Produto_model->getById($produto_id);
        if (!$produto) {
            show_404();
            return;
        }

        $carrinho = $this->session->userdata('carrinho') ?? [];

        if (isset($carrinho[$produto_id])) {
            $carrinho[$produto_id]['quantidade'] += 1;
        } else {
            $carrinho[$produto_id] = [
                'id'        => $produto->id,
                'nome'      => $produto->nome,
                'preco'     => $produto->preco,
                'quantidade'=> 1
            ];
        }

        $this->session->set_userdata('carrinho', $carrinho);

        redirect('index.php/carrinho');
    }

  

    public function remover($produto_id)
    {
        $carrinho = $this->session->userdata('carrinho') ?? [];
        unset($carrinho[$produto_id]);
        $this->session->set_userdata('carrinho', $carrinho);
        redirect('index.php/carrinho');
    }

    public function limpar()
    {
        $this->session->unset_userdata('carrinho');
        redirect('index.php/carrinho');
    }

    public function verificar_cep()
    {
        $cep = $this->input->post('cep');
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($ch);
        curl_close($ch);

        echo $resposta;
    }

  public function aplicar_cupom()
    {
        $codigo = $this->input->post('codigo_cupom');

        $this->load->model('Cupom_model');
        $cupom = $this->Cupom_model->getByCodigo($codigo);

        if (!$cupom) {
            $this->session->set_flashdata('erro_cupom', 'Cupom inválido.');
        } elseif (strtotime($cupom['validade']) < time()) {
            $this->session->set_flashdata('erro_cupom', 'Cupom expirado.');
        } elseif ($this->calcularSubtotal() < $cupom['valor_minimo']) {
            $this->session->set_flashdata('erro_cupom', 'Cupom exige valor mínimo de R$ ' . number_format($cupom['valor_minimo'], 2, ',', '.'));
        } else {
            $this->session->set_userdata('cupom_aplicado', $cupom);
        }

        redirect('index.php/carrinho');
    }

}
