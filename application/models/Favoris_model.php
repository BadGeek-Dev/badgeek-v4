<?php


class Favoris_model extends CI_Model
{
	public $id;
	public $id_user;
	public $favorites;

	public function insert()
	{
		$this->db->insert('favoris', $this);
	}

	public function update()
	{
		$this->db->update('favoris', $this, ['id' => $this->id]);
	}

	/**
	 * Get the value of id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the value of id_user
	 */
	public function getIdUser()
	{
		return $this->id_user;
	}

	/**
	 * Get the value of favorites
	 */
	public function getFavorites()
	{
		return $this->favorites;
	}

	/**
	 * Set the value of id_user
	 *
	 * @return  self
	 */
	public function setIdUser($id_user)
	{
		$this->id_user = $id_user;

		return $this;
	}

	/**
	 * Set the value of favorites
	 *
	 * @return  self
	 */
	public function setFavorites($favorites)
	{
		$this->favorites = $favorites;

		return $this;
	}

	public function getUserFavorites($id_user){

		$this->db->select('id_user,favorites');
		$this->db->from('favoris');

		$this->db->where('id_user =', $id_user);
		$query = $this->db->get();
		return $query->row();
	}

	public function addUserFavorites($id_user){
		$this->db->set('id_user',$id_user);
		$this->db->set('favorites',"");
		$this->db->insert('favoris');
	}

	public function setUserFavorites($id_user,$favorites){
		$this->db->set('favorites', $favorites);
		$this->db->where('id_user',$id_user);
		$this->db->update('favoris');
	}

}
