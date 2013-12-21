<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

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