<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Controller;

/**
 * AdminController manages consistencies between vertices
 */
class AdminController extends Template
{

    public function brokenEdgeAction()
    {
        $allReport = new \SplObjectStorage();
        $cursor = $this->getCollection()->find();
        foreach ($cursor as $vertex) {
            $report = [];
            foreach (['description', 'gmOnly'] as $field) {

                $extract = [];
                preg_match_all('#@([_\w]+)#', $vertex[$field], $extract);

                foreach ($extract[1] as $edge) {
                    $found = $this->getCollection()->findOne(['slug' => str_replace('_', '-', $edge)]);
                    if (empty($found)) {
                        $report[] = $edge;
                    }
                }
            }

            if (count($report)) {
                $obj = $this->getRepo()->createFromDb($vertex);
                $allReport[$obj] = $report;
            }
        }

        return $this->render('TrismegisteFrontBundle:Admin:broken.html.twig', ['report' => $allReport]);
    }

    public function indexAction()
    {
        $form = $this->createForm(new \Trismegiste\FrontBundle\Form\MassInsert());

        return $this->render('TrismegisteFrontBundle:Admin:massinsert.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}