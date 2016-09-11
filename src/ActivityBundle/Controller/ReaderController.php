<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReaderController extends Controller
{
    public function addAction(Request $request)
    {
        $bookId = $request->get('bookId');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $reader = $this->getReader($bookId, $currentUser);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reader);
        $em->flush();

        $response['htmlContent'] = '<strong>Cartea a fost citita.</strong>';

        return new JsonResponse($response);

    }

    private function getReader($bookId, $currentUser)
    {
        $reader = new Reader();

        $reader->setUser($currentUser);
        $reader->setBook($this->getBookWithId($bookId));

        return $reader;
    }

    private function getBookWithId($bookId)
    {
        $bookRepo = $this->getDoctrine()->getManager()->getRepository('BookBundle:Book');

        return $bookRepo->find($bookId);
    }


}