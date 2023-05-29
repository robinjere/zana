<?php 
 namespace App\Libraries;

class AdminPanel {
    public function panelNav(){
        return view('components/panelnav');
    }

    public function registrationNav(){
        return view('components/registrationnav');
    }
    
    public function noData(){
        return view('components/no-data');
    }

    public function sideBarNavigation(){
        return view('components/sidebar-navigation');
    }

    public function footer(){
        return view('components/footer');
    }

    public function permission(){
        return view('components/permission/permission_nav');
    }

}
    