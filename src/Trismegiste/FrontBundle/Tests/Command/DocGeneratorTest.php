<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * DocGeneratorTest tests the DocGeneratorCommand
 */
class DocGeneratorTest extends WebTestCase
{

    protected $application;

    protected function setUp()
    {
        $kernel = static::createKernel();

        // mockup filesystem component to override the dumpFile method
        $fsMock = $this->getMock('Symfony\Component\Filesystem\Filesystem');
        $fsMock->expects($this->once())
                ->method('dumpFile')
                ->will($this->returnCallback([$this, 'assertGeneratedContent']));

        $kernel->boot();
        $kernel->getContainer()->set('filesystem', $fsMock);
        // create application
        $this->application = new Application($kernel);
        // registers the command of this bundle
        $b = $this->application->getKernel()->getBundle('TrismegisteFrontBundle');
        $b->registerCommands($this->application);
        // the command manages itself to get the container with the application
    }

    public function testGeneration()
    {
        $command = $this->application->find('graph:generate');
        // mock the user's input 
        $dialog = $command->getHelper('dialog');
        // first choice
        $dialog->setInputStream($this->getInputStream("0\n"));
        // tests the command
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'filename' => 'result'
        ]);

        $this->assertRegExp('#Exporting Star Trek#', $commandTester->getDisplay());
    }

    /**
     * Simulates user's input
     */
    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }

    /**
     * Assert for the generated content (stubbed by the filesystem mockup)
     */
    public function assertGeneratedContent($fch, $cnt)
    {
        $this->assertRegExp('#Spock#', $cnt);
        $this->assertRegExp('#href="\#notfound"#', $cnt);
        $this->assertEquals('web/result.html', $fch);
    }

}