<?php
require_once '../vendor/autoload.php';

$pages = [
	'David_Attenborough',
	'Ian_McKellen',
	'Patrick_Stewart',
	'Christopher_Lee',
];

$query = [
	'format'     => 'json',
	'action'     => 'query',
	'prop'       => 'extracts',
	'exintro'    => '',
	'explaintext'=> '',
	'exlimit'    => count($pages),
	'titles'     => implode('|', $pages),
];

$client = new GuzzleHttp\Client();
$res = $client->get('https://en.wikipedia.org/w/api.php', ['query' => $query]);
$response = json_decode($res->getBody(), true);

foreach ($response['query']['pages'] as $page)
{
	// Grab everything up to the first full stop
	$output[$page['title']] = [
		'sentence' => reset(explode('.', $page['extract'], 2)),
	];
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Oh god is everyone ok?</title>
	</head>
	<body>
		<?php foreach ($output as $person => $info): ?>
		<h1><?=$person;?></h1>
		<p><?=$info['sentence'];?></p>
		<?php endforeach; ?>
