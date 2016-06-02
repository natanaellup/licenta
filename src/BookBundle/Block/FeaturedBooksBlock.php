<?php

namespace BookBundle\Block;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

class FeaturedBooksBlock extends BaseBlockService
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
            'template' => 'BookBundle:Block:slider_books_block.html.twig'
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $booksRepository = $this->doctrine->getManager()->getRepository('BookBundle:Book');
        $featuredBooks = $booksRepository->findBy(array('featured' => '1'));

        if (empty($featuredBooks)) {
            return new Response();
        }

        shuffle($featuredBooks);

        return $this->renderResponse($blockContext->getTemplate(), array('books' => $featuredBooks,
                                'sliderTitle' => 'Carti recomandate'), $response);
    }
}