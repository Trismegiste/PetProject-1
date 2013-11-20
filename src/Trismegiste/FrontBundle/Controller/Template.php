<?php

namespace Trismegiste\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Design pattern : Template Method
 *
 * This is a template for a controller for the default rendering of a 
 * twitter bootstrap layout (white w/ simple black top menu)
 */
abstract class Template extends Controller
{

    public function aboutAction()
    {
        return $this->render('TrismegisteFrontBundle:Default:about.html.twig');
    }

    protected function getTopMenu()
    {
        return [
            'Create' => 'vertex_create',
            'About' => 'trismegiste_about'
        ];
    }

    /**
     * Action for the homepage
     *
     * @return Response
     */
    abstract public function indexAction();

    /**
     * Adds some data to the page before its rendering
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['topmenu'] = $this->getTopMenu();

        return parent::render($view, $parameters, $response);
    }

}
