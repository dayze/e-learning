<?php


namespace QcmBundle\Service;


use AppBundle\Service\BaseService;
use QcmBundle\Entity\Qcm;
use QcmBundle\Entity\QcmQuestion;
use QcmBundle\Entity\Score;
use Symfony\Component\HttpFoundation\File\File;

class QcmService extends BaseService
{
    public function getScore($questions)
    {
        $score['nbQuestions'] = count($questions);
        $score['correctQuestions'] = 0;
        foreach ($questions as $question) {
            if ($question['qcmAnswers']->getIsCorrect()) {
                $score['correctQuestions']++;
            }
        }
        return $score;
    }

    public function setScore($questions)
    {
        $finalScore = new Score();
        $nbQuestion = count($questions);
        $correctQuestion = 0;
        foreach ($questions as $question) {
            if ($question['qcmAnswers']->getIsCorrect()) {
                $correctQuestion++;
            }
        }
        $finalScore->setNote(($correctQuestion * 20) / $nbQuestion);
        $finalScore->setStudent($this->container->get('security.token_storage')->getToken()->getUser());
        $finalScore->setQcm($questions[0][0]->getQcm());
        $this->em->persist($finalScore);
        $this->em->flush();
        return $finalScore;
    }

    public function handleImg(Qcm $qcm)
    {
        $fileUploadService = $this->container->get('app.file_uploader');
        foreach ($qcm->getQcmQuestions() as $qcmQuestion) {
            /** @var $qcmQuestion QcmQuestion */
            $file = $qcmQuestion->getImgPath();
            if (!is_null($file)) {
                $fileName = $fileUploadService->upload($file);
                $qcmQuestion->setImgPath($fileName);
            }
        }
    }

    public function handleDeleteImg(Qcm $qcm)
    {
        foreach ($qcm->getQcmQuestions() as $qcmQuestion) {
            /** @var $qcmQuestion QcmQuestion */
            if (!is_null($qcmQuestion->getImgPath())) {
                if (file_exists($this->container->getParameter('document_directory') . '/' . $qcmQuestion->getImgPath()))
                    unlink(new File($this->container->getParameter('document_directory') . '/' . $qcmQuestion->getImgPath()));
            }
        }
    }

    public function handlePathImg(Qcm $qcm)
    {
        foreach ($qcm->getQcmQuestions() as $qcmQuestion) {
            /** @var $qcmQuestion QcmQuestion */
            if (!is_null($qcmQuestion->getImgPath())) {
                $qcmQuestion->setImgPath(
                    new File($this->container->getParameter('document_directory') . '/' . $qcmQuestion->getImgPath())
                );
            }
        }
    }

    public function checkQcmProperty(Qcm $qcm)
    {
        if($qcm->isIsEvaluated()){
            if($this->container->get('app.check_role')->check('ROLE_STUDENT')){
                $user_id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
                $scoreStudent = $this->em->getRepository('QcmBundle:Qcm')->findScoreByStudent($user_id, $qcm->getId());
                return count($scoreStudent) > 0;
            }
        }
        else{
            return false;
        }
    }
}