<?php

class  Articles_model extends CI_Model
{
    public $id;
    public $title;
    public $content;
    public $id_author;
    public $created_at;
    public $picture;
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



    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }


    /**
     * Set the value of picture
     *
     * @return  self
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }



    public function getAllArticles()
    {
        $this->db->select('articles.id,title,content,created_at,status,username');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
         $query = $this->db->get();
        return $query->result();
    }

    public function getAllArticlesVisible()
    {
        $this->db->select('articles.id,title,content,created_at,picture,username');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
        $this->db->where('status = 1');
        $query = $this->db->get();
        return $query->result();
    }

    public function getArticleByID($id)
    {
        $this->db->select('articles.id,title,content,created_at,status,picture,username');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
        $this->db->where('articles.id =', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFirstArticleVisible()
    {
        $this->db->select('articles.id,title,content,created_at,username, picture');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
        $this->db->where('status = 1');
        $this->db->order_by('articles.id DESC');
        $query = $this->db->get();
        return $query->row();
    }

    public function addArticle($title, $content, $id_author, $status, $picture = false)
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $this->db->set('title', $title);
        $this->db->set('content', $content);
        $this->db->set('id_author', $id_author);
        $this->db->set('status', $status);
        $this->db->set('created_at', $date);
        if($picture) $this->db->set('picture', $picture);
        $this->db->insert('articles');

    }

    public function updateArticle($id,$title, $content, $status, $picture = false)
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $this->db->set('title', $title);
        $this->db->set('content', $content);
        $this->db->set('status', $status ? 1 : 0);
        $this->db->set('created_at', $date);
        if($picture) $this->db->set('picture', $picture);
        $this->db->where('id',$id);
        $this->db->update('articles');
    }

    public function deleteArticleByID($id)
    {
        $picture = $this->getArticleByID($id)->picture; 
        if($picture)
        {
            unlink("assets/pictures/news/".$picture);
        }
        return $this->db->delete('articles', array('id'=> $id));
    }
    public function isPreviousNextArticleVisible($id = 39){

        if($id==0){
            $this->db->select('articles.id');
            $this->db->from('articles');
            $this->db->where('status = 1');
            $this->db->limit(1);
            $query=$this->db->get();
            $id=$query->result()[0]->id;
        }

        $this->db->select('articles.id,articles.title');
        $this->db->from('articles');
        $this->db->where('status = 1');
        $this->db->where('articles.id >',$id);
        $query = $this->db->get();
        $next =  $query->num_rows()>0 ? true : false;

        $this->db->select('articles.id,articles.title');
        $this->db->from('articles');
        $this->db->where('status = 1');
        $this->db->where('articles.id <',$id);
        $query = $this->db->get();
        $previous =  $query->num_rows()>0 ? true : false;
        return array('next' =>$next,'previous' => $previous);
    }


  public function  getArticleBySide($id=0,$side='')
  { 
    // question nommage : article suivant /précedent par rapport a l'id et au sens indiqué en parametre
    if($id == 0)
    {
        $article = $this->getFirstArticleVisible();
    }
    else if($side == 'next' || $side == 'previous')
    {
        $this->db->select('articles.id,title,content,created_at,status,username, picture');
        $this->db->from('articles');
        $this->db->join('users', 'articles.id_author = users.id', 'inner');
        $this->db->limit(1);
        if ($side == 'next') 
        {
            $this->db->where('articles.id >', $id);
        }
        else 
        {
            $this->db->where('articles.id <', $id);
            $this->db->order_by('id','DESC');
        }
        $query = $this->db->get();
        $article = $query->row();
        $id = $article->id;
    }
    else
    {
        $article=$this->getArticleByID($id);
    }
    $btnStatus =  $this->isPreviousNextArticleVisible($id);
    return array('article' => $article,'btnStatus' =>$btnStatus);
  }

}