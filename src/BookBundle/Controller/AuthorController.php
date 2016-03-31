<?php
namespace BookBundle\Controller;

use BookBundle\Entity\Author;
use BookBundle\Form\AddAuthorForm;
use BookBundle\Form\AuthorHandlerForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorController extends Controller
{

    /**
     * Adaugarea de catre user.
     * In momentul in care adaug un user acesta va fii inactiv.
     *
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $author = new Author();
        $form = $this->createForm(new AuthorHandlerForm(),$author,array('validation_groups' => 'Add'));
        $form->handleRequest($request);

        if($form->isValid()){
            $author = $form->getData();

            $author->setActive(false);
            $author->setUser($this->get('security.token_storage')->getToken()->getUser());
            $uploadService = $this->get('framework_extension.upload_manager');
            $uploadService->setDocumentUploadDir(Author::IMAGE_DIR);
            $uploadService->setDocumentUrl($author,'getImage','setImage','setImageUrl','getOldImageUrl',Author::NAME_PATH);

            $doctrineService = $this->getDoctrine()->getManager();
            $doctrineService->persist($author);
            $doctrineService->flush();
        }

        return $this->render('BookBundle:Author:add.html.twig',array('form' => $form->createView()));
    }

    /**
     * Editarea unui autor de catre un user.
     *
     * @param Request $request
     * @param null $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $author = $this->getDoctrine()->getEntityManager()->getRepository('BookBundle:Author')->find($id);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if(is_null($author)){
            throw new NotFoundHttpException('User-ul nu exista!');
        }elseif(!is_null($user) && $user->getId() != $author->getUser()->getId()){
            throw new NotFoundHttpException('User-ul nu poate edita acest autor!');
        }

        $form = $this->createForm(new AuthorHandlerForm(),$author,array('validation_groups' => 'Edit'));
        $form->handleRequest($request);

        if($form->isValid()){
            $author = $form->getData();

            $author->setActive(false);
            $author->setUser($user);
            $uploadService = $this->get('framework_extension.upload_manager');
            $uploadService->setDocumentUploadDir(Author::IMAGE_DIR);
            $uploadService->setDocumentUrl($author,'getImage','setImage','setImageUrl','getOldImageUrl',Author::NAME_PATH);

            $doctrineService = $this->getDoctrine()->getManager();
            $doctrineService->persist($author);
            $doctrineService->flush();
        }

        return $this->render('BookBundle:Author:edit.html.twig',array('form' => $form->createView()));
    }
    //TODO: get all active books for each authors
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $authors = $this->getDoctrine()->getEntityManager()->getRepository('BookBundle:Author')->getAllActiveUsers();

        return $this->render('BookBundle:Author:list.html.twig', array('authors' => $authors));
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @return Response
     */
    public function detailsAction(Request $request, $id)
    {
        $author = $this->getDoctrine()->getEntityManager()->getRepository('BookBundle:Author')->find($id);

        if(is_null($author) || !($author->isActive())){
            throw new NotFoundHttpException('Autorul nu exista!');
        }

        return $this->render('BookBundle:Author:details.html.twig',array('author' => $author));
    }
}