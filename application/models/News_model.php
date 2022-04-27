<?php
class News_model extends CI_Model {

        public function __construct(){
            
                $this->load->database(); 
                $this->load->helper('url');}

public function get_news($slug = FALSE)
{
        if ($slug === FALSE)
        {
                $query = $this->db->get('news');
                return $query->result_array();
        }

        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
}

public function get_news_by_id($id)
{
        $query = $this->db->get_where('news', array('id' => $id));
        return $query->row();
}

public function create_news($data)
{
    return $this->db->insert('news', $data);
}

public function update_news($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('news', $data);
}

public function delete($id)
{
    $this->db->delete('news', array('id' => $id));
}
}