<?php

namespace App\Controller\Admin;

use App\Entity\Status;
use App\Form\StatusType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage status lists in the backend.
 * @Route("/admin/status")

 */
class StatusController extends AbstractController
{
    /**
     * Lists all status entities
     * @Route(".{_format}", defaults={"_format"="html"},name="admin_status_index")
     * @Method("GET")
     * @param string $_format
     * @return Response
     */
    public function index(string $_format): Response
    {
        $status = $this->getDoctrine()->getRepository(Status::class)->findAll();
        return $this->render('admin/status/index.'.$_format.'.twig', ['status' => $status]);
    }

    /**
     * Creates a new status entity.
     * @Route("/new", name="admin_status_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $status = new Status();

        $form = $this->createForm(StatusType::class, $status)->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush();

            $this->addFlash('success', 'status.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_status_new');
            }

            return $this->redirectToRoute('admin_status_index');
        }

        return $this->render('admin/status/new.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a status entity.
     *
     * @Route("/{id}.{_format}", defaults={"_format"="html"}, requirements={"id": "\d+"}, name="admin_status_show")
     * @Method("GET")
     *
     * @param Status $status
     * @param string $_format
     * @return Response
     */
    public function show(Status $status, string $_format): Response
    {
//        $this->denyAccessUnlessGranted('show', $status, 'status can only be shown by admin.');

        return $this->render('admin/status/show.'.$_format.'.twig', [
            'status' => $status,
        ]);
    }

    /**
     * Displays a form to edit an existing status entity.
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_status_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Status $status): Response
    {
//        $this->denyAccessUnlessGranted('edit', $status, 'Posts can only be edited by admin.');

        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'status.updated_successfully');

            return $this->redirectToRoute('admin_status_edit', ['id' => $status->getId()]);
        }

        return $this->render('admin/status/edit.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Status entity.
     *
     * @Route("/{id}/delete", name="admin_status_delete")
     * @Method("POST")
     *
     */
    public function delete(Request $request, Status $status): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_status_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($status);
        $em->flush();

        $this->addFlash('success', 'status.deleted_successfully');

        return $this->redirectToRoute('admin_status_index');
    }
}
