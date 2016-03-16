<?php
namespace BookBundle\Controller;

use BookBundle\Entity\Author;
use BookBundle\Form\AddAuthorForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends Controller
{

    public function addAction(Request $request)
    {
        $form = $this->createForm(new AddAuthorForm());
        $form->handleRequest($request);

        if($form->isValid()){
            $author = $form->getData();

            $author->setActive(false);
            $uploadService = $this->get('framework_extension.upload_manager');
            $uploadService->setDocumentUploadDir(Author::IMAGE_DIR);
            $uploadService->setDocumentUrl($author,'getImage','setImage','setImageUrl','getOldImageUrl',Author::NAME_PATH);

            $doctrineService = $this->getDoctrine()->getManager();
            $doctrineService->persist($author);
            $doctrineService->flush();
        }

        return $this->render('BookBundle:Author-Add:add.html.twig',array('form' => $form->createView()));

    }
}