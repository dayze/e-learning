<?php


namespace QcmBundle\Service;


use AppBundle\Service\BaseService;

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
}