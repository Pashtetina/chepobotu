<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;
/**
 * User "/slap" command
 *
 * Slap a user around with a big trout!
 */
class InfoCommand extends UserCommand
{
  /**
   * @var string
   */
  protected $name = 'infodebug';

  /**
   * @var string
   */
  protected $description = 'Test';

  /**
   * @var string
   */
  protected $usage = '/info';

  /**
   * @var string
   */
  protected $version = '1.1.0';

  /**
   * Command execute method
   *
   * @return \Longman\TelegramBot\Entities\ServerResponse
   * @throws \Longman\TelegramBot\Exception\TelegramException
   */
  public function execute()
  {
    $message = $this->getMessage();
    $chat_id = $message->getChat()->getId();
    $text    = $message->getText(true);

    $data = [
      'parse_mode' => 'html',
      'chat_id' => $chat_id,
      'text'    => $chat_id,
    ];

    return Request::sendMessage($data);





  }
}
