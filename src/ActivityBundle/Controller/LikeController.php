<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Like;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LikeController extends Controller
{

    /**
     * Add Ajax action.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addLikeAction(Request $request)
    {
        $bookId = $request->get('bookId');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $like = $this->createLike($bookId, $currentUser);

        $em = $this->getDoctrine()->getManager();
        $em->persist($like);
        $em->flush();

        $noLikes = count($this->getLikesForBook($bookId));

        $response['htmlContent'] = $this->renderView('ActivityBundle:Like:book_like.html.twig',
            array('noLikes' => $noLikes));

        return new JsonResponse($response);
    }

    public function deleteLikeAction(Request $request)
    {
        $bookId = $request->get('bookId');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $like = $this->getLikesForBookAndUser($bookId, $currentUser);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($like[0]);
        $manager->flush();

        $noLikes = count($this->getLikesForBook($bookId));

        $response['htmlContent'] = $this->renderView('ActivityBundle:Like:book_like.html.twig',
            array('noLikes' => $noLikes));

        return new JsonResponse($response);
    }

    private function createLike($bookId, $user)
    {
        $like = new Like();
        $like->setUser($user);
        $like->setBook($this->getBookWithId($bookId));

        return $like;
    }

    private function getBookWithId($bookId)
    {
        $bookRepo = $this->getDoctrine()->getManager()->getRepository('BookBundle:Book');

        return $bookRepo->find($bookId);
    }

    /**
     * @param $bookId
     * @return \ActivityBundle\Entity\Comment[]|array
     */
    private function getLikesForBook($bookId)
    {
        $commentRepo = $this->getDoctrine()->getManager()->getRepository('ActivityBundle:Like');

        return $commentRepo->findBy(array('book' => $bookId));
    }

    private function getLikesForBookAndUser($bookId, $userId)
    {
        $likeRepo = $this->getDoctrine()->getManager()->getRepository('ActivityBundle:Like');

        return $likeRepo->findBy(array('book' => $bookId, 'user' => $userId));
    }
}