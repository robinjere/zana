<?php 
 namespace App\Libraries;

class DashboardPanel {
    public function TopNavigation(){
        return view('components/top_navigation');
    }

    // public function registrationNav(){
    //     return view('components/registrationnav');
    // }

    public function Footer(){
        return view('components/footer');
    }

    public function SideBarNavigation(){
        return view('components/sidebar_navigation');
    }

    public function alert(array $params = []){
        $data['validation'] = empty($params)? '' : $params['validation'];
        return view('dashboard/display_errors', $data);
    }
    
    public function NoData(){
        return view('components/no_data');
    }

    public function TodaySales(){
        return view('components/recent_sales');
    } 

    public function NoPermission(){
        return view('components/permission/no_permission');
    }

    public function ClinicNav(){
        return view('clinic/nav');
    }

    public function RefersNav(){
        return view('reffers/nav');
    }
}