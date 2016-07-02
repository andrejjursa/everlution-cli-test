<?php
// src/Andrej/Console/JQueryCommand.php

namespace Andrej\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JQueryCommand extends JSScriptFindingCommand {

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

        } else {
            $output->writeln('<error>Specified URL not found.</error>');
            return self::COMMON_ERROR_URL_NOT_FOUND;
        }
    }

}
