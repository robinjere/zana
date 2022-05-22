<div class="panel-nav">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- <h1 class="mb-0"> <?= getenv('CLINIC_NAME') ?> </h1> -->
        <h1 class="mb-0 title"> <img src="<?= getenv('APP_AUTHOR') ?>" alt="zana healthcare"> <span>PHARMACY</span> </h1>
    
        <div class="panel-nav__profile d-flex align-items-center">
             <div class="profile-icon"> 
                <svg width="38" height="39" viewBox="0 0 38 39" fill="none">
                    <path d="M5.242 30.701C9.43883 28.3289 14.1792 27.0857 19 27.093C24 27.093 28.694 28.403 32.758 30.701M25 15.093C25 16.6843 24.3679 18.2104 23.2426 19.3357C22.1174 20.4609 20.5913 21.093 19 21.093C17.4087 21.093 15.8826 20.4609 14.7574 19.3357C13.6321 18.2104 13 16.6843 13 15.093C13 13.5017 13.6321 11.9756 14.7574 10.8504C15.8826 9.72516 17.4087 9.09302 19 9.09302C20.5913 9.09302 22.1174 9.72516 23.2426 10.8504C24.3679 11.9756 25 13.5017 25 15.093ZM37 19.093C37 21.4568 36.5344 23.7975 35.6298 25.9813C34.7252 28.1652 33.3994 30.1495 31.7279 31.8209C30.0565 33.4924 28.0722 34.8183 25.8883 35.7229C23.7044 36.6274 21.3638 37.093 19 37.093C16.6362 37.093 14.2956 36.6274 12.1117 35.7229C9.92784 34.8183 7.94353 33.4924 6.27208 31.8209C4.60062 30.1495 3.27475 28.1652 2.37017 25.9813C1.46558 23.7975 1 21.4568 1 19.093C1 14.3191 2.89642 9.74075 6.27208 6.3651C9.64773 2.98944 14.2261 1.09302 19 1.09302C23.7739 1.09302 28.3523 2.98944 31.7279 6.3651C35.1036 9.74075 37 14.3191 37 19.093Z" stroke="#3F3F46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
             </div>
            
            <div class="panel-nav__profile--info nav-item dropdown">
                    <p class="m-0 nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= session()->get('first_name') .' '. session()->get('first_name') ?></p>
                    <div class="panel-nav__profile--info__link dropdown-menu">
                        <a class="dropdown-item" href="/user/info/<?= session()->get('id') ?>">My Info</a>
                        <!-- <a class="dropdown-item" href="#">Another action</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/user/logout">Logout</a>
                    </div>
              </div>
        </div><!-- profile -->
    </div><!-- container ---> 
</div>