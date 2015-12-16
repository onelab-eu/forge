<?php

if (array_key_exists('lang', $_GET) and htmlspecialchars($_GET['lang']) == 'fr')
{
	$content = $content_fr;
}
elseif(array_key_exists('lang', $_GET) and htmlspecialchars($_GET['lang']) == 'en')
{
	$content = $content_en;
}
else
{
	$content = $content_en;
}

?>
