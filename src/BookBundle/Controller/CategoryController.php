<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    //TODO: get all active book for each categories
    public function listAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('BookBundle:Category')->findAll();

        return $this->render('BookBundle:Category:list.html.twig', array('categories' => $categories));
    }

    public function detailsAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository('BookBundle:Category')->find($id);

        if(is_null($category)){
            throw  new NotFoundHttpException('Categoria nu exista!');
        }

        return $this->render('BookBundle:Category:details.html.twig',array('category' => $category));
    }
}