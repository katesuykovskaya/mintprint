<?php

class DefaultController extends Controller
{
    public function filters()
    {
        return array(
//		    'rights',
            array('auth.filters.AuthFilter'),
        );
    }

	public function actionIndex()
	{
		$this->render('index');
	}
}