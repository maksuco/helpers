<?php
namespace Maksuco\Helpers\Traits;

trait Tailwind {

  //npx tailwindcss -i ./resources/assets/scss/tw-base.css -o ./public/assets/css/backendTW.css --all --watch --min
    function tailwindPHP($config = []) {
        //GET FILES
        ob_start();
        //error return to before or find way to add @layer(xxx)
        $dir = dirname(__DIR__)."/Assets/tailwind/";
				var_dump($dir);die;
        include $dir.'functions.php';
        $config = prepareArray($config);
        include $dir.'tailwind.php';

        echo "@layer components {";
          include $dir.'utilities.php';
          include $dir.'btn-badges.php';
          include $dir.'forms.php';
          include $dir.'boxes.php';
          include $dir.'dropdowns.php';
          include $dir.'other.php';
          $backend = backendConfig($config);
          if($config['backend']){
            include $dir.'backend.php';
          }
          if($config['backend'] || $config['components']==true){
            include $dir.'components.php';
          }
          include $dir.'code.php';
          include $dir.'packages/iziToast.scss';
          if($config['emails']==true){
            include $dir.'emails.php';
          }
          // if(!empty($config['extraFiles'])){
          //     $config['extraFiles'] = (is_array($config['extraFiles']))? $config['extraFiles'] : explode(",", $config['extraFiles']);
          //     foreach($config['extraFiles'] as $file){
          //         //var_dump($file);
          //         //$path = resource_path($file);
          //         include $file;
          //     }
          // }
          foreach($config['extraFiles'] as $file){
            include $file;
          }
        echo "}";
        
        try {
          $filename = (!empty($config['filename']))? $config['filename'] : 'tw_helpers.css';
          $fileContent = ob_get_clean();
          //SCSS
          $scss = new \ScssPhp\ScssPhp\Compiler();
          $css = $scss->compile($fileContent);
          $fileContent = str_replace('@charset "UTF-8";', '', $css);
          //SAVE
          if(!empty($config['path'])) {
          } elseif(class_exists("Illuminate\Foundation\Application")) {
              $config['path'] = resource_path('css/'.$filename);
          } else {
              $config['path'] = 'assets/css/'.$filename;
          }
          file_put_contents($config['path'], $fileContent);
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }
        return true;
    }


}
