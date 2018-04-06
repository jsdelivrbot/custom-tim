<?php

/*
 * This file is part of the T.I.M (Tag Incident Manager) project
 */

namespace App\Form\Handler;

use App\Entity\Rule;
use App\ModelManager\RuleManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RuleFormHandler
 */
class RuleFormHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var RuleManager
     */
    protected $ruleManager;

    /**
     * RuleCreationFormHandler constructor.
     * @param FormInterface $form
     * @param RuleManager   $ruleManager
     */
    public function __construct(FormInterface $form, RuleManager $ruleManager)
    {
        $this->form = $form;
        $this->ruleManager = $ruleManager;
    }


    /**
     * @param Request $request
     * @param Rule    $rule
     *
     * @return boolean
     */
    public function process(Request $request, Rule $rule)
    {
        $this->form->setData($rule);
        $this->form->handleRequest($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->ruleManager->create($rule);

            return true;
        }

        return false;
    }
}
