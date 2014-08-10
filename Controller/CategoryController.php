<?php
namespace PMS\Bundle\ProjectBundle\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Request;

use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;

use \PMS\ProjectBundle\Entity\Category;

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
        // get route name/params to decypher data to delimit by
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
        $category = new Category();
        $form = $this->createForm(
            new \PMS\ProjectBundle\Form\Type\CategoryFormType(),
            $category
        );

        if ('POST' == $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($category);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'category created.'
                );

                return $this->render(
                    'PMSProjectBundle:Category:show.html.twig',
                    array('category_slug' => $category->getSlug())
                );
            }
        }

        return array(
          'form' => $form->createView()
        );
    }

    /**
     * @Route("/{slug}/edit", name="pms_category_edit")
     * @Template("PMSProjectBundle:Category:new.html.twig")
     */
    public function editAction($slug)
    {

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
