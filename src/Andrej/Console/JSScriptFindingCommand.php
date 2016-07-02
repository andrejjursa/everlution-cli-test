<?php
// src/Andrej/Console/JSScriptFindingCommand

namespace Andrej\Console;

use Symfony\Component\Console\Command\Command;

/**
 * Class JSScriptFindingCommand
 * @package Andrej\Console
 */
abstract class JSScriptFindingCommand extends Command {

    const COMMON_ERROR_URL_NOT_FOUND = 100;

    /**
     * Returns content of page specified by $url.
     *
     * @param $url page url to get content from
     * @param int $timeout timeout for connection, defaults to 5 second if not set
     * @return string content of page specified by $url
     */
    protected function getPageContent($url, $timeout = 5) {
        $curl_connection = curl_init();
        curl_setopt($curl_connection, CURLOPT_URL, $url);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($curl_connection);
        curl_close($curl_connection);
        return $content;
    }

}
