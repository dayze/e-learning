<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Section;
use AppBundle\Entity\Student;
use AppBundle\Form\PdfType;
use AppBundle\Form\SectionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends Controller
{
    public function displayAction()
    {
        $sectionService = $this->get("app.section");
        if ($this->get('app.check_role')->check("ROLE_ADMIN")) {
            $sections = $sectionService->findAll("AppBundle:Section");

        } else {
            $sections = $sectionService->findSectionBySupervisor($this->getUser()->getId());
        }

        return $this->render('AppBundle:Section:viewSection.html.twig', array("sections" => $sections));
    }

    /*************************************CRUD**************************************************/

    public function createAction(Request $request)
    {
        $sectionService = $this->get("app.section");
        $section = new Section();
        $form = $this->get("form.factory")->create(SectionType::class, $section, array(
            'action' => $this->generateUrl('app_createSection'),
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $section = $form->getData();
            $sectionService->addEntity($section);
            $data = $this->renderView("AppBundle:Section/part:raw.html.twig", array("section" => $section));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Section/part:addSectionModal.html.twig', array('section' => $section,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('AppBundle:Section/part:addSectionModal.html.twig', array(
                'form' => $form->createView()
            ))));
    }

    public function deleteAction(Section $section)
    {
        $sectionService = $this->get("app.section");
        $sectionService->deleteEntity($section);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, Section $section)
    {
        $form = $this->get("form.factory")->create(SectionType::class, $section, array(
            'action' => $this->generateUrl('app_editSection', array('id' => $section->getId())),
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $data = $this->renderView("AppBundle:Section/part:raw.html.twig", array("section" => $section));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $section->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:Section/part:addSectionModal.html.twig', array('section' => $section,
                    'form' => $form->createView()))), 400);

        }
        return new JsonResponse(array(
            'error' => true,
            'form' => $this->renderView('AppBundle:Section/part:addSectionModal.html.twig', array('section' => $section,
                'form' => $form->createView()))));
    }

    public function pdfDateAction(Request $request)
    {
        $form = $this->get("form.factory")->create(PdfType::class, null, [
            "action" => $this->generateUrl('app_display_pdf_date'),
            'method' => 'POST']);
        $form->add('section_id', HiddenType::class, [
           "data" => $request->request->get('section_id')
        ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $sectionId = $request->request->get('pdf')["section_id"];
            $section = $this->getDoctrine()->getRepository('AppBundle:Section')->getTimeRetrieveForSectionAndMonth($sectionId, null);
            /** @var $section Section */
            foreach ($section->getStudents() as $student) {
                /** @var $student Student */
                $student->setTotalRetrieveTime($this->get('app.retrievetime')->getTimeRetrieve($student));
            }
            $view = $this->render('AppBundle::pdf.html.twig', ["section" => $section]);
            return $view;
            //return $this->get('app.pdf_maker')->makePdf($view);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:Section/part:pdfModal.html.twig', [
                    'form' => $form->createView()])), 400);
        }
        return new JsonResponse(array(
            'error' => false,
            'form' => $this->renderView('AppBundle:Section/part:pdfModal.html.twig', ['form' => $form->createView()])));

    }


}