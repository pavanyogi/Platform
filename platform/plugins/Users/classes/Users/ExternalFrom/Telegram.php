<?php

/**
 * @module Users
 */

/**
 * Class representing Telegram app user.
 *
 * @class Users_ExternalFrom_Telegram
 * @extends Users_ExternalFrom
 */
class Users_ExternalFrom_Telegram extends Users_ExternalFrom implements Users_ExternalFrom_Interface
{
	/**
	 * Gets a Users_ExternalFrom_Telegram object constructed from request and/or cookies.
	 * It is your job to populate it with a user id and save it.
	 * @constructor
	 * @static
	 * @param {string} [$appId=Q::app()] Can either be an interal appId or an Telegram appId.
	 * @param {boolean} [$setCookie=true] Whether to set fbsr_$appId cookie
	 * @param {boolean} [$longLived=true] Get a long-lived access token, if necessary
	 * @return {Users_ExternalFrom_Telegram|null}
	 *  May return null if no such user is authenticated.
	 */
	static function authenticate($appId = null, $setCookie = true, $longLived = true)
	{
		list($appId, $appInfo) = Users::appInfo('telegram', $appId);
		$platformAppId = Q::ifset($appInfo, 'appId', 1);
		if (!$platformAppId) {
			$platformAppId = Q::ifset($_REQUEST, 'chainId', 1); // todo - may be related to chainId
		}
		if (!intval($platformAppId)) {
			throw new Q_Exception_BadValue(array(
				'internal' => 'Users/apps config',
				'problem' => "appId has to be a numeric chainId, not $platformAppId"
			));
		}

		$xid = Q::ifset($_REQUEST, 'xid', null);
		$signature = Q::ifset($_REQUEST, 'signature', null);
		// TODO: ecrecover xid from signature, we shouldn't trust the client
		if (!$xid) {
			$xid = Q::ifset($_COOKIE, 'Q_Users_telegram_address', null);
		}
		$expires = time() + Q::ifset($appInfo, 'expires', 60*60);
		if ($xid and $setCookie) {
			Q_Response::setCookie("Q_Users_telegram_address", $xid, $expires);
		}
		$ef = new Users_ExternalFrom_Telegram();
		// note that $ef->userId was not set
		$ef->platform = 'telegram';
		$ef->appId = $platformAppId;
		$ef->xid = $xid;
		$ef->accessToken = null;
		$ef->expires = $expires;
		return $ef;
	}

	/**
	 * Gets the logged-in user icon urls
	 * @param {array} [$sizes=Q_Image::getSizes('Users/icon')]
	 *  An array of size strings such "80x80"
	 * @return {array|null} [$suffix=''] Keys are the size strings with optional $suffix
	 *  and values are the urls
	 */
	function icon($sizes = null, $suffix = '')
	{
		// TODO: import from etherscan or use blockies as fallback
		$icon = array();
		return $icon;
	}

	/**
	 * Import some fields from the platform. Also fills Users::$cache['platformUserData'].
	 * @param {array} $fieldNames
	 * @return {array}
	 */
	function import($fieldNames)
	{
		// TODO: import from etherscan or use blockies as fallback
		$platform = 'telegram';
		if (!is_array($fieldNames)) {
			$fieldNames = Q_Config::get('Users', 'import', $platform, null);
		}
		if (!$fieldNames) {
			return array();
		}
	}

    function setWebhook()
    {
        $botApiKey = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botApiKey', null);
        $botUserName = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botUserName', null);
        $webhookUrl = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'webhook', 'url', null);
        $webhookCertificate = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'webhook', 'certificate', null);

        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($botApiKey, $botUserName);

            /**
             * REMEMBER to define the URL to your hook.php file in:
             * config.php: ['webhook']['url'] => 'https://your-domain/path/to/hook.php'
             */

            // Set the webhook
            $result = $telegram->setWebhook($webhookUrl);

            // To use a self-signed certificate, use this line instead
             $result = $telegram->setWebhook($webhookUrl, ['certificate' => $webhookCertificate]);

            echo $result->getDescription();
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            echo $e->getMessage();
        }
    }

    function deleteWebhook()
    {
        $botApiKey = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botApiKey', null);
        $botUserName = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botUserName', null);
        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($botApiKey, $botUserName);

            // Unset / delete the webhook
            $result = $telegram->deleteWebhook();

            echo $result->getDescription();
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            echo $e->getMessage();
        }
    }
}