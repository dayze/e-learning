<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Document;
use AppBundle\Entity\Section;
use AppBundle\Form\DocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DocumentController extends Controller
{
    public function indexAction()
    {
        $documentService = $this->get('app.document');
        $documents = $documentService->findAll("AppBundle:Document");
        return $this->render('AppBundle:Document:view.html.twig', array("documents" => $documents));
    }

    public function createAction(Request $request)
    {
        $documentService = $this->get("app.document");
        $document = new Document();
        $form = $this->get("form.factory")->create(DocumentType::class, $document, array(
            'action' => $this->generateUrl('app_document_create'),
            'method' => 'POST',
            'supervisor' => $this->getUser()
        ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $document = $form->getData();
            $documentService->addSection($document, $request->request->get('appbundle_document'));
            $file = $document->getPath();
            $fileUploadService = $this->get('app.file_uploader');
            $fileName = $fileUploadService->upload($file);
            $document->setPath($fileName);
            $document->setType($fileUploadService->getTypeFile());
            $documentService->addEntity($document);
            $data = $this->renderView("AppBundle:Document/part:raw.html.twig", array("document" => $document));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', array('document' => $document,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', array(
                'form' => $form->createView()
            ))));
    }

    public function deleteAction(Document $document)
    {
        $documentService = $this->get("app.document");
        if (file_exists($this->getParameter('document_directory') . '/' . $document->getPath()))
            unlink(new File($this->getParameter('document_directory') . '/' . $document->getPath()));
        $documentService->deleteEntity($document);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, Document $document) //todo check how delete old file on edit, doctrine listener ?
    {
        $document->setPath(
            new File($this->getParameter('document_directory') . '/' . $document->getPath())
        );
        $form = $this->get("form.factory")->create(DocumentType::class, $document, array(
            'action' => $this->generateUrl('app_document_edit', array('id' => $document->getId())),
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $document->getPath();
            $fileUploadService = $this->get('app.file_uploader');
            $fileName = $fileUploadService->upload($file);
            $document->setPath($fileName);
            $document->setType($fileUploadService->getTypeFile());
            $this->getDoctrine()->getManager()->flush();
            $data = $this->renderView("AppBundle:Document/part:raw.html.twig", array("document" => $document));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $document->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', array('document' => $document,
                    'form' => $form->createView()))), 400);

        }
        return new JsonResponse(array(
            'error' => true,
            'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', array('document' => $document,
                'form' => $form->createView()))));
    }

    public function populateCourseAction(Request $request)
    {
        $id = (int)$request->get('section_id');
        $courseS = $this->get('app.course');
        $courses = $courseS->findCourseBySection('AppBundle:Course', $id);
        $result = [];
        foreach ($courses as $course) {
            $result[$course->getName()] = $course->getId();
        }
        return new JsonResponse($result);
    }

    public function populateCourseCategoryAction(Request $request)
    {
        $id = (int)$request->get('courseCategory_id');
        $courseCatS = $this->get('app.course_category');
        $courseCategories = $courseCatS->findCourseCategoryByCourse($id);
        return new JsonResponse($courseCategories);
    }

}