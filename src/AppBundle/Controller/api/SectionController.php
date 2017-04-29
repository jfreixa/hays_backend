<?php

namespace AppBundle\Controller\api;

use AppBundle\Entity\Section;
use AppBundle\Form\SectionType;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class SectionController extends FOSRestController
{
    /**
     * @return array
     *
     * @Get("/sections")
     */
    public function getAllSectionsAction()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Section')->findAll();

    }

    /**
     * @param Section $section
     * @return Section
     * @Get("/sections/{id}")
     */
    public function getSectionAction(Section $section)
    {
        return $section;
    }

    /**
     * @param Section $section
     * @return array
     *
     * @Delete("/sections/{id}")
     */
    public function deleteSectionAction(Section $section)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($section);
        $em->flush();

        return ['successful' => true];
    }

    /**
     * @param Request $request
     * @return Section|Form
     *
     * @Post("/sections")
     */
    public function newSectionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $section = new Section();

        $form = $this->createForm(SectionType::class, $section);
        $this->processForm($request, $form);

        if($form->isValid()) {
            $em->persist($section);
            $em->flush();

            return $section;
        }

        return $form;
    }

    /**
     * @param Request $request
     * @param Section $section
     * @return Section|Form
     *
     * @Put("/sections/{id}")
     */
    public function updateSectionAction(Request $request, Section $section)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(SectionType::class, $section);
        $this->processForm($request, $form);

        if($form->isValid()) {
            $em->persist($section);
            $em->flush();

            return $section;
        }

        return $form;
    }

    private function processForm(Request $request, Form $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}
