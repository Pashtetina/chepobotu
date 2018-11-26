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
use Longman\TelegramBot\Request;
/**
 * User "/slap" command
 *
 * Slap a user around with a big trout!
 */
class PromCommand extends UserCommand
{
  /**
   * @var string
   */
  protected $name = 'prom';

  /**
   * @var string
   */
  protected $description = 'Prom Test';

  /**
   * @var string
   */
  protected $usage = '/prom';

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
    $text = 'Юля-пися, типа отправляешь мне команду, а я тебе кучу инфы про заказы отправки и все такое';

    $data = [
      'chat_id' => $chat_id,
      'text'    => $text,
    ];

    return Request::sendMessage($data);
  }
}
