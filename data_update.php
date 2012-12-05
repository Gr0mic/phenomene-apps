<?php
ini_set('memory_limit', '128M');
ini_set('max_execution_time', 60);

include_once 'config.php';

// ***** GET/SET DATA ***** //

echo '<!-- T1-'.microtime().' -->';

echo '<!-- Refresh cache -->';

$curlAH = curl_init();

curl_setopt($curlAH, CURLOPT_URL, 'http://eu.battle.net/api/wow/auction/data/chogall');

curl_setopt($curlAH, CURLOPT_HEADER, false);

curl_setopt($curlAH, CURLOPT_RETURNTRANSFER, true);

$json_ah = json_decode(curl_exec($curlAH), true);

curl_close($curlAH);

chmod($config['json_ah_file'], 0777);
file_put_contents($config['json_ah_file'], serialize($json_ah));
chmod($config['json_ah_file'], 0666);

echo '<!-- T2-'.microtime().' -->';

$DumpAH = $json_ah['files'][0]['url'];

echo '<!-- Refresh cache -->';

$curlAH_data = curl_init();
curl_setopt($curlAH_data, CURLOPT_URL, $DumpAH);
curl_setopt($curlAH_data, CURLOPT_HEADER, false);
curl_setopt($curlAH_data, CURLOPT_RETURNTRANSFER, true);
$json_ah_data = json_decode(curl_exec($curlAH_data), true);
curl_close($curlAH_data);

chmod($config['json_ah_data_file'], 0777);
file_put_contents($config['json_ah_data_file'], serialize($json_ah_data));
chmod($config['json_ah_file'], 0666);

echo '<!-- T3-'.microtime().' -->';

echo 'update realized';

header('Location: ironpaw.php');