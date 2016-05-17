<?php

namespace BookBundle\Block;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;

class MainFeaturedBlock extends BaseBlockService
{
    const NO_MAIN_FEATURED_BOOKS = 4;

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
            'template' => 'BookBundle:Block:main_featured_books_block.html.twig'
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $booksRepository = $this->doctrine->getManager()->getRepository('BookBundle:Book');
        $mainFeaturedBooks = $booksRepository->findBy('maineFeatured = 1');

        if (empty($mainFeaturedBooks)) {
            return new Response();
        }

        shuffle($mainFeaturedBooks);

        $mainFeaturedBooks = array_slice($mainFeaturedBooks, 0, self::NO_MAIN_FEATURED_BOOKS);

        return $this->renderResponse($blockContext->getTemplate(), array('maineFeaturedBooks' => $mainFeaturedBooks), $response);
    }
}