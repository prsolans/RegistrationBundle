<?php

namespace Atk\RegistrationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Atk\RegistrationBundle\Entity\School;
use Atk\RegistrationBundle\Form\SchoolType;
use Atk\RegistrationBundle\Form\SchoolFilterType;

/**
 * School controller.
 *
 * @Route("")
 */
class SchoolController extends Controller
{
    /**
     * Lists all School entities.
     *
     * @Route("/admin/school/", name="admin_school")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new SchoolFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AtkRegistrationBundle:School')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('SchoolControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('SchoolControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('SchoolControllerFilter')) {
                $filterData = $session->get('SchoolControllerFilter');
                $filterForm = $this->createForm(new SchoolFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder)
    {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me)
        {
            return $me->generateUrl('admin_school', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new School entity.
     *
     * @Route("/admin/school/", name="admin_school_create")
     * @Method("POST")
     * @Template("AtkRegistrationBundle:School:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new School();
        $form = $this->createForm(new SchoolType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('admin_school_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new School entity.
     *
     * @Route("/admin/school/new", name="admin_school_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new School();
        $form   = $this->createForm(new SchoolType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a School entity.
     *
     * @Route("/admin/school/{id}", name="admin_school_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtkRegistrationBundle:School')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find School entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing School entity.
     *
     * @Route("/admin/school/{id}/edit", name="admin_school_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtkRegistrationBundle:School')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find School entity.');
        }

        $editForm = $this->createForm(new SchoolType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing School entity.
     *
     * @Route("/admin/school/{id}", name="admin_school_update")
     * @Method("PUT")
     * @Template("AtkRegistrationBundle:School:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtkRegistrationBundle:School')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find School entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SchoolType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('admin_school_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a School entity.
     *
     * @Route("/admin/school/{id}", name="admin_school_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AtkRegistrationBundle:School')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find School entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('admin_school'));
    }

    /**
     * Creates a form to delete a School entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }  

    /**
     * Display all events at a given School.
     *
     * @Route("/school/{name}", name="school")
     * @Method("GET")
     * @Template()
     */
    public function getSchoolEventAction($name)
    {
        $em = $this->getDoctrine()->getManager();

        $thisSchool = $em->getRepository('AtkRegistrationBundle:School')->findOneByName($name);
        $schoolId = $thisSchool->getId();

        $events = $em->getRepository('AtkRegistrationBundle:Event')->findById($schoolId);

        if (!$thisSchool) {
            throw $this->createNotFoundException('Unable to find School entity.');
        }
   
        return $this->render('AtkRegistrationBundle:School:school.html.twig', array('school' => $thisSchool, 'events' => $events));
    }

    /**
     * Display all events at a given School.
     *
     * @Route("/school", name="allschools")
     * @Method("GET")
     * @Template()
     */
    public function getSchoolsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $schools = $em->getRepository('AtkRegistrationBundle:School')->findBy(array(), array('name' => 'ASC'));
       
        if (!$schools) {
            throw $this->createNotFoundException('Unable to find School entity.');
        }
   
        return $this->render('AtkRegistrationBundle:School:allschools.html.twig', array('schools' => $schools));
    }
}
