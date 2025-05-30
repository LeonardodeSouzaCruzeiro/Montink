<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cupom_model extends CI_Model {

    public function __construct() {
        parent::__construct();
         $this->load->database();
    }

    public function getAll() {
        return $this->db->get('cupons')->result();
    }

    public function getById($id) {
        return $this->db->get_where('cupons', ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('cupons', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('cupons', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('cupons');
    }

    public function getByCodigo($codigo)
    {
        return $this->db->get_where('cupons', ['codigo' => $codigo])->row_array();
    }
}
