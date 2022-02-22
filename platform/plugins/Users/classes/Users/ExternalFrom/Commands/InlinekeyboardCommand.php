<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;

/**
 * User "/inlinekeyboard" command
 *
 * Display an inline keyboard with a few buttons.
 *
 * This command requires CallbackqueryCommand to work!
 *
 * @see CallbackqueryCommand.php
 */

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\LoginUrl;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

//require_once(Q_CLASSES_DIR.DS.'Q'.DS.'Config.php');

class InlinekeyboardCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'inlinekeyboard';

    /**
     * @var string
     */
    protected $description = 'Show inline keyboard';

    /**
     * @var string
     */
    protected $usage = '/inlinekeyboard';

    /**
     * @var string
     */
    protected $version = '0.2.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        /*
         *
         * Important: do not forgot to set the bot domain, otherwise it will not work
         * set domain (/setdomain) as https://example.com/
         * set bot domain name of the bot (talk to the botfather) https://stackoverflow.com/questions/51893388/telegram-web-login-widget-setdomain-does-not-work/51897669#51897669
         * tailc -f php-telegram-bot-debug.log
         * tailc -f /var/log/apache2/local.php-telegram-bot-core.com-error.log
         * cat php-telegram-bot-debug.log
         *
         */

//        $domain_url = Q_Config::get('Users', 'apps', 'telegram', 'TokenSociety', 'domainUrl', null);

        $domain_url = 'https://tokensociety2.gmba.local';
        $text         = 'Go to ' . $domain_url . '!';
        $reply_markup = new InlineKeyboard([
            ['text' => 'Login', 'login_url' => new LoginUrl(['url' => $domain_url . '/Q/plugins/Users/webhook', 'forward_text' => 'Login (forwarded)'])],
            ['text' => 'Open', 'url' => $domain_url . '/url'],
        ]);

        return $this->replyToUser($text, compact('reply_markup'));


    }
}