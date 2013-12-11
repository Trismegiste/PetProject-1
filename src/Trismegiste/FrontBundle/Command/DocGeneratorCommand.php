<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DocGeneratorCommand is a CLI which generates a full doc for one graph
 */
class DocGeneratorCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('graph:generate')
                ->setDescription('DocGenerator is a CLI which generates a full doc for one graph');
    }

    private function getRepo()
    {
        return $this->getContainer()->get('dokudoki.repository');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        $cursor = $this->getRepo()
                ->find(['-fqcn' => 'Trismegiste\FrontBundle\Model\Graph']);

        $output->writeln("Choose a graph you want to export :\n");

        $index = 0;
        $keyMap = [];
        foreach ($cursor as $graph) {
            $output->writeln(sprintf("    [<info>%s</info>]: %s", $index, $graph->getTitle()));
            $keyMap[$index] = $graph->getId();
            $index++;
        }

        $pkGraph = $dialog->askAndValidate(
                $output, 'Please enter the index of the graph you want to export in html:', function($answer) use ($keyMap) {
                    if (!array_key_exists($answer, $keyMap)) {
                        throw new \InvalidArgumentException("$answer is not a valid choice");
                    }
                    return $keyMap[$answer];
                });

        $this->exportGraph($output, $pkGraph);
    }

    protected function exportGraph(OutputInterface $output, $pkGraph)
    {
        $graph = $this->getRepo()->findByPk($pkGraph);
        $output->writeln("Exporting " . $graph->getTitle());

        $cursor = $this->getContainer()
                ->get('repository.vertex')
                ->findByGraph($graph->getId());
        $vertex = [];
        foreach ($cursor as $doc) {
            $obj = $this->getRepo()->createFromDb($doc);
            $vertex[$obj->getInfoType()][] = $obj;
        }

        $content = $this->getContainer()
                ->get('twig')
                ->render('TrismegisteFrontBundle:Command:full_doc.html.twig', [
            'vertex' => $vertex,
            'docTitle' => $graph->getTitle()
        ]);

        // replacing links (injecting another UrlGenerator in MentionMarkdown should be nice)
        $content = preg_replace_callback('#href="/vertex/([^"]+)"#', function($extract) {
                    return "href=\"#{$extract[1]}\"";
                }, $content);

        $this->getContainer()
                ->get('filesystem')
                ->dumpFile('web/result.html', $content);
    }

}