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

    public function getContentAction()
    {
        return new Response(file_get_contents(__DIR__ . '/../Resources/views/Combat/content.html'));
    }

}