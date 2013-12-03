<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Controller;

use Trismegiste\FrontBundle\Form\Graph;
use Symfony\Component\HttpFoundation\Request;

/**
 * GraphController is a crud from graph model
 */
class GraphController extends Template
{

    public function indexAction()
    {
        $cursor = $this->get('dokudoki.repository')
                ->find(['-fqcn' => 'Trismegiste\FrontBundle\Model\Graph']);
        $graph = [];
        foreach ($cursor as $doc) {
            $graph[] = $this->get('dokudoki.repository')
                    ->createFromDb($doc);
        }

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
                $vertex = $form->getData();
                $this->getRepo()->persist($vertex);
                $this->pushFlash('notice', 'Created');

                return $this->redirectRouteOk('trismegiste_homepage');
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
        $this->pushFlash('notice', 'Working document is now : Graph ' . $graph->getTitle());

        return $this->redirectRouteOk('trismegiste_homepage');
    }

}