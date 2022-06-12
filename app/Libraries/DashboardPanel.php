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

    public function NoData(){
        return view('components/no_data');
    }

    public function TodaySales(){
        return view('components/recent_sales');
    } 

    public function NoPermission(){
        return view('components/permission/no_permission');
    }
}