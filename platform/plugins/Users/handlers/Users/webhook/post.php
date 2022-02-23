<?php

function Users_webhook_post($params)
{
    // just for supporting the method, so we can send large batch requests
    // in the body of the POST
//    return 'Users_webhook_post';

    $req = array_merge($_REQUEST, $params);
    $hookAction = Q::ifset($req, 'hookAction', null);
    $reqSecretKey = Q::ifset($req, 'secret', null);

    $secretKey = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'secret', null);


    Q::log(array('$req' => $req, '$hookAction' => $hookAction ), 'Users');
    $webhookResult = '';
    if($hookAction && $secretKey === $reqSecretKey){
        if($hookAction === 'set'){
            $webhookResult = Users_ExternalFrom_Telegram::setWebhook();
        } elseif ($hookAction === 'delete') {
            $webhookResult = Users_ExternalFrom_Telegram::deleteWebhook();
        } else {
            $webhookResult = Users_ExternalFrom_Telegram::resetWebhook();
        }
    }

    if(!$hookAction){
        $webhookResult = Users_ExternalFrom_Telegram::handleWebhook();
    }

    Q::log(array('$webhookResult' => $webhookResult ), 'Users');

    Q_Response::setSlot('result', true);

}