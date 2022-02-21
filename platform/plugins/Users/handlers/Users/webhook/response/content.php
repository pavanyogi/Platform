<?php

function Users_webhook_response_content($params)
{
    Q_Response::addScript("{{Users}}/js/pages/webhook.js");
    return Q::view("Users/content/webhook.php");
}