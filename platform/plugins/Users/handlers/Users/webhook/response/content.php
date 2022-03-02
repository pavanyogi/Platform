<?php

function Users_webhook_response_content($params)
{
    $redirect = Q_Uri::url("TokenSociety/profile");
    Q_Response::redirect($redirect);
    return true;

}