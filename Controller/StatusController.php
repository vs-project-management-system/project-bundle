<?php
namespace PMS\ProjectBundle\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Request;

use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;
use \Pagerfanta\Exception\NotValidCurrentPageException;
use \Pagerfanta\View\TwitterBootstrapView;

use \PMS\ProjectBundle\Entity\Status;

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
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
                          ->getRepository('PMSProjectBundle:Status')
                          ->createQueryBuilder('p')
                          ->orderBy('p.updated, p.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'statuses' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="pms_status_new")
     * @Template("PMSProjectBundle:Status:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $status = new Status();
        $form = $this->createForm(new StatusFormType(), $status);

        if ("POST" == $request->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($status);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'status created.'
                );

                return $this->render(
                    'PMSProjectBundle:Status:show.html.twig',
                    array(
                        'status_slug' => $status->getSlug()
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

        $status = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Status')
                        ->findOneBySlug($slug);

        $form = $this->createForm(new \PMS\ProjectBundle\Form\Type\StatusFormType(), $status);

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
        $this->getDoctrine()
            ->getRepository('PMSProjectBundle:Status')
            ->search($query);
        return array();
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
