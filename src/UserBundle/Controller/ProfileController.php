<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\EditProfileForm;

class ProfileController extends Controller
{
    public function editAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if(!($user instanceof User)){
            throw $this->createNotFoundException('The user does not exist');
        }

        $form = $this->createForm(new EditProfileForm(), $user);
        $form->handleRequest($request);

        if($form->isValid()){
            $user = $form->getData();

            $doctrineService = $this->getDoctrine()->getManager();
            $doctrineService->persist($user);
            $doctrineService->flush();
        }

        return $this->render('UserBundle:Profile:edit.html.twig',array('form' => $form->createView()));
    }
}