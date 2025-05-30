<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido_model extends CI_Model {
    public function __construct()
    {
        parent::__construct(); 
        $this->load->database(); 
    }
    public function buscarPedidoPorId($id) {
    return $this->db->get_where('pedidos', ['id' => $id])->row();
}


    public function inserirPedido($dados) {
        $this->db->insert('pedidos', $dados);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function inserirItemPedido($pedido_id, $item) {
        $data = [
            'pedido_id' => $pedido_id,
            'produto_id' => isset($item['id']) ? $item['id'] : null,
            'nome_produto' => $item['nome'],
            'preco_unitario' => $item['preco'],
            'quantidade' => $item['quantidade'],
            'subtotal' => $item['preco'] * $item['quantidade']
        ];
        return $this->db->insert('itens_pedido', $data);
    }

    public function atualizarStatusPedido($pedido_id, $status) {
        $this->db->where('id', $pedido_id);
        return $this->db->update('pedidos', ['status' => $status]);
    }

    public function excluirPedido($pedido_id) {
        $this->db->where('id', $pedido_id);
        return $this->db->delete('pedidos');
    }

    public function getPedidoPorId($pedido_id) {
        $this->db->where('id', $pedido_id);
        $pedido = $this->db->get('pedidos')->row_array();
        if ($pedido) {
            $this->db->where('pedido_id', $pedido_id);
            $pedido['itens'] = $this->db->get('itens_pedido')->result_array();
        }
        return $pedido;
    }
}
