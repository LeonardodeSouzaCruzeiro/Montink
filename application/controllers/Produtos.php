<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Estoque_model');
        $this->load->library('session'); 
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
        
    }

    public function index()
    {
        $data['produtos'] = $this->Produto_model->getAll();
        $data['logado'] = $this->session->userdata('logado');
        

        $this->load->view('produtos/index', $data);
        
    }

    public function form($id = null)
    {
        if ($id) {
            $data['produto'] = $this->Produto_model->getById($id);
            $data['estoque'] = $this->Estoque_model->getByProduto($id);
        } else {
            $data['produto'] = null;
            $data['estoque'] = [];
        }
        $this->load->view('produtos/form', $data);
    }

    public function save()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('preco', 'Preço', 'required|decimal');

        $id = $this->input->post('id');
        
        if ($this->form_validation->run() == FALSE) {
            $this->form($id);
        } else {
            $nome = $this->input->post('nome');
            $preco = $this->input->post('preco');

            $foto_nome = null;

            // Upload da foto
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $config['upload_path']   = './uploads/produtos/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size']      = 2048;
                $config['file_name']     = time() . '_' . $_FILES['foto']['name'];

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('foto')) {
                    $error = $this->upload->display_errors();
                    $data['upload_error'] = $error;

                    if ($id) {
                        $data['produto'] = $this->Produto_model->getById($id);
                        $data['estoque'] = $this->Estoque_model->getByProduto($id);
                    } else {
                        $data['produto'] = null;
                        $data['estoque'] = [];
                    }

                    $this->load->view('produtos/form', $data);
                    return;
                } else {
                    $upload_data = $this->upload->data();
                    $foto_nome = $upload_data['file_name'];
                }
            }

            $data = [
                'nome' => $nome,
                'preco' => $preco
            ];

            if ($foto_nome !== null) {
                $data['foto'] = $foto_nome;
            }

            if ($id) {
                $this->Produto_model->update($id, $data);
                $produto_id = $id;
                $this->Estoque_model->deleteByProduto($id);
            } else {
                $produto_id = $this->Produto_model->insert($data);
            }
            
         
            $variacoes = $this->input->post('variacoes');
            if ($variacoes && is_array($variacoes)) {
                foreach ($variacoes as $v) {
                    if (!empty($v['nome']) && isset($v['quantidade'])) {
                        $this->Estoque_model->insert([
                            'produto_id' => $produto_id,
                            'variacao'   => $v['nome'],
                            'quantidade' => $v['quantidade']
                        ]);
                    }
                }
            }

            redirect('index.php/produtos');
        }
    }

    public function delete($id)
    {
        $this->Produto_model->delete($id);
        $this->Estoque_model->deleteByProduto($id);
        redirect('index.php/produtos');
    }
}
