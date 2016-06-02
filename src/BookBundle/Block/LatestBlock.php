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
            'template' => 'BookBundle:Block:latest_books_block.html.twig'
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $bookRepo = $this->doctrine->getManager()->getRepository('BookBundle:Book');
        $books = $bookRepo->findBy(array('active' => '1'),array('addDate' => 'DESC'),self::NO_LATEST_BOOKS);

        if(empty($books)){
            return new Response();
        }

        return $this->renderResponse($blockContext->getTemplate(), array('books' => $books), $response);
    }

}