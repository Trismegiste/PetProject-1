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

    protected function getVertex($id)
    {
        return $this->getRepo()->findByPk($id);
    }

    public function indexAction()
    {
        $cursor = $this->getCollection()->find();

        $vertex = [];
        foreach ($cursor as $doc) {
            $obj = $this->getRepo()->createFromDb($doc);
            $vertex[$obj->getInfoType()][] = $obj;
        }

        return $this->render('TrismegisteFrontBundle:Vertex:index.html.twig', ['vertex' => $vertex]);
    }

    protected function pushHistoryStack(Vertex $v)
    {
        return $this->get('session')
                        ->getBag('history')
                        ->push($this->generateUrl('vertex_show', ['id' => $v->getId()]), $v->getTitle());
    }

    public function showAction($id)
    {
        $vertex = $this->getVertex($id);
        $this->pushHistoryStack($vertex);

        return $this->render('TrismegisteFrontBundle:Vertex:show.html.twig', ['vertex' => $vertex]);
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
        $vertex = $this->getVertex($id);
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