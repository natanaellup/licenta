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
    const NO_FEATURED_BOOKS = 3;

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
            'template' => 'BookBundle:Block:featured_books_block.html.twig'
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $booksRepository = $this->doctrine->getManager()->getRepository('BookBundle:Book');
        $featuredBooks = $booksRepository->findBy('featured = 1');

        if (empty($featuredBooks)) {
            return new Response();
        }

        shuffle($featuredBooks);

        $featuredBooks = array_slice($featuredBooks, 0, self::NO_FEATURED_BOOKS);

        return $this->renderResponse($blockContext->getTemplate(), array('featuredBooks' => $featuredBooks), $response);
    }
}