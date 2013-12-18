<?php

namespace Trismegiste\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Trismegiste\FrontBundle\Model\Graph;

/**
 * Design pattern : Template Method
 *
 * This is a template for a controller for the default rendering of a 
 * twitter bootstrap layout (white w/ simple black top menu)
 */
abstract class Template extends Controller
{

    protected function getRepo()
    {
        return $this->get('repository.vertex');
    }

    protected function getCollection()
    {
        return $this->get('dokudoki.collection');
    }

    public function aboutAction()
    {
        return $this->render('TrismegisteFrontBundle:Default:about.html.twig');
    }

    protected function getTopMenu()
    {
        return [
            'Create' => 'vertex_create',
            'Check Links' => 'edge_findbroken',
            'Batch insert' => 'vertex_batchcreate',
            'Combat' => 'combat_index',
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

    protected function pushFlash($type, $msg)
    {
        $this->get('session')->getFlashBag()->add($type, $msg);
    }

    protected function redirectRouteOk($name, $param = [])
    {
        return $this->redirect($this->generateUrl($name, $param));
    }

    protected function getWorkingDoc()
    {
        return $this->get('session')->get('working_doc');
    }

    protected function setWorkingDoc(Graph $doc)
    {
        $this->get('session')->set('working_doc', $doc);
    }

    protected function getGraphFilter()
    {
        $current = $this->get('session')->get('working_doc');
        return (!is_null($current)) ? $current->getId() : '';
    }

}
