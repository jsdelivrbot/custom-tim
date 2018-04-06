<?php
/*
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\Controller;

use App\Form\Handler\RuleFormHandler;
use App\Form\Type\RuleType;
use App\Entity\Rule;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default Controller
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * Display the rule form
     *
     * @param Request $req
     * @param string  $_format
     *
     * @return Response
     *
     * @Route("/rules.{_format}", defaults={"_format"="html"}, name="default_index")
     *
     * @Method("GET")
     */
    public function index(Request $req, string $_format): Response
    {
        $rule = new Rule();
        $form = $this->createForm(RuleType::class, $rule, [ 'action' => 'index.php/create', 'method' => 'POST']);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            return $this->redirectToRoute('default_index');
        }

        return $this->render('default/index.'.$_format.'.twig', [
            'format' => $_format,
            'form'   => $form->createView(),
        ]);
    }


   /**
    * Create a new Rule
    *
    * @param Request         $request
    * @param string          $_format
    * @param RuleFormHandler $formHandler
    *
    * @return Response
    *
    * @Route("/create.{_format}", defaults={"_format"="html"}, name="default_index")
    */
    public function create(Request $request, string $_format)
    {
        $rule = new Rule();
        $form = $this->createRuleForm($rule);
//      $formHandler = $this->get('app.rule.form_handler');

        if ($this->process($form, $request, $rule)) {
            $this->addFlash('success', 'All is OK.');  // TODO: Create wording in translator

            return $this->redirectToRoute('app _default_create');
        }

        return $this->render('default/index.'.$_format.'.twig', [
            'form' => $this->createRuleForm($rule)->createView(),
        ]);
    }



    /**
     * @param Rule $rule
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createRuleForm(Rule $rule)
    {
        $form = $this->createForm(RuleType::class, $rule, ['action' => '/create', 'method' => 'POST']);

        return $form;
    }

    /**
     * @param FormInterface $form
     * @param Request       $request
     * @param Rule          $rule
     *
     * @return bool
     */
    private function process(FormInterface $form, Request $request, Rule $rule)
    {
        $form->setData($rule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->ruleManager->create($rule);

            return true;
        }

        return false;
    }
}
