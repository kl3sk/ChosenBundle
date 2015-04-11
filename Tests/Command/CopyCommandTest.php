<?php

namespace Kl3sk\ChosenBundle\Tests\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Kl3sk\ChosenBundle\Command\CopyCommand;

require_once dirname(__DIR__).'/../../../../app/AppKernel.php';

class CopyCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        
        $application = new Application($kernel);
        $application->add(new CopyCommand());

        $command = $application->find('kl3sk:chosen:copy');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/Your files have been copied to Kl3skChosenBundle/', $commandTester->getDisplay());
    }
}