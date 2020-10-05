<?php

class  Aides_model extends CI_Model
{
    public $id;
    public $title;
    public $content;
    public $id_author;
    public $created_at;
    public $visible; //etat de l'aide (visible / non visible). Par défaut 1 pour visible


    public function insert()
    {
        $this->db->insert('aides', $this);
        $this->id = $this->db->insert_id();
    }

    public function update()
    {
        $this->db->update('aides', $this, ['id' => $this->id]);
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
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->created_at;
	}

	/**
	 * @param mixed $created_at
	 */
	public function setCreatedAt($created_at)
	{
		$this->created_at = $created_at;
	}

	/**
	 * @return mixed
	 */
	public function getVisible()
	{
		return $this->visible;
	}

	/**
	 * @param mixed $visible
	 */
	public function setVisible($visible)
	{
		$this->visible = $visible;
	}



    public function getAllAides()
    {
        $this->db->select('aides.id,title,content,created_at,visible,username');
        $this->db->from('aides');
        $this->db->join('users', 'aides.id_author = users.id', 'inner');
         $query = $this->db->get();
        return $query->result();
    }

    public function getAllAidesVisible()
    {
		$this->db->select('aides.id,title,content,created_at,visible,username');
		$this->db->from('aides');
		$this->db->join('users', 'aides.id_author = users.id', 'inner');
		$this->db->where('visible = 1');
		$query = $this->db->get();
		return $query->result();
    }

    public function getAideByID($id)
    {
        $this->db->select('aides.id,title,content,created_at,visible,username');
        $this->db->from('aides');
        $this->db->join('users', 'aides.id_author = users.id', 'inner');
        $this->db->where('aides.id =', $id);
        $query = $this->db->get();
        return $query->result()[0];
    }

    public function addAide($title, $content, $id_author, $visible)
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $this->db->set('title', $title);
        $this->db->set('content', $content);
        $this->db->set('id_author', $id_author);
        $this->db->set('visible', $visible);
        $this->db->set('created_at', $date);
        $this->db->insert('aides');

    }

    public function updateAide($id,$title, $content,$visible)
    {
		$this->db->set('title', $title);
		$this->db->set('content', $content);
		$this->db->set('visible', $visible);
        $this->db->where('id',$id);
        $this->db->update('aides');
    }

    public function deleteAideByID($id)
    {
        return $this->db->delete('aides', array('id'=> $id));

    }

}
