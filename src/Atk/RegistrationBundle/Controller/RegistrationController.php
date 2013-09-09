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

use Atk\RegistrationBundle\Entity\Registration;
use Atk\RegistrationBundle\Form\RegistrationType;
use Atk\RegistrationBundle\Form\RegistrationFilterType;

/**
 * Registration controller.
 *
 * @Route("")
 */
class RegistrationController extends Controller
{
    /**
     * Lists all Registration entities.
     *
     * @Route("/admin/registration/", name="admin_registration")
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
        $filterForm = $this->createForm(new RegistrationFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AtkRegistrationBundle:Registration')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('RegistrationControllerFilter');
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
                $session->set('RegistrationControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RegistrationControllerFilter')) {
                $filterData = $session->get('RegistrationControllerFilter');
                $filterForm = $this->createForm(new RegistrationFilterType(), $filterData);
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
            return $me->generateUrl('admin_registration', array('page' => $page));
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
     * Creates a new Registration entity.
     *
     * @Route("/admin/registration/", name="admin_registration_create")
     * @Method("POST")
     * @Template("AtkRegistrationBundle:Registration:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Registration();
        $form = $this->createForm(new RegistrationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');
            return $this->redirect($this->generateUrl('admin_registration_show', array('id' => $entity->getId())));   
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Registration entity.
     *
     * @Route("/admin/registration/new", name="admin_registration_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Registration();
        $form   = $this->createForm(new RegistrationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Registration entity.
     *
     * @Route("/admin/registration/{id}", name="admin_registration_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtkRegistrationBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registration entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Registration entity.
     *
     * @Route("/admin/registration/{id}/edit", name="admin_registration_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtkRegistrationBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registration entity.');
        }

        $editForm = $this->createForm(new RegistrationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Registration entity.
     *
     * @Route("/admin/registration/{id}", name="admin_registration_update")
     * @Method("PUT")
     * @Template("AtkRegistrationBundle:Registration:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AtkRegistrationBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registration entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RegistrationType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('admin_registration_edit', array('id' => $id)));
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
     * Deletes a Registration entity.
     *
     * @Route("/admin/registration/{id}", name="admin_registration_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AtkRegistrationBundle:Registration')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Registration entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('admin_registration'));
    }

    /**
     * Creates a form to delete a Registration entity by id.
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
     * Display form at a given EventDate.
     *
     * @Route("/registration/{eventdate}", name="form_registration")
     * @Method("GET")
     * @Template()
     */
    public function getEventDateFormAction($eventdate)
    {      
        $em = $this->getDoctrine()->getManager();
        $thisEventDate = $em->getRepository('AtkRegistrationBundle:EventDate')->findOneById($eventdate);

        $entity  = new Registration();
        $form = $this->createForm(new RegistrationType(), $entity);
   
        return $this->render('AtkRegistrationBundle:Registration:singleform.html.twig', array('eventdate' => $thisEventDate, 'form' => $form->createView()));
    }

    /**
     * Display success at a given EventDate.
     *
     * @Route("/registration/success/{eventdate}", name="form_registration_success")
     * @Method("GET")
     * @Template()
     */
    public function getEventDateFormSuccessAction($eventdate)
    {      
        $em = $this->getDoctrine()->getManager();
        $thisEventDate = $em->getRepository('AtkRegistrationBundle:EventDate')->findOneById($eventdate);
   
        return $this->render('AtkRegistrationBundle:Registration:singleform_success.html.twig', array('eventdate' => $thisEventDate));
    }

    /**
     * User created a new Registration entity.
     *
     * @Route("/registration/create/{eventdate}", name="user_registration_create")
     * @Method("POST")
     * @Template("AtkRegistrationBundle:Registration:new.html.twig")
     */
    public function userCreateAction(Request $request, $eventdate)
    {
        $entity  = new Registration();
        $form = $this->createForm(new RegistrationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $thisEventDate = $em->getRepository('AtkRegistrationBundle:EventDate')->findOneById($eventdate);
            $logger = $this->get('logger');
            $logger->info('============PRS==================='.$thisEventDate->getId());
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');
                        $logger->info('============PRS2==================='.$thisEventDate->getId());


            return $this->redirect($this->generateUrl('form_registration_success', array('eventdate' => $thisEventDate->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
}
