<?php
/**
 * Created by PhpStorm.
 * User: Naty
 * Date: 9/11/2016
 * Time: 1:44 PM
 */

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Wishlist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\Parser\Reader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WhislistController extends Controller
{
    public function addAction(Request $request)
    {
        $bookId = $request->get('bookId');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $whistlist = $this->getWhistlist($bookId, $currentUser);

        $em = $this->getDoctrine()->getManager();
        $em->persist($whistlist);
        $em->flush();

        $response['htmlContent'] = '<strong>Cartea a fost adaugata in lista de dorinte.</strong>';

        return new JsonResponse($response);
    }

    private function getWhistlist($bookId, $currentUser)
    {
        $reader = new Wishlist();

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