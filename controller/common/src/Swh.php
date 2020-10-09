<?php
if(class_exists('Swh') && Swh::ver()>100) exit;
class Swh{
    static  function ver(){
        return 100;
    }
    static function get_languages(){
        try
        {
            $query = \DB::table('mshop_locale')->select('langid')->groupBy('langid')->having('langid', '>', '')->get();
            return json_decode(json_encode($query->all()),1);
            
        } catch(Exception $e){
            echo $e->getMessage();
        }       
   }
    static function widgets($widgets){
        try
        {
            return Aimeos\Shop\Facades\Shop::get( 'swordbros/widgets' )->getBody($widgets);
            
        } catch(Exception $e){
            return $e->getMessage();
        }       
   }
    
    static function topMenu(){
        $data =  \Aimeos\Shop\Facades\Catalog::uses(['text', 'media'])
                ->getTree();
        if($data->hasChildren()){
            echo '<ul class="">';
            foreach ($data->getChildren() as $main_category) {
                echo '<li class="nav-item"><a href="'.route('aimeos_shop_list',array_merge( ['locale'=> \Route::current()->parameter('locale','ru'), 'currency'=> \Route::current()->parameter('currency','RUB')], ['f_name' => $main_category->getName( 'url' ), 'f_catid' => $main_category->getId()] )).'" class="nav-link">'.$main_category->getName().'</a></li>';
            } 
            echo '</ul>';
        }
    }
    
    static function storeInfo($key=false){
        $store_info['ru']=array(
            'name' => '',
            'address' => 'deneme adresi',
            'phone' => '',
            'whatsapp' => '#',
            'instagram' => '#',
            'vk' => '#',
            'facebook' => '#',
            'twitter' => '#',
            'pinterest' => '#',
            'linkedin' => '#',
            'youtube' => '#',
            'social-ok' => '#',
            'pinme' => '#',
            'google-plus' => '#',
            'copyright' => 'Авторские права © 2020 SWORD BROS. Все права защищены.',
            'map' => [
                'latitude' => '',
                'longitude' => '',
            ],
            'meta' => [
                'title' => 'Online palto store-Paltoru.com',
                'keyword' => 'Женщины, Мужчины,Дети',
                'description' => '',
            ]
        );
        $store_info['en']=array(
            'name' => '',
            'address' => 'deneme',
            'phone' => '',
            'whatsapp' => '',
            'intagram' => '#',
            'vk' => '#',
            'facebook' => '#',
            'twitter' => '#',
            'pinterest' => '#',
            'linkedin' => '#',
            'youtube' => '#',
            'social-ok' => '#',
            'pinme' => '#',
            'google-plus' => '#',
            'copyright' => 'Copyright © 2020 SWORD BROS. All rights reserved.',
            'map' => [
                'latitude' => '',
                'longitude' => '',
            ],
            'meta' => [
                'title' => 'Online palto store-Paltoru.com',
                'keyword' => 'Женщины, Мужчины,Дети',
                'description' => '',
            ]
        );
        $langid = \Route::current()->parameter('locale','ru');
        if(isset($store_info[$langid])){
            if(isset($store_info[$langid][$key])){
                return $store_info[$langid][$key];
            }
        }
        return null;
    }
    
    static function productStars($id, $input_name=''){
        if(!empty($id)){
            $query = \DB::table('mshop_product')->select('id', 'review_count', 'rating')->where('id', $id)->get()->first();
            if($query ){
                return SwH::stars($query->rating, $input_name);
            }
        }
    }

    static function stars($rating=0, $input_name=''){
        $id = rand();
        if($input_name){
            $disabled = '';
        } else{
            $disabled = ' disabled="disabled" readonly="readonly" ';
        }
        return '<div class="rating-box"><ul>
<li'.($rating>=1?'':'class="silver-color"').'><i class="ion-ios-star'.($rating>=1?'':'-outline').'"></i></li>
<li'.($rating>=2?'':'class="silver-color"').'><i class="ion-ios-star'.($rating>=2?'':'-outline').'"></i></li>
<li'.($rating>=3?'':'class="silver-color"').'><i class="ion-ios-star'.($rating>=3?'':'-outline').'"></i></li>
<li'.($rating>=4?'':'class="silver-color"').'><i class="ion-ios-star'.($rating>=4?'':'-outline').'"></i></li>
<li'.($rating>=5?'':'class="silver-color"').'><i class="ion-ios-star'.($rating>=5?'':'-outline').'"></i></li>
</ul></div>';
    }
    
    static function socialBar($class=''){
        $html = '<ul class="star-social-bar m-social-share '.$class.'">
                    <li id="social-twitter">
                        <a href="'.SwH::storeInfo('twitter').'" style="color: white">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li id="social-fb">
                        <a href="'.SwH::storeInfo('facebook').'" style="color: white">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li id="social-pt">
                        <a href="'.SwH::storeInfo('pinterest').'" style="color: white">
                            <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                        </a>
                    </li>
                    <!--<li id="social-ok">
                        <a href="'.SwH::storeInfo('social-ok').'">
                            <i class="fa fa-odnoklassniki" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li id="social-gp">
                        <a href="'.SwH::storeInfo('google-plus').'">
                            <i class="fa fa-google-plus" aria-hidden="true"></i>
                        </a>
                    </li>-->
                    <li id="social-ig">
                        <a href="'.SwH::storeInfo('instagram').'" style="color: white">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    </li>
                    <!--<li id="social-pm">
                        <a href="'.SwH::storeInfo('pinme').'">
                            <img src="/theme/site/images/pinme.png" alt="">
                        </a>
                    </li>-->
                </ul>
';
        return $html;
    }

}
