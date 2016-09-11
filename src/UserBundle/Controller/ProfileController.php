<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\EditProfileForm;

class ProfileController extends \FOS\UserBundle\Controller\ProfileController
{
    /**
     * Directorul unde se vor salva pozele pentru profilul unui user.
     *
     * @var string
     */
    const PHOTO_DIRECTORY = 'uploads/user_avatar';

    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $bookLikes = $this->getBookForItem($user->getLike());
        $bookWishlist = $this->getBookForItem($user->getWishlists());
        $bookReader = $this->getBookForItem($user->getReaders());

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user, 'bookLikes' => $bookLikes, 'bookWishlist' => $bookWishlist, 'bookReader' => $bookReader
        ));
    }

    public function showProfileAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($id);

        if(is_null($user)){
            throw new NotFoundHttpException('User-ul nu exista!');
        }

        $bookLikes = $this->getBookForItem($user->getLike());
        $bookWishlist = $this->getBookForItem($user->getWishlists());
        $bookReader = $this->getBookForItem($user->getReaders());

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user, 'bookLikes' => $bookLikes, 'bookWishlist' => $bookWishlist, 'bookReader' => $bookReader
        ));

    }

    private function getBookForItem($items)
    {
        $book = array();
        foreach($items as $item){
            $book[] = $item->getBook();
        }

        return $book;
    }

    /**
     * Actiunea de editare a unui user.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

            $uploadManager = $this->get('framework_extension.upload_manager');
            $uploadManager->setDocumentUploadDir(self::PHOTO_DIRECTORY);
            $uploadManager->setDocumentUrl($user,'getAvatar','setAvatar','setAvatarUrl','getOldAvatarUrl','avatar');

            $doctrineService = $this->getDoctrine()->getManager();
            $doctrineService->persist($user);
            $doctrineService->flush();
        }

        return $this->render('UserBundle:Profile:edit.html.twig',array('form' => $form->createView()));
    }
}