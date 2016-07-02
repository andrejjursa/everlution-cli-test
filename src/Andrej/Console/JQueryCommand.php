<?php
// src/Andrej/Console/JQueryCommand.php

namespace Andrej\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JQueryCommand extends JSScriptFindingCommand {

    const RESPONSE_JQUERY_PRESENT = 0;
    const RESPONSE_JQUERY_NOT_PRESENT = 1;

    protected function configure()
    {
        $this->setName('andrej:jquery');
        $this->setDescription('This command will test if specified page contains jQuery technology.');
        $this->addArgument(
            'url',
            InputArgument::REQUIRED,
            'The URL of page where presence of jQuery have to be tested.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');

        $content = $this->getPageContent($url);

        if (is_string($content)) {
            $nodes = $this->getHTMLScriptNodes($content);
            if ($this->findJQueryInNodes($nodes)) {
                $output->writeln('Specified URL <info>contains</info> jQuery framework.');
                return self::RESPONSE_JQUERY_PRESENT;
            } else {
                $output->writeln('Specified URL <info>do not contains</info> jQuery framework.');
                return self::RESPONSE_JQUERY_NOT_PRESENT;
            }
        } else {
            $output->writeln('<error>Specified URL not found.</error>');
            return self::COMMON_ERROR_URL_NOT_FOUND;
        }
    }

    /**
     * Test if array of identifiers contains jquery identifier.
     * @param array<string> $identifiers string array of identifiers
     * @return bool presence of jquery
     */
    protected function findJQueryInIdentifiers($identifiers) {
        if (is_array($identifiers) && !empty($identifiers)) {
            foreach ($identifiers as $identifier) {
                if (strtolower($identifier) === 'jquery') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Test if jquery is present in script src.
     * @param string $src script source path
     * @return bool presence of jquery
     */
    protected function findJQueryInSrc($src) {
        if (is_string($src) && mb_strpos(strtolower($src), 'jquery') !== FALSE) {
            return true;
        }
        return false;
    }

    /**
     * Test if jquery is present in nodes.
     * @param array $nodes array of nodes [src, content]
     * @return bool presence of jquery
     */
    protected function findJQueryInNodes($nodes)
    {
        if (is_array($nodes) && !empty($nodes)) {
            foreach ($nodes as $node) {
                if (!empty($node['src'])) {
                    if ($this->findJQueryInSrc($node['src'])) {
                        return true;
                    }
                }
                if (!empty($node['content'])) {
                    $identifiers = $this->getJavaScriptIdentifier($node['content']);
                    if ($this->findJQueryInIdentifiers($identifiers)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }


}
