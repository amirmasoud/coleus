<?php

require __DIR__ . '/vendor/autoload.php';
define('__SONIC_CLIENT_DEBUG__', true);

$address = 'localhost';
$port = 1491;
$password = 'passwd';
$connectionTimeout = 10;
$readTimeout = 5;
$collection = 'messages';
$bucket = 'default';

$factory = new \SonicSearch\ChannelFactory($address, $port, $password, $connectionTimeout, $readTimeout);

$ingest = $factory->newIngestChannel();
$search = $factory->newSearchChannel();
$control = $factory->newControlChannel();

try {
    $ingest->connect();
    $search->connect();
    $control->connect();
} catch (\SonicSearch\NoConnectionException $e) {
    echo("Failed to connect to Sonic: $e\n");
}

// index
$ingest->ping();
$ingest->push($collection, $bucket, '1', 'MPs are starting to debate the process of voting on their preferred Brexit options, as Theresa May prepares to meet Tory backbenchers in an effort to win them over to her agreement.');
$ingest->push($collection, $bucket, '2', 'A shadowy group committed to ousting North Korea\'s leader Kim Jong-un has claimed it was behind a raid last month at the North Korean embassy in Spain.');
$ingest->push($collection, $bucket, '3', 'Meng Hongwei, the former Chinese head of Interpol, will be prosecuted in his home country for allegedly taking bribes, China\'s Communist Party says.');
$ingest->push($collection, $bucket, '4', 'A Chinese student who was violently kidnapped by a stun-gun toting gang of masked men in Canada has been found safe and well, police say.');

// save to disk
$control->consolidate();

$resp = $ingest->count($collection);
echo "Count collection: $resp\n";
$resp = $ingest->count($collection, $bucket);
echo "Count bucket: $resp\n";
$resp = $ingest->count($collection, $bucket, '1');
echo "Count object: $resp\n";

// search
$search->ping();
$responses = $search->query($collection, $bucket, "debate");
assert($responses[0] === '1');
$responses = $search->query($collection, $bucket, "Chinese");
assert(array_search('3', $responses, true) >= 0 && array_search('4', $responses, true) >= 0);
$responses = $search->suggest($collection, $bucket, "There");
assert($responses[0] === 'theresa');
$responses = $search->suggest($collection, $bucket, "Hong");
assert($responses[0] === 'hongwei');

// cleanup
$ingest->flush($collection);
$ingest->flush($collection, $bucket);
$ingest->flush($collection, $bucket, '1');

$resp = $ingest->count($collection);
assert($resp === 0);
$resp = $ingest->count($collection, $bucket);
assert($resp === 0);
$resp = $ingest->count($collection, $bucket, '1');
assert($resp === 0);

$ingest->quit();
$search->quit();
$control->quit();

// exit with error if there was one
if ($err = error_get_last()) {
    exit($err['type']);
}