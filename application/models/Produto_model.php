<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto_model extends CI_Model {

    public function __construct()
    {
        parent::__construct(); 
        $this->load->database(); 
    }

    public function getAll()
    {
        return $this->db->get('produtos')->result();
    }

    public function getById($id)
    {
        return $this->db->get_where('produtos', ['id' => $id])->row();
    }

    public function insert($data)
    {
        $this->db->insert('produtos', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('produtos', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('produtos', ['id' => $id]);
    }
}
