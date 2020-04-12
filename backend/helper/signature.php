<?php

$key = 'f4740b81b9581903dff7cad6b95d4ce87538296893fff3766d3680e111b3bec0c8ec6cbd51496cb393cc9f7af95d90276b9a7803ddf5d0833060070394294d44';
$salt = '3d2088cbd7254ab2ae4488db2d51bb3bd55feda242773c318a0c6117f7c2f91a4cf9802f8ff27f9bac0acf79f14c4bd6e58d9c88cf9fc9f9e4bc61bb247bfd66';

$keyBin = pack("H*" , $key);
if(empty($keyBin)) {
	die('Key expected to be hex-encoded string');
}

$saltBin = pack("H*" , $salt);
if(empty($saltBin)) {
	die('Salt expected to be hex-encoded string');
}

$resize = 'fill';
$width = 32;
$height = 32;
$gravity = 'no';
$enlarge = 1;
$extension = 'jpeg';
$filename = bin2hex(random_bytes(8)) . '_' . bin2hex(random_bytes(16)) . '_' . bin2hex(random_bytes(8));

$url = 's3://public/10/download.jpeg';
$encodedUrl = rtrim(strtr(base64_encode($url), '+/', '-_'), '=');

$path = "/filename:{$filename}/resize:{$resize}/width:{$width}/height:{$height}/gravity:{$gravity}/enlarge:{$enlarge}/{$encodedUrl}.{$extension}";

$signature = rtrim(strtr(base64_encode(hash_hmac('sha256', $saltBin.$path, $keyBin, true)), '+/', '-_'), '=');

print(sprintf("/%s%s", $signature, $path));
