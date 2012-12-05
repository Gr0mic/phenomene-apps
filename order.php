<?php 
ini_set('max_execution_time', 90);

$character = 'Gromeg';
$locale = 'en'; 
$url_professions = 'http://eu.battle.net/api/wow/character/chogall/' . $character . '?fields=professions';

$curlAH = curl_init();
curl_setopt($curlAH, CURLOPT_URL, $url_professions);
curl_setopt($curlAH, CURLOPT_HEADER, false);
curl_setopt($curlAH, CURLOPT_RETURNTRANSFER, true);
$json_professions = json_decode(curl_exec($curlAH), true);
curl_close($curlAH);

//var_dump($url_professions);
//var_dump($json_professions['professions']['primary']);
//var_dump ($_POST);
if ($_POST) {
	$order = array();
	foreach ($_POST as $k => $v) {
		if ( !empty($v) ) {
			if (is_int($k)) {
				$curlAH = curl_init();
				curl_setopt($curlAH, CURLOPT_URL, 'http://eu.battle.net/api/wow/recipe/' . $k . '?locale='.$locale);
				curl_setopt($curlAH, CURLOPT_HEADER, false);
				curl_setopt($curlAH, CURLOPT_RETURNTRANSFER, true);
				$json_precipe = json_decode(curl_exec($curlAH), true);
				curl_close($curlAH);
				//var_dump($json_precipe);				
				$order['items'][] = array(
					'id' => $k,
					'quantity' => $v,
					'name' => $json_precipe['name']
					);
			} else {
				$order[$k] = $v;
			}
		}
	}
	
	if( !empty($order) ) {
		$obj = '[WOW] Commande de ' . $order['buyer'];
		$msg = var_export($order,1);
		$headers = 'From: order@phenomene.com' . "\r\n" .
	     'Reply-To: no-reply@phenomene.com' . "\r\n" .
	     'X-Mailer: PHP/' . phpversion();
		mail('morreelsm@gmail.com', $obj, $msg);
	}

}

/*http://eu.battle.net/api/wow/recipe/53948?locale=fr_FR*/
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Order for <?php echo $character ?></title>
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

        	<?php if( !empty($order) ): ?>
        	<div class="alert alert-success">
        		<p>
        			<?php echo $order['buyer'] ?>,
        		</p>
        		<p>La commande est envoyée à <?php echo $character ?></p>
        		<ul>
        		<?php foreach ($order['items'] as $i) :?>
        			<li>
        				<?php echo $i['quantity'] ?> x 
        				<a href="http://fr.wowhead.com/spell=<?php echo $i['id'] ?>" class="item-name">
							<?php echo $i['id'] ?>
						</a>
        			</li>
        		<?php endforeach; ?>
        		</ul>
        	</div>
        	<?php endif; ?>

        	<form action="" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="buyer">Demandeur</label>
					<div class="controls">
						<input type="text" id="buyer" name="buyer" placeholder="Demandeur">
					</div>
				</div>
		<?php foreach ($json_professions['professions']['primary'] as $p) :?>
			<table class="table table-striped filterable">
				<caption><?php echo $p['name'] ?></caption>
				<thead>
					<tr>
						<th>Name</th>
						<th>Nombre</th>
					</tr>
				</thead>
			<?php foreach (array_reverse($p['recipes']) as $r) : ?>
				<tr>
					<td>
						<a href="http://fr.wowhead.com/spell=<?php echo $r ?>" class="item-name">
							<?php echo $r ?>
						</a>
					</td>
					<td>
						<input type="number" class="input-mini" name="<?php echo $r ?>">
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endforeach; ?>
			<button type="submit" class="btn">Envoyer</button>
        	</form>		
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
