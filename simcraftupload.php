<?php
$defaultFilePath = 'simcraft';

if ( $_POST ) {
    $_error        = false;
    $errorType     = "error";
    $fileMimeTypes = array('text/html');
    $file          = $_FILES['simcraft'];

    if ( empty($_POST['userName']) ) {
        $_error = true;
        $error  = 'Vous n\'avez pas encodé le nom du personnage';
    }

    if (!$_error && is_dir($defaultFilePath)) {
        if ( !empty($file['name']) ) {
            if (!in_array($file['type'], $fileMimeTypes )) {
                $_error = true;
                $error = 'Ce type (' . $file['type'] . ') de fichier n\'est pas autorisé';
            }
            $t = explode('.', $file['name']);
            $finalFileName = $defaultFilePath . '/' . strtolower($_POST['userName']) . '.html';
            if (false === $_error){
                if ( move_uploaded_file($file['tmp_name'], $finalFileName) ) {
                    $error = "Fichier enregistré";
                    $errorType="success";
                } else {
                    $error =  'Echec de l\'upload !';
                    $this->Session->setFlash($msg,"admin_alert", array('type'=>'error'));
                } 
            } 
        } else {
            $error = 'Vous n\'avez pas de fichier';
        } 
    }

}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Simcraft upload</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 20px;
                padding-bottom: 40px;
            }
            .money-gold { color: gold}
            .money-silver { color: silver}
            .money-copper { color: #B87333}
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
		<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>        
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <div class="container">

        	<div class="alert alert-info">
        		Apps qui permet le partage des fiches de simulationCraft (<strong>.html</strong>) pour en parler ensemble sur le forum. <br>
                A l'envoie si un fichier est déjà existant il est écrasé.
        	</div>

        <?php if (isset($error)): ?>
            <div class="alert alert-<?php echo $errorType ?>">
                <?php echo $error ?>
            </div>
        <?php endif; ?>


        	<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label" for="userName">Personnage</label>
					<div class="controls">
						<input type="text" id="userName" name="userName" placeholder="Personnage">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="simcraft">Fichier</label>
					<div class="controls">
						<input type="file" id="simcraft" name="simcraft">
					</div>
				</div>
				<button type="submit" class="btn">Envoyer</button>
        	</form>

        	<div class="well">
        		<h5>Liste des fichiers</h5>
        		<ul>
                <?php foreach (new DirectoryIterator($defaultFilePath) as $fileInfo) : if($fileInfo->isDot()) continue;?>    
        			<li>
                        <?php echo ucfirst(str_replace('.html', '', $fileInfo->getFilename())) ?>
                        au <?php echo date('d/m/Y', $fileInfo->getMTime()) ?>
                        (<a href="<?php echo $defaultFilePath.'/'.$fileInfo->getFilename() ?>" target="_blank">
                            <?php echo 'http://'.$_SERVER['HTTP_HOST'].'/apps/'.$defaultFilePath.'/'.$fileInfo->getFilename(); ?>
                        </a>)
                        <br>
                        C/c dans un post forum
                        <code>
                            [url=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/apps/'.$defaultFilePath.'/'.$fileInfo->getFilename(); ?>]
                                Simcraft de <?php echo ucfirst(str_replace('.html', '', $fileInfo->getFilename())) ?>
                                au <?php echo date('d/m/Y', $fileInfo->getMTime()) ?>
                            [/url]
                        </code>
                    </li>
                <?php endforeach; ?>
        		</ul>
        	<div>

		</div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/order.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
