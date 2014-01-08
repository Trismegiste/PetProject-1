<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Controller;

/**
 * CombatController manages combats
 */
class CombatController extends Template
{

    public function indexAction()
    {
        return $this->render('TrismegisteFrontBundle:Combat:index.html.twig');
    }

}