<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('login');
    }

    public function login() {
        $email = $this->input->post('email');
        $senha = md5($this->input->post('senha'));

        $query = $this->db->get_where('usuarios', ['email' => $email, 'senha' => $senha]);

        if ($query->num_rows() === 1) {
            $usuario = $query->row();
            $this->session->set_userdata([
                'usuario_id' => $usuario->id,
                'usuario_nome' => $usuario->nome,
                'logado' => true
            ]);
            redirect('/');
        } else {
            $this->session->set_flashdata('erro', 'E-mail ou senha inválidos');
            redirect('index.php/auth');
        }
    }


    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}
