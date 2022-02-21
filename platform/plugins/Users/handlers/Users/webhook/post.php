<?php

function Users_webhook_post($params)
{
    // just for supporting the method, so we can send large batch requests
    // in the body of the POST
//    return 'Users_webhook_post';

    $req = array_merge($_REQUEST, $params);

    Users_ExternalFrom_Telegram::setWebhook();

}