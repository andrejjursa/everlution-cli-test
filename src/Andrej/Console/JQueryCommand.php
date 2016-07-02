<?php
// src/Andrej/Console/JQueryCommand.php

namespace Andrej\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JQueryCommand extends JSScriptFindingCommand {

    protected function configure()
    {
        $this->setName('andrej:jquery');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
    }

}
