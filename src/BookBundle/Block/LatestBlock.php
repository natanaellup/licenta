<?php

namespace BookBundle\Block;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class LatestBlock extends BaseBlockService
{
    const NO_LATEST_BOOKS = 6;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * CategoryBlock constructor.
     * @param string $name
     * @param EngineInterface $templating
     * @param Registry $doctrine
     */
    public function __construct($name, EngineInterface $templating, Registry $doctrine)
    {
        parent::__construct($name, $templating);

        $this->doctrine = $doctrine;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'BookBundle:Block:categories_block.html.twig'
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
//        $categoryRepository = $this->doctrine->getRepository('BookBundle:Category');
//        $categories = $categoryRepository->findAll();
//
//        if(empty($categories)){
//            return new Response();
//        }
//
//        $noActiveBooks = array();
//
//        foreach($categories as $category){
//            $noActiveBooks[$category->getId()] = $category->getNoActiveBooks();
//        }
//
//        return $this->renderResponse($blockContext->getTemplate(), array('categories' => $categories, 'noActiveBooks' => $noActiveBooks ), $response);
    }

}