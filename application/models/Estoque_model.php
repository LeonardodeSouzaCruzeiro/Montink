<?php

class Estoque_model extends CI_Model {
    protected $table = 'estoque';

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function deleteByProduto($produto_id) {
        return $this->db->delete($this->table, ['produto_id' => $produto_id]);
    }

    public function getByProduto($produto_id) {
        return $this->db->get_where($this->table, ['produto_id' => $produto_id])->result();
    }
}
