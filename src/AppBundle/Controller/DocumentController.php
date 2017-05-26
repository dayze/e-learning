<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Document;
use AppBundle\Entity\Section;
use AppBundle\Form\DocumentType;
use AppBundle\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DocumentController extends Controller
{
    public function indexAction()
    {
        $documentS = $this->get('app.document');
        $documents = $this->get('app.check_role')->check('ROLE_ADMIN') ? $documentS->findAll("AppBundle:Document")
            : $documentS->findDocumentsFromSupervisor("AppBundle:Document", $this->getUser()->getId());
        return $this->render('AppBundle:Document:view.html.twig', array("documents" => $documents));
    }

    public function createAction(Request $request)
    {
        $documentService = $this->get("app.document");
        $document = new Document();
        $supervisor_id = $this->get('app.check_role')->check('ROLE_ADMIN') ? null : $this->getUser()->getId();
        $form = $this->get("form.factory")->create(
            DocumentType::class,
            $document,
            [
                'action' => $this->generateUrl('app_document_create'),
                'method' => 'POST',
                'em' => $this->getDoctrine()->getManager(),
                'supervisor_id' => $supervisor_id
            ]
        );
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $document = $form->getData();
            $file = $document->getPath();
            $fileUploadService = $this->get('app.file_uploader');
            $fileName = $fileUploadService->upload($file);
            $document->setPath($fileName);
            $document->setType($fileUploadService->getTypeFile());
            $documentService->addEntity($document);
            //$documentService->sendMail($document);
            $data = $this->renderView("AppBundle:Document/part:raw.html.twig", array("document" => $document));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        } else if (!$form->isValid() && $request->get('isSubmit') == true) {
            return new JsonResponse(
                array(
                    'supervisor' => $this->getUser()->getId(),
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', array('document' => $document,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse([
            'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', [
                'form' => $form->createView(), 'supervisor' => $this->getUser()->getId()
            ])]);
    }

    public function deleteAction(Document $document)
    {
        $documentService = $this->get("app.document");
        $this->get('app.file_uploader')->removeElement($document);
        $documentService->deleteEntity($document);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, Document $document)
    {
        $oldPath = $document->getPath();
        $document->setPath(
            new File($this->getParameter('document_directory') . '/' . $document->getPath())
        );
        $supervisor_id = $this->get('app.check_role')->check('ROLE_ADMIN') ? null : $this->getUser()->getId();
        $form = $this->get("form.factory")->create(DocumentType::class, $document, [
            'action' => $this->generateUrl('app_document_edit', ['id' => $document->getId()]),
            'method' => 'POST',
            'em' => $this->getDoctrine()->getManager(),
            'supervisor_id' => $supervisor_id,
            'isEdit' => true
        ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $document->getPath();
            if(is_null($file)){
                $document->setPath($oldPath);
            }
            else{
                $fileUploadService = $this->get('app.file_uploader');
                $fileUploadService->removeElement($oldPath);
                $fileName = $fileUploadService->upload($file);
                $document->setType($fileUploadService->getTypeFile());
                $document->setPath($fileName);
            }

            $this->getDoctrine()->getManager()->flush();
            //$documentService->sendMail($document);
            $data = $this->renderView("AppBundle:Document/part:raw.html.twig", array("document" => $document));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $document->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $request->get('isSubmit') == true) {
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', array('document' => $document,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse([
            'form' => $this->renderView('AppBundle:Document/part:crudModal.html.twig', [
                'form' => $form->createView(), 'supervisor' => $this->getUser()->getId()
            ])]);
    }

}