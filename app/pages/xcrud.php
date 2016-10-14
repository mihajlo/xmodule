<?php

if($config['environment']!='development'){
    exit();
}

$url = module('url');
$jq = module('jquery');

if(@$_POST){
    $messages=[];
    
    if(!file_exists(APPPATH.'pages/'.@$_POST['crud_name'].'.php')){
        $content='<?php

//init "view" module
$view = module(\'view\');
//init "url" module
$url = module(\'url\');
//init "storage" module
$storage = module(\'storage\');
//init "validation" module
$validation=module(\'validation\');


$storage->create_table(\''.@$_POST['crud_name'].'\');


//------------------->   action messages

$action_message = false;

if ($url->segment(2) == \'action\' && $url->segment(3) == \'delete\') {
    $action_message = \''.@$_POST['crud_name'].' has been deleted!\';
} 
else if ($url->segment(2) == \'action\' && $url->segment(3) == \'insert\') {
    $action_message = \''.@$_POST['crud_name'].' has been added!\';
} 
else if ($url->segment(2) == \'action\' && $url->segment(3) == \'edit\') {
    $action_message = \''.@$_POST['crud_name'].' has been updated!\';
}






//------------------->   handling actions
if(in_array($url->segment(2), [\'add\',\'edit\',\'delete\'])){
    include_once \''.@$_POST['crud_name'].'_crud/\'.$url->segment(2).\'.php\';
}




//------------------->   handling views

if (!$url->segment(2) || $url->segment(2) == \'action\') {
    if(@$_GET){
        $search_parms=[];
        foreach(@$_GET as $search_k=>$search_v){
            if($search_v){
                $search_parms[$search_k.\'%\']=$search_v;
            }
        }
        $results=$storage->get(\''.@$_POST['crud_name'].'\',$search_parms);
    }
    else{
        $results=$storage->get(\''.@$_POST['crud_name'].'\');
    }
    $view->load("themes/generated/'.@$_POST['crud_name'].'/list.php", [
        \'url\' => $url,
        \''.@$_POST['crud_name'].'s\' => $results,
        \'action_msg\' => $action_message,
        \'jquery\'=>module(\'jquery\')
    ]);
} 


else if ($url->segment(2) == \'add\') {
    $view->load("themes/generated/'.@$_POST['crud_name'].'/add.php", [
        \'url\' => $url,
        \'action_msg\' => $action_message
    ]);
}

else if ($url->segment(2) == \'edit\' && $url->segment(3)) {
    $'.@$_POST['crud_name'].'=$storage->get(\''.@$_POST['crud_name'].'\',[\'_id\'=>$url->segment(3)]);
    $'.@$_POST['crud_name'].'=$'.@$_POST['crud_name'].'[0];
    $view->load("themes/generated/'.@$_POST['crud_name'].'/edit.php", [
        \'url\' => $url,
        \'action_msg\' => $action_message,
        \''.@$_POST['crud_name'].'\'=>$'.@$_POST['crud_name'].'
    ]);
}

else if ($url->segment(2) == \'view\' && $url->segment(3)) {
    $'.@$_POST['crud_name'].'=$storage->get(\''.@$_POST['crud_name'].'\',[\'_id\'=>$url->segment(3)]);
    $'.@$_POST['crud_name'].'=$'.@$_POST['crud_name'].'[0];
    $view->load("themes/generated/'.@$_POST['crud_name'].'/view.php", [
        \'url\' => $url,
        \'action_msg\' => $action_message,
        \''.@$_POST['crud_name'].'\'=>$'.@$_POST['crud_name'].'
    ]);
}';
        @file_put_contents(APPPATH.'pages/'.@$_POST['crud_name'].'.php',$content);
        $messages[]='Created file: '.APPPATH.'pages/'.@$_POST['crud_name'].'.php'.PHP_EOL;
    }
    
    
    
    
    if(!file_exists(APPPATH.'pages/'.@$_POST['crud_name'].'_crud')){
        @mkdir(APPPATH.'pages/'.@$_POST['crud_name'].'_crud');
        $messages[]='Created dir:  '.APPPATH.'pages/'.@$_POST['crud_name'].'/'.PHP_EOL;
    }
    
    if(!file_exists(APPPATH.'pages/'.@$_POST['crud_name'].'_crud/add.php')){
        $content='<?php

if (';
        //isset($_POST[\'name\']) && isset($_POST[\'surname\'])';
        $tmp=[];
        foreach(@$_POST['crud_field'] as $item){
            $tmp[]='isset($_POST[\''.$item.'\'])';
        }
    
        $content.=implode(' && ',$tmp);
        
    $content.=') {

    $validation->addSource($_POST);
';
    foreach(@$_POST['crud_field'] as $item){
        $content.='    $validation->addRule(\''.$item.'\', \'string\', true, 1, 255, true);'.PHP_EOL;
    }
    //$validation->addRule(\'name\', \'string\', true, 1, 255, true);
    //$validation->addRule(\'surname\', \'string\', true, 1, 255, true);

$content.='
    $validation->run();

    if (count($validation->errors) > 0) {
        foreach($validation->errors as $error){
            $action_message .= \'<p>\' . $error . \'</p>\';
        }
    } 
    else {
        $inserted_data = $storage->insert(
                \''.@$_POST['crud_name'].'\', [
';
        foreach(@$_POST['crud_field'] as $item){
                $content.='                    \''.$item.'\' => trim(addslashes(strip_tags($_POST[\''.$item.'\']))),'.PHP_EOL;
            }
$content.='
                ]
        );
        $url->redirect(\''.@$_POST['crud_name'].'/action/insert\');
    }
}';
        
        @file_put_contents(APPPATH.'pages/'.@$_POST['crud_name'].'_crud/add.php', $content);
        $messages[]='Created file: '.APPPATH.'pages/'.@$_POST['crud_name'].'/add.php'.PHP_EOL;
    }
    
    
    if(!file_exists(APPPATH.'pages/'.@$_POST['crud_name'].'_crud/delete.php')){
        $content='<?php

$storage->delete(\''.@$_POST['crud_name'].'\', [\'_id\' => $url->segment(3)]);
$url->redirect(\''.@$_POST['crud_name'].'/action/delete\');';
        @file_put_contents(APPPATH.'pages/'.@$_POST['crud_name'].'_crud/delete.php', $content);
        $messages[]='Created file: '.APPPATH.'pages/'.@$_POST['crud_name'].'/delete.php'.PHP_EOL;
    }
    
    if(!file_exists(APPPATH.'pages/'.@$_POST['crud_name'].'_crud/edit.php')){
        $content='<?php

if (';
        //isset($_POST[\'name\']) && isset($_POST[\'surname\'])';
        $tmp=[];
        foreach(@$_POST['crud_field'] as $item){
            $tmp[]='isset($_POST[\''.$item.'\'])';
        }
        $tmp[]='$url->segment(3)';
    
        $content.=implode(' && ',$tmp);
        
    $content.=') {

    $validation->addSource($_POST);

';
    foreach(@$_POST['crud_field'] as $item){
        $content.='    $validation->addRule(\''.$item.'\', \'string\', true, 1, 255, true);'.PHP_EOL;
    }
    //$validation->addRule(\'name\', \'string\', true, 1, 255, true);
    //$validation->addRule(\'surname\', \'string\', true, 1, 255, true);

$content.='

    $validation->run();

    if (count($validation->errors) > 0) {
        foreach ($validation->errors as $error) {
            $action_message .= \'<p>\' . $error . \'</p>\';
        }
    } else {
        $storage->update(
                \''.@$_POST['crud_name'].'\', [
';
        foreach(@$_POST['crud_field'] as $item){
                $content.='                    \''.$item.'\' => trim(addslashes(strip_tags($_POST[\''.$item.'\']))),'.PHP_EOL;
            }
$content.='
                ], 
                [_id => $url->segment(3)]
        );
        $url->redirect(\''.@$_POST['crud_name'].'/action/edit\');
    }
}
';
        @file_put_contents(APPPATH.'pages/'.@$_POST['crud_name'].'_crud/edit.php', $content);
        $messages[]='Created file: '.APPPATH.'pages/'.@$_POST['crud_name'].'/edit.php'.PHP_EOL;
    }
    
    
    if(!file_exists('themes/generated')){
        @mkdir('themes/generated');
        $messages[]='Created dir:  ./themes/generated/'.PHP_EOL;
    }
    
    if(!file_exists('themes/generated/'.@$_POST['crud_name'].'')){
        @mkdir('themes/generated/'.@$_POST['crud_name'].'');
        $messages[]='Created dir:  ./themes/generated/'.@$_POST['crud_name'].'/'.PHP_EOL;
    }
    
    if(!file_exists('themes/generated/'.@$_POST['crud_name'].'/add.php')){
         $content='<!DOCTYPE html>
<html lang="en">
    <head>
        <title>'.@$_POST['crud_name'].'</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>

        <div class="container">

            <h2>Add '.@$_POST['crud_name'].'</h2>  
            <?php if($action_msg){?>
            <div class="alert alert-danger">
                <?php echo $action_msg;?>
            </div>
            <?php }?>
            <form role="form" method="post" action="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/add\') ?>" >';
                foreach(@$_POST['crud_field'] as $item){
                $content.= '<div class="form-group">
                    <label for="'.$item.'">'.$item.':</label>
                    <input type="text" class="form-control" id="'.$item.'" name="'.$item.'" value="<?php echo @$_POST[\''.$item.'\'];?>">
                </div>';
                }
                $content.='                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Insert</button>
                <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'\') ?>" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</a>
            </form>
        </div>

    </body>
</html>';
         @file_put_contents('themes/generated/'.@$_POST['crud_name'].'/add.php', $content);
        $messages[]='Created file: ./themes/generated/'.@$_POST['crud_name'].'/add.php'.PHP_EOL;
    }
    
    if(!file_exists('themes/generated/'.@$_POST['crud_name'].'/edit.php')){
        $content='<!DOCTYPE html>
<html lang="en">
    <head>
        <title>'.@$_POST['crud_name'].'</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>

        <div class="container">

            <h2>Edit '.@$_POST['crud_name'].'</h2>  
            <?php if($action_msg){?>
            <div class="alert alert-danger">
                <?php echo $action_msg;?>
            </div>
            <?php }?>
            <form role="form" method="post" action="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/edit/\'.$'.@$_POST['crud_name'].'[\'_id\']) ?>" >';
        foreach(@$_POST['crud_field'] as $item){        
        $content.='                <div class="form-group">
                    <label for="'.$item.'">'.$item.':</label>
                    <input type="text" class="form-control" id="'.$item.'" name="'.$item.'" value="<?php if(isset($_POST[\''.$item.'\'])){ echo @$_POST[\''.$item.'\'];} else{ echo $'.@$_POST['crud_name'].'[\''.$item.'\'];}?>">
                </div>';
        }
                $content.='                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Save</button>
                <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'\') ?>" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</a>
            </form>
        </div>

    </body>
</html>';
        @file_put_contents('themes/generated/'.@$_POST['crud_name'].'/edit.php', $content);
        $messages[]='Created file: ./themes/generated/'.@$_POST['crud_name'].'/edit.php'.PHP_EOL;
    }
    
    
    if(!file_exists('themes/generated/'.@$_POST['crud_name'].'/view.php')){
        $content='<!DOCTYPE html>
<html lang="en">
    <head>
        <title>'.@$_POST['crud_name'].'</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>

        <div class="container">
            <h2>View '.@$_POST['crud_name'].'</h2> 
                
            ';
foreach(@$_POST['crud_field'] as $item){   
$content.='                <div class="form-group">
                    <label>'.$item.':</label>
                    <span><?php echo $'.@$_POST['crud_name'].'[\''.$item.'\'];?></span>
                </div>';
}               

$content.='            <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/edit/\'.$'.@$_POST['crud_name'].'[\'_id\']); ?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
            <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/delete/\'.$'.@$_POST['crud_name'].'[\'_id\']); ?>" onclick="return confirm(\'are you sure to delete\')" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete</a>
            <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'\') ?>" class="btn btn-default"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</a>
        </div>

    </body>
</html>';
        @file_put_contents('themes/generated/'.@$_POST['crud_name'].'/view.php', $content);
        $messages[]='Created file: ./themes/generated/'.@$_POST['crud_name'].'/view.php'.PHP_EOL;
    }
    
    
   if(!file_exists('themes/generated/'.@$_POST['crud_name'].'/list.php')){
       
       $content='<!DOCTYPE html>
<html lang="en">
    <head>
        <title>'.@$_POST['crud_name'].'</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
        <?php echo $jquery->load(\'1.12.4\');?>
        <script>
          $(document).ready(function() {
            $(\'#'.@$_POST['crud_name'].'_results\').DataTable();
            } );
        </script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">
            <h2>Manage '.@$_POST['crud_name'].'</h2>
            <hr>
            
            <div class="row">
                <div class="col-sm-12">
                    <h4>Filter '.@$_POST['crud_name'].'s</h4>
                    <form id="filter_search" class="form-inline" action="<?php echo $url->site_url(\''.@$_POST['crud_name'].'\');?>" method="get">
                        ';
       foreach(@$_POST['crud_field'] as $item){ 
                        $content.='                         <input type="search" class="filterItem form-control" name="'.$item.'" value="<?php echo @$_GET[\''.$item.'\'];?>" placeholder="Search '.$item.'">
                            ';
       }
                        $content.='
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button> <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'\') ?>" class="btn btn-default"><span class="glyphicon glyphicon-erase"></span> Clear filters</a>
                    </form>
                </div>
            </div>
            
            <hr>
            <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/add\'); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> Add '.@$_POST['crud_name'].'</a>
            <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'\') ?>" class="btn btn-default btn-sm pull-right"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
            <hr>
            
            
            <?php if ($action_msg) { ?>
                <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $action_msg; ?></strong>
                </div>
            <?php } ?>

            <?php if (count($'.@$_POST['crud_name'].'s) > 0) { ?>

                <table class="table table-striped" id="'.@$_POST['crud_name'].'_results">
                    <thead>
                        
                        
                        <tr>
                            <th>_id</th>
                            ';
                        
                        foreach(@$_POST['crud_field'] as $item){ 
                        $content.='                            <th>'.$item.'</th>';
                        }
                        
                        $content.='
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($'.@$_POST['crud_name'].'s as $'.@$_POST['crud_name'].') { ?>
                            <tr>
                                <td><?php echo $'.@$_POST['crud_name'].'[\'_id\']; ?></td>
                                    ';
                        foreach(@$_POST['crud_field'] as $item){ 
                        $content.='                            <td><?php echo $'.@$_POST['crud_name'].'[\''.$item.'\']; ?></td>';
                        }
                        $content.='

                                <td>
                                    <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/view/\' . $'.@$_POST['crud_name'].'[\'_id\']); ?>"  class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span> View</a>
                                    <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/edit/\' . $'.@$_POST['crud_name'].'[\'_id\']); ?>"  class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                    <a href="<?php echo $url->site_url(\''.@$_POST['crud_name'].'/delete/\' . $'.@$_POST['crud_name'].'[\'_id\']); ?>"  class="btn btn-danger btn-xs" onclick="return confirm(\'are you sure to delete\')"><span class="glyphicon glyphicon-remove"></span> Delete</a>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="alert alert-info" role="alert">
                    <strong>No '.@$_POST['crud_name'].'s Found!</strong>
                </div>
            <?php } ?>

        </div>
<br>
<br>
    </body>
</html>';
       
        @file_put_contents('themes/generated/'.@$_POST['crud_name'].'/list.php', $content);
        $messages[]='Created file: ./themes/generated/'.@$_POST['crud_name'].'/list.php'.PHP_EOL;
   } 
    
    
}  


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Storage CRUD Generator</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <?php echo $jq->load('1.12.4');?>
        <script>
        $(document).on('click','.add_field',function(){
            $('.crud_item:last').after('<br>'+$('.crud_item:last')[0].outerHTML);
        });
        </script>
    </head>
    <body>
        
        <div class="container">
            <h1>Storage CRUD generator</h1>
            <h3>Create page, storage table and CRUD</h3>  
            <?php 
            if(@$_POST){
               echo '<pre>';
               print_r(implode('',$messages));
               echo '</pre>';
               echo 'You can check page here: <a href="'.$url->site_url(@$_POST['crud_name']).'">'.$url->site_url(@$_POST['crud_name']).'</a>';
            }
             ?>
            <?php if(!@$_POST){?>
            
            <form role="form" method="post" action="<?php echo $url->site_url('xcrud'); ?>" >
                <input placeholder="Page / table name" type="text" class="form-control" required="required"  name="crud_name" value=""><br>
                
                <input placeholder="Enter field name here... Ex. first_name" type="text" class="form-control crud_item" required="required" name="crud_field[]" value=""> <br>
                    <button type="button" class="btn btn-default add_field"><span class="glyphicon glyphicon-plus"></span> Add field</button>
                    <br><br>
                <button type="submit" class="btn btn-primary">Generate now!</button>
                
            </form>
            
            <?php }?>
            
        </div>

    </body>
</html>