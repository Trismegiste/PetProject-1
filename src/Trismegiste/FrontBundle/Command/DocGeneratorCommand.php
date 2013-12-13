<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Trismegiste\FrontBundle\Utils\MentionMarkdown;
use Trismegiste\FrontBundle\Utils\InternalMentionLink;
use Trismegiste\FrontBundle\Utils\MarkdownExtension;
/**
 * DocGeneratorCommand is a CLI which generates a full doc for one graph
 */
class DocGeneratorCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('graph:generate')
                ->setDescription('DocGenerator is a CLI which generates a full doc for one graph')
                ->addArgument('filename', InputArgument::REQUIRED, "html filename to generate");
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

        $this->exportGraph($output, $pkGraph, $input->getArgument('filename'));
    }

    protected function exportGraph(OutputInterface $output, $pkGraph, $filename)
    {
        $graph = $this->getRepo()->findByPk($pkGraph);
        $output->writeln("Exporting " . $graph->getTitle());

        $cursor = $this->getContainer()
                ->get('repository.vertex')
                ->findByGraph($graph->getId());
        $cursor->sort(['title' => 1]);

        $vertex = [];
        foreach ($cursor as $doc) {
            $obj = $this->getRepo()->createFromDb($doc);
            $vertex[$obj->getInfoType()][] = $obj;
        }

        $twig = $this->getContainer()->get('twig');
        // override the markdown filter with a new instance with a fake url generator
        // Here is a successful use of the Dependency Inversion Principle
        $twig->addExtension(new MarkdownExtension(new MentionMarkdown(new InternalMentionLink(), 'vertex_findbyslug')));

        $content = $twig->render('TrismegisteFrontBundle:Command:full_doc.html.twig', [
            'vertex' => $vertex,
            'docTitle' => $graph->getTitle()
        ]);

        $this->getContainer()
                ->get('filesystem')
                ->dumpFile("web/" . $filename . ".html", $content);
    }

}