<?php
function format_gold($amount = 0) {

	$amount_string = '';

	$amount = (int)$amount;

	$amount_string = 
		  '<span class="money-gold">' . substr($amount, 0, -4).'G</span> ' 
		. '<span class="money-silver">' . substr($amount, -4, 2).'S</span> '
		. '<span class="money-copper">' . substr($amount, -2).'C</span>';

	return $amount_string;

}

// ***** CONFIG ***** //
include_once('config.php');

ini_set('memory_limit', '128M');
// ***** GET/SET DATA ***** //

echo '<!-- T1-'.microtime().' -->';

$curlAH = curl_init();
curl_setopt($curlAH, CURLOPT_URL, 'http://eu.battle.net/api/wow/auction/data/chogall');
curl_setopt($curlAH, CURLOPT_HEADER, false);
curl_setopt($curlAH, CURLOPT_RETURNTRANSFER, true);
$json_ah = json_decode(curl_exec($curlAH), true);
curl_close($curlAH);

echo '<!-- T2-'.microtime().' -->';

$DumpAH = $json_ah['files'][0]['url'];

$curlAH_data = curl_init();
curl_setopt($curlAH_data, CURLOPT_URL, $DumpAH);
curl_setopt($curlAH_data, CURLOPT_HEADER, false);
curl_setopt($curlAH_data, CURLOPT_RETURNTRANSFER, true);
$json_ah_data = json_decode(curl_exec($curlAH_data), true);
curl_close($curlAH_data);

echo '<!-- T3-'.microtime().' -->';

if ($config['use_cache']) {
	$json_ah = unserialize( file_get_contents($config['json_ah_file']) );
	$json_ah_data = unserialize( file_get_contents($config['json_ah_data_file']) );
}

$array_horde_data = $json_ah_data['horde']['auctions'];

$nb_auctions = count($array_horde_data);

$prices_array = array();



// [auc] => 1476808042 [item] => 85221 [owner] => Tygax [bid] => 501500 [buyout] => 600000 [quantity] => 1 [timeLeft] => VERY_LONG

foreach ($array_horde_data as $auction) {

	if ( in_array($auction['item'], $ingredients) ) {

		if ( isset($prices_array[$auction['item']]) ) {
			$prices_array[$auction['item']]['quantity'] += $auction['quantity'];
			$prices_array[$auction['item']]['buyout'] += $auction['buyout'];
			$prices_array[$auction['item']]['bid'] += $auction['bid'];	
		} else {
			$prices_array[$auction['item']]['quantity'] = $auction['quantity'];
			$prices_array[$auction['item']]['buyout'] = $auction['buyout'];
			$prices_array[$auction['item']]['bid'] = $auction['bid'];
		}

	}

}

echo '<!-- T4-'.microtime().' -->';
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Iron paw tools</title>
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

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

<p>
	Dernière mise à jour de l'AH: <?php echo date('d-m-Y H:i:s', $json_ah['files'][0]['lastModified']/1000) ?>
	<br/>
	Source: <?php echo $json_ah['files'][0]['url'] ?>
</p> 
<table class="table table-striped">
	<caption>Ingrédients et nourritures</caption>
	<thead>
		<tr>
			<th>Name</th>
			<th>Bid unit price</th>
			<th>Buyout unit price</th>
			<th>Total quantity available</th>
			<th>Average Ironpaw token cost</th>
		</tr>
	</thead>
<?php foreach ($prices_array as $item => $auction) : ?>
	<tr>
	<td>
		<a href="http://fr.wowhead.com/item=<?php echo $item ?>">
			<?php echo $ingredients_name[$item][0]?>
		</a>	
	</td>
	<td>
		<?php echo format_gold($auction['bid']/$auction['quantity']) ?>
	</td>
	<td>
		<?php echo format_gold($auction['buyout']/$auction['quantity']) ?>
	</td>
	<td>
		<?php echo $auction['quantity'] ?>
	</td>
	<td>
		<?php if ($ingredients_name[$item][1] == 1 or $ingredients_name[$item][1] == 2) echo format_gold(20*$auction['buyout']/$auction['quantity']) ?>

		<?php if ($ingredients_name[$item][1] == 5) echo format_gold(60*$auction['buyout']/$auction['quantity']).PHP_EOL; ?>

		<?php if ($ingredients_name[$item][1] == 3) echo format_gold(100*$auction['buyout']/$auction['quantity']) .PHP_EOL; ?>
	</td>
	<?php// if ($ingredients_name[$item][1] == 4)?>
	</tr>
<?php endforeach; ?>
</table>

<table class="table table-striped">
	<caption>Recettes</caption>
	<thead>
		<tr>
			<th>Name</th>
			<th>Bid unit price</th>
			<th>Buyout unit price</th>
			<th>Total quantity available</th>
			<th>AH recipe cost</th>
		</tr>
	</thead>
<?php foreach ($recettes_details as $recette) : ?>
	<tr>
	<td>
		<a href="http://fr.wowhead.com/item=<?php echo $recette[0] ?>">
			<?php echo $recette[1]?>
		</a>	
	</td>
	<td>
		<?php echo format_gold($prices_array[$recette[0]]['bid']/max(1,$prices_array[$recette[0]]['quantity'])) ?>
	</td>
	<td>
		<?php echo format_gold($prices_array[$recette[0]]['buyout']/max(1,$prices_array[$recette[0]]['quantity'])) ?>
	</td>
	<td>
		<?php echo $prices_array[$recette[0]]['quantity'] ?>
	</td>
	<td>
		<?php echo format_gold(
			$prices_array[$recette[2]]['buyout']/max(1,$prices_array[$recette[2]]['quantity']) +
			5*$prices_array[$recette[3]]['buyout']/max(1,$prices_array[$recette[3]]['quantity']) +
			5*$prices_array[$recette[4]]['buyout']/max(1,$prices_array[$recette[4]]['quantity']) +
			25*$prices_array[$recette[5]]['buyout']/max(1,$prices_array[$recette[5]]['quantity'])
		); ?>
	</td>
	</tr>
<?php endforeach; ?>
</table>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-35780493-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

