<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cupons extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cupom_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $data['cupons'] = $this->Cupom_model->getAll();
        $this->load->view('cupons/index', $data);
    }

    public function form($id = null) {
        $data['cupom'] = $id ? $this->Cupom_model->getById($id) : null;
        $this->load->view('cupons/form', $data);
    }

    public function save() {
        $this->form_validation->set_rules('codigo', 'Código', 'required');
        $this->form_validation->set_rules('valor', 'Valor', 'required|numeric');
        $this->form_validation->set_rules('validade', 'Validade', 'required');
        $this->form_validation->set_rules('minimo', 'Valor Mínimo', 'required|numeric');

        $id = $this->input->post('id');

        if ($this->form_validation->run() === FALSE) {
            $this->form($id);
        } else {
            $data = [
                'codigo'   => strtoupper($this->input->post('codigo')),
                'valor'    => $this->input->post('valor'),
                'validade' => $this->input->post('validade'),
                'minimo'   => $this->input->post('minimo'),
            ];

            if ($id) {
                $this->Cupom_model->update($id, $data);
            } else {
                $this->Cupom_model->insert($data);
            }

            redirect('index.php/cupons');
        }
    }

    public function delete($id) {
        $this->Cupom_model->delete($id);
        redirect('index.php/cupons');
    }
}
