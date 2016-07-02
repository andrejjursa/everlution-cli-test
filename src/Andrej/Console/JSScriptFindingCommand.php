<?php
// src/Andrej/Console/JSScriptFindingCommand

namespace Andrej\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../../../vendor/timwhitlock/jparser/PLUG/JavaScript/j_token_get_all.php';
require __DIR__ . '/../../../vendor/timwhitlock/jparser/PLUG/JavaScript/j_token_name.php';

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
        curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true);
        $content = curl_exec($curl_connection);
        curl_close($curl_connection);
        return $content;
    }

    protected function getHTMLScriptNodes($html_content) {
        $crawler = new Crawler($html_content);

        $nodes = $crawler->filter('script')->each(function(Crawler $node, $i) {
            return ['content' => $node->text(), 'src' => $node->attr('src')];
        });

        return $nodes;
    }

    protected function getJavaScriptIdentifier($js_code) {
        $identifiers = [];
        $identifiers_map = [];
        $tokens = j_token_get_all($js_code);
        if (is_array($tokens) && !empty($tokens)) {
            foreach ($tokens as $token) {
                if (j_token_name($token[0]) == 'J_IDENTIFIER' && !array_key_exists($token[1], $identifiers_map)) {
                    $identifiers[] = $token[1];
                    $identifiers_map[$token[1]] = true;
                }
            }
        }
        return $identifiers;
    }

}
