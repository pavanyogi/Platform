<?php

function Users_webhook_response_content($params)
{
//    Q_Response::addScript("{{Users}}/js/pages/webhook.js");

    $authData = Q::event('Users/webhook/validate', $params);

    return Q::view("Users/content/webhook.php");
}