<?php
class News extends CI_Controller 
{

        public function __construct()
        {
                parent::__construct();
                $this->load->model('news_model');
                $this->load->helper('url_helper');
                $this->load->library('form_validation');
        }

        public function index()
        {

        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
        }

        public function view($slug = NULL)
        {
                $data['news_item'] = $this->news_model->get_news($slug);
                if (empty($data['news_item']))
        
        {
                show_404();
        }

        $data['title'] = $data['news_item']['title'];

       $this->load->view('templates/header', $data);
       $this->load->view('news/view', $data);
       $this->load->view('templates/footer');
    
        }
        
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create');
            $this->load->view('templates/footer');
        }
        else
        {
            $data = $this->readFormData();
            $this->news_model->create_news($data);
            $this->load->view('news/success');
        }
    }

    public function update($id)
    {
        $httpMethod = $this->input->server('REQUEST_METHOD');
        
        if ($httpMethod === 'GET') {            
            $record = $this->news_model->get_news_by_id($id);
            $this->showFormData($id, $record);
        }
        else if ($httpMethod === 'POST') {
            $formData = (object)$this->readFormData();
            $this->news_model->update_news($id, $formData);
            $this->showFormData($id, $formData);
        }
    }

   

    private function showFormData($id, $formData)
    {
        // // mostrar formulario con datos del registro
        $data['title'] = 'Edit news item';
        $data['id'] = $id;
        $data['news'] = $formData;
        $this->load->view('templates/header', $data);
        $this->load->view('news/update', $data);
        $this->load->view('templates/footer');
    }

    private function saveData($id)    
    {
            $this->load->helper('form');
    
            $data['title'] = 'Update item';
    
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('text', 'Text', 'required');
    
            if ($this->form_validation->run() !== FALSE)
            {
                $data = $this->readFormData();
                $this->news_model->update_news($id, $data);
                //$this->load->view('news/update');
            }
            
            $data['id'] = $id;
            $this->load->view('templates/header', $data);
            $this->load->view('news/update', $data);
            $this->load->view('templates/footer');
        }
    
    
    
    private function readFormData()
    {
        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        return array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text')
        );
    }

    public function delete($id)
    {
        $this->news_model->delete($id);
        $this->load->view('news/success');
    }
}
