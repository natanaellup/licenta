<?php

namespace BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function detailsAction(Request $request, $id)
    {
        $subcategory = $this->getDoctrine()->getRepository('BookBundle:Subcategory')->find($id);

        if(is_null($subcategory)){
            throw  new NotFoundHttpException('Categoria nu exista!');
        }

        return $this->render('BookBundle:Category:details.html.twig',array('subcategory' => $subcategory));
    }
}