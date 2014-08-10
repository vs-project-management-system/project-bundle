<?php
namespace PMS\Bundle\ProjectBundle\Controller;

use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Request;

use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;
use \Pagerfanta\Exception\NotValidCurrentPageException;
use \Pagerfanta\View\TwitterBootstrapView;

/**
 * @Route("/categories")
 */
class CategoryController extends \PMS\Bundle\CoreBundle\Controller\Controller
{
    /**
     * @Route("/", name="pms_category_index")
     * @Template("PMSProjectBundle:Category:index.html.twig")
     */
    public function indexAction()
    {
        $this->breadcrumbs->addItem('categories');
        
        $query = $this->get('doctrine')
                          ->getRepository('PMSProjectBundle:Category')
                          ->createQueryBuilder('c')
                          ->orderBy('c.updated, c.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'categories' => $pager->getCurrentPageResults(),
          'pager' => $pager
        );
    }

    /**
     * @Route("/new", name="pms_category_new")
     * @Template("PMSProjectBundle:Category:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->breadcrumbs->addItem('categories', $this->get('router')->generate('pms_category_index'));
        
        $category = new \PMS\Bundle\ProjectBundle\Entity\Category();
        $form = $this->createForm(
            new \PMS\Bundle\ProjectBundle\Form\Type\CategoryFormType(),
            $category
        );

        if ("POST" === $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($category);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'category created.'
                );

                return $this->render(
                    'PMSProjectBundle:Project:show.html.twig',
                    array(
                        'category' => $category
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{slug}/edit", name="pms_category_edit")
     * @Template("PMSProjectBundle:Category:new.html.twig")
     */
    public function editAction($slug)
    {
        $this->breadcrumbs->addItem(
            'categories',
            $this->get('router')
                 ->generate('pms_category_edit', array('slug' => $slug))
        );
        
        $category = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Category')
                        ->findOneBySlug($slug);

        $form = $this->createForm(
            new \PMS\ProjectBundle\Form\Type\CategoryFormType(),
            $category
        );

        if (!$category) {
            $this->get('session')
                 ->getFlashBag()
                 ->add(
                     'error',
                     'could not find matching category.'
                 );
            $this->forward('pms_category_index');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/search/{query}", name="pms_category_search_q")
     * @Route("/search", name="pms_category_search")
     * @Template("PMSProjectBundle:Category:search.html.twig")
     */
    public function searchAction($query = null)
    {
        $form = $this->createForm(new \PMS\Bundle\ProjectBundle\Form\Type\ProjectSearchFormType());

        if ("POST" == $this-getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $categories = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Project')
                        ->search($query);

                return $this->render(
                    'PMSProjectBundle:Project:index.html.twig',
                    array(
                        'categories' => $categories
                    )
                );
            }
        }

        return array('form' => $form);
    }
    
    /**
     * @Route("/{slug}", name="pms_category_show")
     * @Template("PMSProjectBundle:Category:show.html.twig")
     */
    public function showAction($slug)
    {
        $category = $this->getDoctrine()
                       ->getRepository('PMSProjectBundle:Category')
                       ->findOneBySlug($slug);

        if (!$category) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching category found.'
            );
            $this->redirect(
                $this->generateUrl('pms_category_index')
            );
        }

        return array('category' => $category);
    }
}
