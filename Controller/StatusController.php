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
 * @Route("/statuses")
 */
class StatusController extends \PMS\Bundle\CoreBundle\Controller\Controller
{
    /**
     * @Route("/", name="pms_status_index")
     * @Template("PMSProjectBundle:Status:index.html.twig")
     */
    public function indexAction()
    {
        $this->breadcrumbs->addItem('statuses');
        
        $query = $this->get('doctrine')
                          ->getRepository('PMSProjectBundle:Status')
                          ->createQueryBuilder('c')
                          ->orderBy('c.updated, c.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'statuses' => $pager->getCurrentPageResults(),
          'pager' => $pager
        );
    }

    /**
     * @Route("/new", name="pms_status_new")
     * @Template("PMSProjectBundle:Status:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->breadcrumbs->addItem('statuses', $this->get('router')->generate('pms_status_index'));
        
        $status = new \PMS\Bundle\ProjectBundle\Entity\Status();
        $form = $this->createForm(
            new \PMS\Bundle\ProjectBundle\Form\Type\StatusFormType(),
            $status
        );

        if ("POST" === $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($status);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'status created.'
                );

                return $this->render(
                    'PMSProjectBundle:Project:show.html.twig',
                    array(
                        'status' => $status
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{slug}/edit", name="pms_status_edit")
     * @Template("PMSProjectBundle:Status:new.html.twig")
     */
    public function editAction($slug)
    {
        $this->breadcrumbs->addItem(
            'statuses',
            $this->get('router')
                 ->generate('pms_status_edit', array('slug' => $slug))
        );
        
        $status = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Status')
                        ->findOneBySlug($slug);

        $form = $this->createForm(
            new \PMS\ProjectBundle\Form\Type\StatusFormType(),
            $status
        );

        if (!$status) {
            $this->get('session')
                 ->getFlashBag()
                 ->add(
                     'error',
                     'could not find matching status.'
                 );
            $this->forward('pms_status_index');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/search/{query}", name="pms_status_search_q")
     * @Route("/search", name="pms_status_search")
     * @Template("PMSProjectBundle:Status:search.html.twig")
     */
    public function searchAction($query = null)
    {
        $form = $this->createForm(new \PMS\Bundle\ProjectBundle\Form\Type\ProjectSearchFormType());

        if ("POST" == $this-getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $statuses = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Project')
                        ->search($query);

                return $this->render(
                    'PMSProjectBundle:Project:index.html.twig',
                    array(
                        'statuses' => $statuses
                    )
                );
            }
        }

        return array('form' => $form);
    }
    
    /**
     * @Route("/{slug}", name="pms_status_show")
     * @Template("PMSProjectBundle:Status:show.html.twig")
     */
    public function showAction($slug)
    {
        $status = $this->getDoctrine()
                       ->getRepository('PMSProjectBundle:Status')
                       ->findOneBySlug($slug);

        if (!$status) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching status found.'
            );
            $this->redirect(
                $this->generateUrl('pms_status_index')
            );
        }

        return array('status' => $status);
    }
}
