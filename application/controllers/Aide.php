<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Aide extends Badgeek_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Aides_model');
	}

	public function index()
	{
		$result = $this->Aides_model->getAllAidesVisible();
		$this->template->load('aide/view', array(
			"result" => $result,
			'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
		));
	}

	private function initBreadcrumbItem($current = false)
	{
		return array(BreadcrumbItem::getBreadcrumbItemAccueil(false), new BreadcrumbItem("Aide","/aide", $current));
	}

	private function getBreadcrumbItems($extra_liste_items)
	{
		if (!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
		return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
	}

}
