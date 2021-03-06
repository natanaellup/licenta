<?php

namespace BookBundle\Block;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class CategoryBlock extends BaseBlockService
{
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
        $categoryRepository = $this->doctrine->getRepository('BookBundle:Category');
        $categories = $categoryRepository->findAll();

        if(empty($categories)){
            return new Response();
        }

        $noActiveBooks = array();
        foreach($categories as $category){
            foreach($category->getSubcategories() as $subcategory){
                $noActiveBooks[$subcategory->getId()] = $subcategory->getNoActiveBooks();
            }
        }

        return $this->renderResponse($blockContext->getTemplate(), array('categories' => $categories,
            'noActiveBooks' => $noActiveBooks ), $response);
    }
}