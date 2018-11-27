<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

/**
 * Generic command
 *
 * Gets executed for generic commands, when no other appropriate one is found.
 */
class CronCommand extends SystemCommand
{
  /**
   * @var string
   */
  protected $name = 'cron';

  /**
   * @var string
   */
  protected $description = 'Handles generic commands or is executed by default when a command is not found';

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

    $date = '2018-12-30';

    curl_setopt($ch, CURLOPT_URL,"https://booking.uz.gov.ua/ru/train_search/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
      "from=2204001&to=2200001&date=$date&time=00:00");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    curl_close ($ch);
    $res = json_decode($server_output);

    if (isset($res->data->warning))
    {
      $text = "$date::".$res->data->warning;
      $res = false;
    }
    elseif(isset($res->data->list))
    {
      $text = "Привет! Я - охуенное изобретение лучшего в мире лысого инженера. И я нашел ".count($res->data->list)." поездов на $date";
      $res = true;
    }

    $text .=PHP_EOL;
    $text .="<a href='https://booking.uz.gov.ua/ru/?from=2204001&to=2200001&date=$date&time=00%3A00&url=train-list'>Ссылочка</a>";

    $data = [
      'parse_mode' => 'html',
      //'chat_id' => 93731196,
      'chat_id' => 6569350,
      'text'    => $text,
    ];

    return $res ? Request::sendMessage($data) : false;

  }
}
