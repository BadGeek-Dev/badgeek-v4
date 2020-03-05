<?php

class  Articles_model extends CI_Model
{
    public $id;
    public $title;
    public $content;
    public $id_author;
    public $created_at;
    public $status;


    public function insert()
    {
        $this->db->insert('articles', $this);
    }

    public function update()
    {
        $this->db->update('articles', $this, ['id' => $this->id]);
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }


    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }


    /**
     * Get the value of id_author
     */
    public function getIdAuthor()
    {
        return $this->id_author;
    }


    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setIdAuthor($idAuthor)
    {
        $this->title = $idAuthor;
        return $this;
    }



    public function getAllArticles()
    {
        $this->db->select('articles.id,title,content,created_at,username');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
         $query = $this->db->get();
        return $query->result();
    }

    public function getAllArticlesVisible()
    {
        $this->db->select('articles.id,title,content,created_at,username');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
        $this->db->where('status = 1');
        $query = $this->db->get();
        return $query->result();
    }

    public function getArticleByID($id)
    {
        $this->db->select('articles.id,title,content,created_at,status,username');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
        $this->db->where('articles.id =', $id);
        $query = $this->db->get();
        return $query->result()[0];
    }

    public function getFirstArticleVisible()
    {
        $this->db->select('articles.id,title,content,created_at,username');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
        $this->db->where('status = 1');
        $query = $this->db->get();
        return $query->row();
    }

    public function addArticle($title, $content, $id_author, $status)
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $this->db->set('title', $title);
        $this->db->set('content', $content);
        $this->db->set('id_author', $id_author);
        $this->db->set('status', $status);
        $this->db->set('created_at', $date);
        $this->db->insert('articles');

    }
    public function updateArticleByID($id,$title, $content, $status)
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $this->db->set('title', $title);
        $this->db->set('content', $content);
        $this->db->set('status', $status);
        $this->db->set('created_at', $date);
        $this->db->where('id',$id);
        $this->db->update('articles');
    }

    public function deleteArticleByID($id)
    {
        $this->db->delete('articles', array('id'=> $id));
    }

    public function isMultipleArticleVisible(){
        $this->db->select('articles.id');
        $this->db->from('articles');
        $this->db->where('status = 1');
        $query = $this->db->get();
        return $query->num_rows()>0 ? true : false;
    }

    public function getNextArticleVisibleID($id){
        $this->db->select('articles.id');
        $this->db->limit(2);
        $this->db->from('articles');
        $this->db->where('status = 1');
        $this->db->where('articles.id >=', $id);
        $result = $this->db->get()->result();
        if(count($result)==2){
            return $result[1]->id;
        }else{
            return 0;
        }
    }

    public function getPreviousArticleVisibleID($id){
        $this->db->select('articles.id');
        $this->db->limit(2);
        $this->db->from('articles');
        $this->db->order_by('id','DESC');
        $this->db->where('status = 1');
        $this->db->where('articles.id <=', $id);
        $result = $this->db->get()->result();
        if(count($result)==2){
            return $result[1]->id;
        }else{
            return 0;
        }
    }

}