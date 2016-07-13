# xmodule
easiest modular PHP framework...

Core modules


Database
Database module for easy access database or generating queries via active records. Database connection can be set in app/config.php
$db=module('database');
$db will be object with all active records from CodeIgniter Database class
<?php
                
    $db=module('database');
                
    //selecting all posts from posts table
    $posts=$db->query("SELECT * FROM posts")->result_array();
                
    print_r($posts);
                
?>
            
<?php
                
    $db=module('database');
                
    //preparing data for insert
    $for_insert=array(
        'title'=>'Simple post title',
        'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...',
        'created'=>date('Y-m-d H:i:s')
    );
                
    //inserting record in posts table
    if($db->insert('posts',$for_insert)){
        echo 'record inserted in database';
    }
                
?>
            
EllisLab, Inc.
https://ellislab.com/
Language
Language module is for easy adding multilanguage site logic. Language files can be stored in "app/languages/" folder and need to be JSON file.
$language=module('language');
$language will return object with all keys of language fales and method for loading diferent language.
<?php
                
    $language=module('language');
                
    //loading language file
    $language->load('en');
                
?>
            
<?php
                
    //init language module
    $language=module('language');
                
    //loading language file
    $language->load('en');
                
    //adding language keys in $lang variable
    $lang=$language->lang;
                
?>

<h1>
    <?php echo $lang->welcome; ?> - <?php echo $lang->site_name; ?>
</h1>

            
Mihajlo Siljanoski
https://mk.linkedin.com/in/msiljanoski
Rest
Rest module will provide JSON response for API services or ajax calls.
$rest=module('rest');
$rest will be an object with "response()" method.
<?php
    
    //init rest module
    $rest=module('rest');
    
    //example of use for regular response
    $rest->response(array('msg'=>'User registered!'));
                
?>
            
<?php
    
    //init rest module
    $rest=module('rest');
    
    //example of use for error response
    $rest->response(array('msg'=>'User already registered!'),false);
                
?>

            
Mihajlo Siljanoski
https://mk.linkedin.com/in/msiljanoski
URL
URL module can be used for URL helping, redirections, handling URI segments etc.
$url=module('url');
$url will return object with a lot methods.
<?php
    
    //init url module
    $url=module('url');
    
    //example of use base_url() method
    $url->base_url();
    
    //will return base path of framework instalation ex. http://localhost/mysite/
                
?>
            
<?php
    
    //init url module
    $url=module('url');
    
    //example of use current_url() method
    $url->current_url();
    
    //will return current url path of currently opened page 
    //ex. http://localhost/mysite/products/school/notebook?id=1
                
?>
            
<?php
    
    //init url module
    $url=module('url');
    
    //example of use site_url() method
    $url->site_url('products/school');
    
    //will return base path with page URI path 
    //ex. http://localhost/mysite/products/school
                
?>
            
<?php
    
    //init url module
    $url=module('url');
    
    //example of use redirect() method
    if(/* check for logged user */){
        //some code
    }
    else{
        $url->redirect('user/login');
    }
                
?>
            
<?php
    
    //init url module
    $url=module('url');
    
    //example of use segment() method
    $url_segment=$url->segment(4);
    
    //if we have url like this http://mypage.com/category/products/school/notebook/cart
    //$url_segment will be notebook , 5 will be cart, 2 will be products etc...
    
                            
?>
            
Mihajlo Siljanoski
https://mk.linkedin.com/in/msiljanoski
User
With User module you can do a lot of things associated with users functionalities.
$user=module('user');
$user object will contains following methods:
<?php
    
    //init user module , this also will create 2 tables in databse for users
    $user=module('user');
    
    //example for creating new user
    
    $new_user = $user->create(
        array(
            'username' => 'testuser',
            'password' => 't35tp@$w0rd',
            //'role'=>'admin',//optional default is 'user'
            'more' => array(  //optional if you like to add dynamicly more infos about that user
                'email'=> 'john.smith@example123.mk',
                'name' => 'John',
                'surname' => 'Smith',
                'address' => 'Partizanski Odredi bb',
                'city' => 'Skopje',
                'country' => 'Macedonia',
                'another_field' => 'bla bla 1',
                'and_another_field' => 'bla bla 2'
            )
        )
    );
    
    //now printing inserted user data in database.
    //note: password will be stored in db as an md5 hash string 
    print_r($new_user);
    
?>
            
<?php
    
    //init user module 
    $user=module('user');
    
    //example for updaing existing user.., very similar as insert
    //first parametar is user_id we want to update
    
    $updateduser=$user->update(7,array(
        'more'=>array(
            'another_field'=>false,//to delete from more
            'surname'=>'Smith',//to delete from more
            'name'=>'George'
        )
    ));

    //now printing updated user data in database.
    print_r($updateduser);
    
?>
            
<?php
    
    //init user module 
    $user=module('user');
    
    //example for deleting existing user..
    //first parametar is user_id we want to delete
    
    $user->delete(4);
    
?>
            
<?php
    
    //init user module 
    $user=module('user');
    
    //example for fatching user/s data from db..
    //first parametar is user_id we want to fatch
    
    $oneUser = $user->get(7);
    
    print_r($users);
    
    //example if we like to fatch all users with role "admin"
    
    $users = $user->get('admin','role');
    
    print_r($users);
    
?>
            
<?php
    
    //init user module 
    $user=module('user');
    
    //example for using "is_logged", "auth" and "get_auth_user" methods..
    if(!$user->is_logged()){
        if($user->auth('testuser','t35tp@$w0rd')){
            print_r($user->get_auth_user());
        }
        else{
            echo 'auth failed!';
        }
    }
    
?>
            
<?php
    
    //init user module 
    $user=module('user');
    
    //init url module
    $url=module('url');
    
    //example for using "destroy" user session method..
    
    if($url->segment(2)=='logout'){
        $user->destroy();
        $url->redirect('user/login');
    }
    
?>
            
Mihajlo Siljanoski
https://mk.linkedin.com/in/msiljanoski
View
View module can be used for loading view or parts of view on some page.
$view=module('view');
$view will return object with a 2 methods: "load" and "get". Every method has 2 arguments: path to template file and data needs on view.
<?php
    
    //init view module
    $view=module('view');
    
    //example of use get() method
    $content=$view->get('themes/dark/header.php',array('title'=>'Example website'));
    echo $content
    
    //example of use load() method
    $view->load('themes/dark/header.php',array('content'=>'...example content...'));
                
?>
            
Mihajlo Siljanoski
https://mk.linkedin.com/in/msiljanoski
