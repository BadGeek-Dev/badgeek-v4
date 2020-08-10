<?php


class  Lives_model extends CI_Model
{
    public $id;
    public $created_at;
    public $title;
    public $start_at;
    public $id_member;
    public $status;// 0  : live refuse, 1 : live demandé, 2 : live autorisé
    public $content;
    public $url;

    public function getLives()
    {
        $this->db->select('lives.id,title,content,created_at,start_at,status,url','username');
        $this->db->from('lives');
        $this->db->join('users', 'lives.id_member = users.id', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    public function getLiveByMember($id_member)
    {
        $this->db->select('lives.id,title,content,created_at,start_at,status,url','username');
        $this->db->from('lives');
        $this->db->join('users', 'lives.id_member = users.id', 'inner');
        $this->db->where('lives.id_member =', $id_member);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLiveByStatus($Status)
    {
        $this->db->select('lives.id,title,content,created_at,start_at,status,url','username');
        $this->db->from('lives');
        $this->db->join('users', 'lives.id_member = users.id', 'inner');
        $this->db->where('lives.status =', $Status);
        $query = $this->db->get();
        return $query->result();
    }


    public function getLiveByID($id)
    {
        $this->db->select('lives.id,title,content,created_at,start_at,status,url, username');
        $this->db->from('lives');
        $this->db->join('users', 'lives.id_member = users.id', 'inner');
        $this->db->where('lives.id =', $id);
        $query = $this->db->get();
        return $query->result()[0];
    }


    public function getUsernameByLiveId($id){

        $this->db->select('lives.id,username');
        $this->db->from('lives');
        $this->db->join('users', 'lives.id_member = users.id', 'inner');
        $this->db->where('lives.id =', $id);
        $query = $this->db->get();
        return $query->result()[0]->username;
    }


    public function addLive($title,$content,$start_at,$id_member){

       $date = DateTime::createFromFormat('Y-m-d H:i:s',$start_at);

        $this->db->set('title', $title);
        $this->db->set('content', $content);
        $this->db->set('id_member', $id_member);
        $this->db->set('status', 1);
        $this->db->set('created_at', $date);
        $this->db->set('start_at', $start_at);
        $this->db->insert('lives');

    }


    public function updateLive($id,$title,$content,$start_at,$id_member,$created_at){

        $date = DateTime::createFromFormat('Y-m-d H:i:s',$start_at);

        $this->db->set('title', $title);
        $this->db->set('content', $content);
        $this->db->set('id_member', $id_member);
        $this->db->set('status', 1);
        $this->db->set('created_at', $date);
        $this->db->set('start_at', $start_at);
        $this->db->set('created_at',$created_at);
        $this->db->where('id',$id);
        $this->db->update('lives');

    }

    public function updateStatus($id,$status){

        $this->db->set('status', (int)$status);
        $this->db->where('id',$id);
        $query = $this->db->update('lives');
        return $query;
    }

    public function updateUrl($id,$url){

        $this->db->set('url', $url);
        $this->db->where('id',$id);
        $query = $this->db->update('lives');
        return $query;
    }


    public function insert()
    {
        $this->db->insert('lives', $this);
    }

    public function update()
    {
        $this->db->update('lives', $this, ['id' => $this->id]);
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }


//setStatus


    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->created_at;
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
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($Status)
    {
        $this->status = $Status;

        return $this;
    }

}