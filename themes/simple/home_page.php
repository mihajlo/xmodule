<!DOCTYPE html>
<html lang="en">
<head>
<title>Xmodule v.2.0 :: easiest modular micro PHP framework...</title>
<meta charset="utf-8">
<style>
    body{
     
        /* IE10+ */ 
background-image: -ms-linear-gradient(top, #363636 0%, #D6D6D6 100%);

/* Mozilla Firefox */ 
background-image: -moz-linear-gradient(top, #363636 0%, #D6D6D6 100%);

/* Opera */ 
background-image: -o-linear-gradient(top, #363636 0%, #D6D6D6 100%);

/* Webkit (Safari/Chrome 10) */ 
background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #363636), color-stop(100, #D6D6D6));

/* Webkit (Chrome 11+) */ 
background-image: -webkit-linear-gradient(top, #363636 0%, #D6D6D6 100%);

/* W3C Markup */ 
background-image: linear-gradient(to bottom, #363636 0%, #D6D6D6 100%);
background-size: 100% 500%;
        
        color: white;
        text-align: center;
        font-family: sans-serif;
    }
    a{
        color: #EFEFEF;
    }
</style>
</head>
<body>
    <p><img src="https://xmodule.eco.mk/themes/simple/images/xmodule.png" /></p>
<?php echo $hmodule->h1('Welcome to Xmodule 2.0');?>
<h3>This is first (default) page</h3>
<p><a href="<?php echo $documentation_link;?>" target="_blank">Online documentation</a></p>
</body>
</html>

