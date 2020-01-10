<?php

function Assets_1_0_1()
{
	$filename = 'apple-developer-merchantid-domain-association';
	$from = ASSETS_PLUGIN_WEB_DIR.DS.'.well-known'.DS.$filename;
	$dir = APP_WEB_DIR.DS.'.well-known';
	$to = $dir.DS.$filename;
	if (!file_exists($to)) {
		mkdir($to, 0755);
		Q_Utils::copy($from, $to);
	}
}

Assets_1_0_1();