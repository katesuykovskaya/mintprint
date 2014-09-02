<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 29.08.14
 * Time: 11:23
 */
class GenerateForm extends CFormModel {
    public $count;
    public $due_date;
    public $create_date;
    public $limit=50;

    public function rules()
    {
        return array(
            array('count, due_date, limit', 'required'),
            array('count, limit', 'numerical', 'integerOnly'=>true),
        );
    }

    public function attributeLabels()
    {
        return array(
            'count'=>'Количество сертификатов',
            'due_date'=>'Дата истечения',
            'limit'=>'Ограничение по сумме'
        );
    }
}