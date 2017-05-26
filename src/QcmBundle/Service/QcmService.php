<?php


namespace QcmBundle\Service;


use AppBundle\Service\BaseService;
use AppBundle\Service\Mail;
use QcmBundle\Entity\Qcm;
use QcmBundle\Entity\QcmAnswer;
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

    public function setScore($questions, $flush)
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
        $flush ? $finalScore->setStudent($this->container->get('security.token_storage')->getToken()->getUser()) : false;
        $finalScore->setQcm($questions[0][0]->getQcm());
        $this->em->persist($finalScore);
        $flush ? $this->em->flush() : false;
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
        if ($qcm->isIsEvaluated()) {
            if ($this->container->get('app.check_role')->check('ROLE_STUDENT')) {
                $user_id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
                $scoreStudent = $this->em->getRepository('QcmBundle:Qcm')->findScoreByStudent($user_id, $qcm->getId());
                return count($scoreStudent) > 0;
            }
        } else {
            return false;
        }
    }

    public function saveCSV($file, Qcm $qcm)
    {
        $delim = ";";
        if (file_exists($file)) {
            $tab = file($file);
        }
        for ($i = 1; $i < sizeof($tab); $i++) {
            $ligne = preg_split("/" . $delim . "/", $tab[$i]);
            $qcmQuestion = new QcmQuestion();
            $qcmQuestion->setQuestion($ligne[0]);
            for ($j = 2; $j < count($ligne); $j++) {
                $qcmAnswer = new QcmAnswer();
                $qcmAnswer->setResponse($ligne[$j]);
                if ($j - 1 == $ligne[1]) {
                    $qcmAnswer->setIsCorrect(true);
                } else {
                    $qcmAnswer->setIsCorrect(false);
                }
                $qcmQuestion->addQcmAnswer($qcmAnswer);
            }
            $qcm->addQcmQuestion($qcmQuestion);
        }
        $this->addEntity($qcm);
    }

    public function sendMail(Qcm $qcm)
    {
        if ($qcm->getDocRelation()->getIsAvailable()) {
            $this->mail->sendMail("Ajout d'un QCM", "", "QcmBundle:mail.html.twig", [
                "name" => "",
                "id" => $qcm->getId()
            ]);
        }
    }
}