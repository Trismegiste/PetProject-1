<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Controller;

use Trismegiste\FrontBundle\Form\Graph;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Trismegiste\FrontBundle\Utils\Helper;

/**
 * GraphController is a crud from graph model
 */
class GraphController extends Template
{

    public function indexAction()
    {
        $cursor = $this->get('dokudoki.repository')
                ->find(['-fqcn' => 'Trismegiste\FrontBundle\Model\Graph']);
        $graph = iterator_to_array($cursor);

        return $this->render('TrismegisteFrontBundle:Graph:select.html.twig', [
                    'graph' => $graph
        ]);
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm(new Graph());

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $graph = $form->getData();
                $this->getRepo()->persist($graph);
                $this->pushFlash('notice', 'Created');

                return $this->redirectRouteOk('graph_select', ['id' => (string) $graph->getId()]);
            } else {
                $this->pushFlash('warning', 'Invalid');
            }
        }

        return $this->render('TrismegisteFrontBundle:Graph:create.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    public function selectAction($id)
    {
        $graph = $this->get('dokudoki.repository')
                ->findByPk($id);

        $this->setWorkingDoc($graph);
        $this->get('session')->getBag('history')->clear();
        $this->pushFlash('notice', 'Working document is now : Graph ' . $graph->getTitle());

        return $this->redirectRouteOk('trismegiste_homepage');
    }

    public function showAction()
    {
        return $this->render('TrismegisteFrontBundle:Graph:show.html.twig');
    }

    public function getAllNodeAction()
    {
        $cursor = $this->getRepo()->findByGraph($this->getGraphFilter());
        $nodes = [];
        $links = [];

        $shortcut = [];
        $index = 0;
        foreach ($cursor as $doc) {
            $nodes[$index] = ['name' => $doc['title'], 'group' => 1];
            $shortcut[$doc['slug']] = ['idx' => $index, 'edge' => $doc['description'] . ' ' . $doc['gmOnly']];
            $index++;
        }

        foreach ($shortcut as $doc) {

            $extract = [];
            preg_match_all('#@([_\w]+)#', $doc['edge'], $extract);

            foreach ($extract[1] as $mention) {
                $edge = Helper::mentionToSlug($mention);
                if (array_key_exists($edge, $shortcut)) {
                    $links[] = [
                        "source" => $doc['idx'],
                        "target" => $shortcut[$edge]['idx'],
                        "value" => 1
                    ];
                }
            }
        }

        return new JsonResponse(['nodes' => $nodes, 'links' => $links]);
    }

}