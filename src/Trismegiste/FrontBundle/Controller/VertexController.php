<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Controller;

use Trismegiste\FrontBundle\Model\Vertex;
use Trismegiste\FrontBundle\Form\Vertex as VertexForm;

/**
 * VertexController manages CRUD for Vertex
 */
class VertexController extends Template
{

    public function indexAction()
    {
        return $this->render('TrismegisteFrontBundle:Vertex:index.html.twig');
    }

    public function createAction()
    {
        $form = $this->createForm(new VertexForm());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $vertex = $form->getData();
                $this->get('dokudoki.repository')->persist($vertex);
                $this->get('session')->getFlashBag()->add('notice', 'Created');

                return $this->redirect($this->generateUrl('vertex_edit', ['id' => $vertex->getId()]));
            }
        }

        return $this->render('TrismegisteFrontBundle:Vertex:create.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id)
    {
        $vertex = $this->get('dokudoki.repository')->findByPk($id);
        $form = $this->createForm(new VertexForm(), $vertex);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $this->get('dokudoki.repository')->persist($vertex);
                $this->get('session')->getFlashBag()->add('notice', 'Updated');

                return $this->redirect($this->generateUrl('vertex_edit', ['id' => $vertex->getId()]));
            }
        }

        return $this->render('TrismegisteFrontBundle:Vertex:edit.html.twig', [
                    'form' => $form->createView(),
                    'vertex' => $vertex
        ]);
    }

}