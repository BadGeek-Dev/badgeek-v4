<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class User extends Badgeek_Controller 
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('badgeek/index');
        }
    }

    /**
     * 
     */
    public function index()
    {
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'helper']);

        if ($this->input->post()) {
            foreach(['navi'] as $attribute) {
                $new_preferences[$attribute] = $this->input->post($attribute);
                $this->helper->set_user_prefs($new_preferences);
            }
        }

        $prefs = $this->helper->get_user_prefs();
        $attributes = [
            [
                'type' => 'checkbox',
                'name' => 'navi',
                'id' => 'navi',
                'label' => 'Hey you !',
                'class' => 'form-control hosted',
                'value' => TRUE,
            ]
        ];

        foreach($attributes as $index => $attribute) {
            if (isset($prefs[$attribute['name']]) && $prefs[$attribute['name']]) {
                $attributes[$index]['checked'] = true; 
            }
        }


        $this->template->load('user/pref', [
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true),
            'attributes' => $attributes
        ]);
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Utilisateur", "/utilisateur", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}