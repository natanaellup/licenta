<?php

namespace BookBundle\Controller;

use BookBundle\Entity\Book;
use BookBundle\Form\BookHandlerForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        /** @var Book $book */
        $book = new Book();

        $bookForm = $this->createForm(new BookHandlerForm(),$book,array('validation_groups' => 'Add'));
        $bookForm->handleRequest($request);

        if($bookForm->isValid()){
            $book = $bookForm->getData();

            $book->setAddDate(new \DateTime());
            $book->setActive(false);
            $book->setUser($this->get('security.token_storage')->getToken()->getUser());

            $uploadService = $this->get('framework_extension.upload_manager');

            $uploadService->setDocumentUploadDir(Book::IMAGE_DIR_BOOK);
            $uploadService->setDocumentUrl($book,'getImage','setImage','setImageUrl','getOldImageUrl',Book::NAME_PATH_IMAGE);

            $uploadService->setDocumentUploadDir(Book::DOCUMENT_DIR_BOOK);
            $uploadService->setDocumentUrl($book,'getDocument','setDocument','setDocumentUrl','getOldDocumentUrl',Book::NAME_PATH_DOCUMENT);

            $doctrineService = $this->getDoctrine()->getManager();
            $doctrineService->persist($book);
            $doctrineService->flush();
        }

        return $this->render('BookBundle:Book:add.html.twig',array('form' => $bookForm->createView()));
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request,$id)
    {
        /** @var Book $book */
        $book = $this->getDoctrine()->getRepository('BookBundle:Book')->find($id);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if(is_null($book)){
            throw new NotFoundHttpException('User-ul nu exista!');
        }elseif(!is_null($user) && $user->getId() != $book->getUser()->getId()){
            throw new NotFoundHttpException('User-ul nu poate edita acest autor!');
        }

        $bookForm = $this->createForm(new BookHandlerForm(),$book,array('validation_groups' => 'Edit'));
        $bookForm->handleRequest($request);

        if($bookForm->isValid()){
            $book = $bookForm->getData();

            $book->setActive(false);

            $uploadService = $this->get('framework_extension.upload_manager');

            $uploadService->setDocumentUploadDir(Book::IMAGE_DIR_BOOK);
            $uploadService->setDocumentUrl($book,'getImage','setImage','setImageUrl','getOldImageUrl',Book::NAME_PATH_IMAGE);

            $uploadService->setDocumentUploadDir(Book::DOCUMENT_DIR_BOOK);
            $uploadService->setDocumentUrl($book,'getDocument','setDocument','setDocumentUrl','getOldDocumentUrl',Book::NAME_PATH_DOCUMENT);

            $doctrineService = $this->getDoctrine()->getManager();
            $doctrineService->persist($book);
            $doctrineService->flush();
        }

        return $this->render('BookBundle:Book:add.html.twig',array('form' => $bookForm->createView()));
    }

}