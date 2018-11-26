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
class OurticketsCommand extends UserCommand
{
  /**
   * @var string
   */
  protected $name = 'tickets';

  /**
   * @var string
   */
  protected $description = 'Tickets Test';

  /**
   * @var string
   */
  protected $usage = '/ourtickets';

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
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://booking.uz.gov.ua/ru/train_search/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
      "from=2204001&to=2200001&date=2018-12-30&time=00:00");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    curl_close ($ch);
    $res = json_decode($server_output);

    if (isset($res->data->warning))
    {
      $text = '2018-12-30::'.$res->data->warning;
    }
    elseif(isset($res->data->list))
    {
      $text = '2018-12-30::Найдено '.count($res->data->list).' вариантов';
    }

    $text .=PHP_EOL;
    $text .="<a href='https://booking.uz.gov.ua/ru/?from=2204001&to=2200001&date=2018-12-30&time=00%3A00&url=train-list'>Ссылочка</a>";

    $data = [
      'parse_mode' => 'html',
      'chat_id' => $chat_id,
      'text'    => $text,
    ];

    return Request::sendMessage($data);

  }
}
