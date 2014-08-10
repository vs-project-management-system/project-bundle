<?php
    namespace PMS\Bundle\ProjectBundle\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Request;

use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineORMAdapter;
use \Pagerfanta\Exception\NotValidCurrentPageException;
use \Pagerfanta\View\TwitterBootstrapView;

use \PMS\Bundle\ProjectBundle\Entity\Project;

class ProjectController extends \PMS\Bundle\CoreBundle\Controller\Controller
{
    /**
     * @Route("/", name="pms_project_index")
     * @Template("PMSProjectBundle:Project:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
                          ->getRepository('PMSProjectBundle:Project')
                          ->createQueryBuilder('p')
                          ->orderBy('p.updated, p.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'projects' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/new", name="pms_project_new")
     * @Template("PMSProjectBundle:Project:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(
            new \PMS\Bundle\ProjectBundle\Form\Type\ProjectFormType(),
            $project
        );

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($project);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'project created.'
                );

                return $this->render(
                    'PMSProjectBundle:Project:show.html.twig',
                    array(
                        'project' => $project
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/{slug}/edit", name="pms_project_edit")
     * @Template("PMSProjectBundle:Project:new.html.twig")
     */
    public function editAction($slug)
    {

        $project = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Project')
                        ->findOneBySlug($slug);

        $form = $this->createForm(
            new \PMS\Bundle\ProjectBundle\Form\Type\ProjectFormType(),
            $project
        );

        if (!$project) {
            $this->get('session')
                 ->getFlashBag()
                 ->add(
                     'error',
                     'could not find matching project.'
                 );
            $this->forward('pms_project_index');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/search/{query}", name="pms_project_search_q")
     * @Route("/search", name="pms_project_search")
     * @Template("PMSProjectBundle:Project:search.html.twig")
     */
    public function searchAction($query = null)
    {
        $form = $this->createForm(new \PMS\Bundle\ProjectBundle\Form\Type\ProjectSearchFormType());

        if ("POST" == $this-getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $projects = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Project')
                        ->search($query);

                return $this->render(
                    'PMSProjectBundle:Project:index.html.twig',
                    array(
                        'projects' => $projects
                    )
                );
            }
        }

        return array('form' => $form);
    }

    /**
     * @Route("/{slug}", name="pms_project_show")
     * @Template("PMSProjectBundle:Project:show.html.twig")
     */
    public function showAction($slug)
    {
        $project = $this->getDoctrine()
                        ->getRepository('PMSProjectBundle:Project')
                        ->findOneBySlug($slug);

        if (!$project) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching project found.'
            );
            $this->redirect(
                $this->generateUrl('pms_project_index')
            );
        }

        return array('project' => $project);
    }
}
