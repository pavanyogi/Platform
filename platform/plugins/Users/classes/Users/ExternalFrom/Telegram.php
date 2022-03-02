<?php

/**
 * @module Users
 */

require_once USERS_PLUGIN_DIR.'/vendor/autoload.php';

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
        $platformAppId = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'appId', null);

        $xid = strtolower(Q::ifset($_REQUEST, 'id', null));

        $payload = Q::ifset($_REQUEST, 'auth_date', null);
        $signature = Q::ifset($_REQUEST, 'hash', null);
        if (!$payload or $signature) {
            $cookieName = "wsr_$platformAppId";
            if (isset($_COOKIE[$cookieName])) {
                // A previous request has set the wsr cookie
                $wsr_json = $_COOKIE[$cookieName];
                if ($wsr = Q::json_decode($wsr_json, true)) {
                    list($payload, $signature) = $wsr;
                }
            }
        }

        $expires = time() + Q::ifset($appInfo, 'expires', 60*60);
        $cookieNames = array("wsr_$platformAppId", "wsr_$platformAppId".'_expires');
        if ($xid and $setCookie) {
            $parts = array($payload, $signature);
            Q_Response::setCookie($cookieNames[0], Q::json_encode($parts), $expires);
            Q_Response::setCookie($cookieNames[1], $expires, $expires);
        }
        $ef = new Users_ExternalFrom_Telegram();
        // note that $ef->userId was not set
        $ef->platform = 'telegram';
        $ef->appId = $platformAppId;
        $ef->xid = $xid;
        $ef->accessToken = null;
        $ef->expires = $expires;
        $ef->set('cookiesToClearOnLogout', $cookieNames);
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
		if (!isset($sizes)) {
			$sizes = array_keys(Q_Image::getSizes('Users/icon'));
		}
		sort($sizes);
		if (!isset($_REQUEST['photo_url']) or empty($_REQUEST['photo_url'])) {
			return null;
		}
		$icon = array();
		foreach ($sizes as $size) {
			$parts = explode('x', $size);
			$width = Q::ifset($parts, 0, '');
			$height = Q::ifset($parts, 1, '');
			$width = $width ? $width : $height;
			$height = $height ? $height : $width;
			$icon[$size.$suffix] = $_REQUEST['photo_url']
				. "?width=$width&height=$width";
		}
		return $icon;
	}

	/**
	 * Import some fields from the platform. Also fills Users::$cache['platformUserData'].
	 * @param {array} $fieldNames
	 * @return {array}
	 */
	function import($fieldNames)
	{
        if (!is_array($fieldNames)) {
            $fieldNames = Q_Config::get('Users', 'import', 'telegram', null);
        }

        if (!$fieldNames) {
            return array();
        }

        $userDetails = array(
            'first_name' => $_REQUEST['first_name'],
            'last_name' => $_REQUEST['last_name'],
            'username' => $_REQUEST['username']
        );

        Users::$cache['platformUserData'] = array(
            'telegram' => $userDetails
        );

        return $userDetails;
	}

    static function setWebhook()
    {
        $botApiKey = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botApiKey', null);
        $botUserName = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botUserName', null);
        $webhookUrl = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'webhook', 'url', null);
//        $webhookCertificate = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'webhook', 'certificate', null);

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
//             $result = $telegram->setWebhook($webhookUrl, ['certificate' => $webhookCertificate]);

//            echo $result->getDescription();
            Q::log($result, 'Users');
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            Q::log($e, 'Users');
        }
    }

    static function deleteWebhook()
    {
        $botApiKey = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botApiKey', null);
        $botUserName = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botUserName', null);
        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($botApiKey, $botUserName);

            // Unset / delete the webhook
            $result = $telegram->deleteWebhook();

//            echo $result->getDescription();
            Q::log($result, 'Users');
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            Q::log($e, 'Users');
        }
    }

    static function resetWebhook()
    {
        self::deleteWebhook();
        self::setWebhook();
    }

    static function handleWebhook()
    {
        $botApiKey = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botApiKey', null);
        $botUserName = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'botUserName', null);
        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($botApiKey, $botUserName);

            // Define all paths for your custom commands in this array (leave as empty array if not used)
            $commands_paths = [
                __DIR__ . '/Commands',
            ];

            // Add this line inside the try{}
            $telegram->addCommandsPaths($commands_paths);

            self::setTelegramLogging();

            // Handle telegram webhook request
            $telegram->handle();
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            // echo $e->getMessage();
            Q::log($e, 'Users');
        }
    }

    static function setTelegramLogging()
    {
        Longman\TelegramBot\TelegramLog::initialize(
            new Monolog\Logger('telegram_bot', [
                (new Monolog\Handler\StreamHandler(__DIR__ . '/php-telegram-bot-debug.log', Monolog\Logger::DEBUG))->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true)),
                (new Monolog\Handler\StreamHandler(__DIR__ . '/php-telegram-bot-error.log', Monolog\Logger::ERROR))->setFormatter(new Monolog\Formatter\LineFormatter(null, null, true)),
            ]),
            new Monolog\Logger('telegram_bot_updates', [
                (new Monolog\Handler\StreamHandler(__DIR__ . '/php-telegram-bot-update.log', Monolog\Logger::INFO))->setFormatter(new Monolog\Formatter\LineFormatter('%message%' . PHP_EOL)),
            ])
        );
    }
}