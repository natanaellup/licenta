<?php

namespace ActivityBundle\Controller;

use ActivityBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function addCommentAction(Request $request)
    {
        $bookId = $request->get('bookId');
        $commentValue = $request->get('commentValue');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $comment = $this->createComment($commentValue, $bookId, $currentUser);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        $currentComments = $this->getCommentsForBook($bookId);

        $response['htmlContent'] = $this->renderView('ActivityBundle:Comment:book_comments.html.twig',
            array('bookId' => $bookId, 'comments' => $currentComments));


        return new JsonResponse($response);
    }

    public function deleteCommentAction(Request $request)
    {
        $commentId = $request->get('commentId');
        $comment = $this->getDoctrine()->getManager()->getRepository('ActivityBundle:Comment')->find($commentId);
        $bookId = $comment->getBook()->getId();

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($comment);
        $manager->flush();

        $currentComments = $this->getCommentsForBook($bookId);

        $response['htmlContent'] = $this->renderView('ActivityBundle:Comment:book_comments.html.twig',
            array('bookId' => $bookId, 'comments' => $currentComments));

        return new JsonResponse($response);
    }

    /**
     * @param $bookId
     * @return \ActivityBundle\Entity\Comment[]|array
     */
    private function getCommentsForBook($bookId)
    {
        $commentRepo = $this->getDoctrine()->getManager()->getRepository('ActivityBundle:Comment');

        return $commentRepo->findBy(array('book' => $bookId));
    }

    /**
     * @param $commentValue
     * @param $bookId
     * @param $currentUser
     * @return Comment
     */
    private function createComment($commentValue, $bookId, $currentUser)
    {
        $comment = new Comment();
        $comment->setText($commentValue);
        $comment->setDateTime(new \DateTime());
        $comment->setBook($this->getBookWithId($bookId));
        $comment->setUser($currentUser);

        return $comment;
    }

    /**
     * @param $bookId
     * @return \BookBundle\Entity\Book
     */
    private function getBookWithId($bookId)
    {
        $bookRepo = $this->getDoctrine()->getManager()->getRepository('BookBundle:Book');

        return $bookRepo->find($bookId);
    }
}