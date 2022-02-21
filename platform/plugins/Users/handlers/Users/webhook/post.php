<?php

function Users_webhook_post($params)
{
    // just for supporting the method, so we can send large batch requests
    // in the body of the POST
//    return 'Users_webhook_post';

    $req = array_merge($_REQUEST, $params);
    $param1 = Q::ifset($req, 'param1', null);

    Q::log(array('$req' => $req, '$param1' => $param1 ), 'Users');

    Users_ExternalFrom_Telegram::setWebhook();
    Q_Response::setSlot('result', true);

}