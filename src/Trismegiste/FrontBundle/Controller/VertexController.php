<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Controller;

use Trismegiste\FrontBundle\Model\Vertex;
use Trismegiste\FrontBundle\Form\Vertex as VertexForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    public function createAction(Request $request)
    {
        $form = $this->createForm(new VertexForm());

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $vertex = $form->getData();
                $this->getRepo()->persist($vertex);
                $this->pushFlash('notice', 'Created');

                return $this->redirectRouteOk('vertex_edit', ['id' => $vertex->getId()]);
            } else {
                $this->pushFlash('warning', 'Invalid');
            }
        }

        return $this->render('TrismegisteFrontBundle:Vertex:create.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    public function editAction($id, Request $request)
    {
        $vertex = $this->getVertex($id);
        $form = $this->createForm(new VertexForm(), $vertex);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->getRepo()->persist($vertex);
                $this->pushFlash('notice', 'Updated');

                return $this->redirectRouteOk('vertex_edit', ['id' => $vertex->getId()]);
            } else {
                $this->pushFlash('warning', 'Invalid');
            }
        }

        return $this->render('TrismegisteFrontBundle:Vertex:edit.html.twig', [
                    'form' => $form->createView(),
                    'vertex' => $vertex
        ]);
    }

    public function findSlugAction($slug)
    {
        $query = str_replace('_', ' ', $slug);
        $found = $this->getCollection()->findOne(['title' => $query]);
        if (!is_array($found)) {
            throw $this->createNotFoundException();
        }
        $vertex = $this->getRepo()->createFromDb($found);
        $this->pushHistoryStack($vertex);

        return $this->render('TrismegisteFrontBundle:Vertex:show.html.twig', ['vertex' => $vertex]);
    }

    public function getAllMentionAction()
    {
        $cursor = $this->getCollection()->find([], ['title' => true]);

        $found = [];
        foreach ($cursor as $doc) {
            $title = $doc['title'];
            $found[] = ['username' => str_replace(' ', '_', $title)];
        }

        return new JsonResponse(['users' => $found]);
    }

    public function deleteAction($id)
    {
        $vertex = $this->getCollection()->remove(['_id' => new \MongoId($id)]);
        $this->pushFlash('notice', 'Vertex deleted');

        return $this->redirectRouteOk('trismegiste_homepage');
    }

}