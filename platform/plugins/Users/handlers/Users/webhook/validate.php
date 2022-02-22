<?php
/**
 * @param $params
 * @return mixed
 * @throws Q_Exception_FilePermissions
 * https://gist.github.com/anonymous/6516521b1fb3b464534fbc30ea3573c2
 * https://github.com/php-telegram-bot/core/issues/1065#issuecomment-608951099
 */
function Users_webhook_validate($params)
{
    /*
    $req = array_merge($_REQUEST, $params);
    $hookAction = Q::ifset($req, 'hookAction', null);
    $reqSecret = Q::ifset($req, 'secret', null);

    $secret = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'secret', null);

    if($hookAction && $reqSecret === $secret){
        return;
    }

    $botApiKey = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botApiKey', null);

    Q::log(array('Telegram data' => $req), 'Users');

    $auth_data = $_GET;
    $check_hash = $auth_data['hash'];
    unset($auth_data['hash']);
    $data_check_arr = [];
    foreach ($auth_data as $key => $value) {
        $data_check_arr[] = $key . '=' . $value;
    }
    sort($data_check_arr);
    $data_check_string = implode("\n", $data_check_arr);
    $secret_key = hash('sha256', $botApiKey, true);
    $hash = hash_hmac('sha256', $data_check_string, $secret_key);
    if (strcmp($hash, $check_hash) !== 0) {
        throw new Exception('Data is NOT from Telegram');
    }
    if ((time() - $auth_data['auth_date']) > 86400) {
        throw new Exception('Data is outdated');
    }
*/
//    return $auth_data;
}