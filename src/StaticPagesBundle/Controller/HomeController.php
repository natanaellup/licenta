<?php

namespace StaticPagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('StaticPagesBundle:Home:home.html.twig');
    }
}
