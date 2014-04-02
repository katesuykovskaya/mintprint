<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 14.08.13
 * Time: 12:21
 * To change this template use File | Settings | File Templates.
 */

class FeedbackWidget extends CWidget
{
    public function init()
    {
        Yii::import('application.backend.modules.feedback.models.Feedback');
        Yii::import('application.backend.modules.feedback.components.*');
    }

    public function run()
    {
        $model = new Feedback;

        $this->render('feedbackWidget',array(
            'model'=>$model,
        ));
    }
}