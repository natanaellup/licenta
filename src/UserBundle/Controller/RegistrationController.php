<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationController extends \FOS\UserBundle\Controller\RegistrationController
{
    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        return $this->redirectToRoute('static_pages_homepage');
    }
}