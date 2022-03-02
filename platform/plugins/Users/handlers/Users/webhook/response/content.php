<?php

function Users_webhook_response_content($params)
{
//    Q_Response::addScript("{{Users}}/js/pages/webhook.js");

//    $authData = Q::event('Users/webhook/validate', $params);

    if (isset($_REQUEST['hash']) && isset($_REQUEST['username'])) {
        $platform = 'telegram';
        $appId = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'appId', null);
        $user = Users::authenticate($platform, $appId, $authenticated);
        Q::log(array('$user' => $user), 'Users');
        if (!$user) {
            throw new Users_Exception_NotLoggedIn();
        }
        Users::setLoggedInUser($user);
    }

//    return Q::view("Users/content/webhook.php");
}