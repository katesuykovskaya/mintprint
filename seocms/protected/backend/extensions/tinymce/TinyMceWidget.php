<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lesha
 * Date: 03.09.13
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

class TinyMceWidget extends CWidget {

    public $editor = null;
    public $language = 'ru';
    public $model = null;
    public $attribute = null;


    public function init()
    {
        $this->editor = (isset(Yii::app()->params['wysiwyg'])) ? Yii::app()->params['wysiwyg'] : 'tinymce';

        switch($this->editor){

            case('tinymce'):
                Yii::app()->clientScript->registerScriptFile('/js_plugins/tinymce/tinymce.min.js');
                Yii::app()->clientScript->registerScript('sc1','
                    tinymce.init({
//                    selector: "'.$this->attribute.'",
                    relative_urls: false,
                    mode : "specific_textareas",
                    editor_selector : "'.$this->attribute.'",
                    theme: "modern",
            //        width: 300,
            //        height: 600,
                    plugins: [
                        "advlist autolink autoresize link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    language: "'.$this->language.'",
                    autoresize_min_height: 300,
                    font_formats: "Arial=arial,helvetica,sans-serif;"+
                        "Arial Black=arial black,avant garde;"+
                        "Comic Sans MS=comic sans ms,sans-serif;"+
                        "Book Antiqua=book antiqua,palatino;"+
                        "Georgia=georgia,palatino;"+
                        "Courier New=courier new,courier,monospace;"+
                        "AkrutiKndPadmini=Akpdmi-n"+
                        "Gill Sans MT=gill_sans_mt;"+
                        "Gill Sans MT Bold=gill_sans_mt_bold;"+
                        "Gill Sans MT BoldItalic=gill_sans_mt_bold_italic;"+
                        "Gill Sans MT Italic=gill_sans_mt_italic;"+
                        "Helvetica=helvetica;"+
                        "Impact=impact,chicago;"+
                        "Iskola Pota=iskoola_pota;"+
                        "Iskola Pota Bold=iskoola_pota_bold;"+
                        "Symbol=symbol;"+
                        "Tahoma=tahoma,arial,helvetica,sans-serif;"+
                        "Terminal=terminal,monaco;"+
                        "Times New Roman=times new roman,times;"+
                        "Trebuchet MS=trebuchet ms,geneva;"+
                        "Verdana=verdana,geneva;"+
                        "Webdings=webdings;"+
                        "Wingdings=wingdings,zapf dingbats",
            //        content_css: "/js_plugins/tinymce/plugins/filemanager/css/content.css",
                    toolbar: "code insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [
                        {title: "Bold text", inline: "b"},
                        {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
                        {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
                        {title: "Example 1", inline: "span", classes: "example1"},
                        {title: "Example 2", inline: "span", classes: "example2"},
                        {title: "Table styles"},
                        {title: "Table row 1", selector: "tr", classes: "tablerow1"},
                    ]
                });
             ');

            break;

            case('ckeditor'):

                Yii::app()->clientScript->registerScriptFile('/js_plugins/ckeditor/ckeditor.js');
                Yii::app()->clientScript->registerScriptFile('/js_plugins/ckeditor/adapters/jquery.js');
                Yii::app()->clientScript->registerScript('ckeditor1','
                    $( ".'.$this->attribute.'" ).ckeditor();
                    ');
            break;

            case('redactor'):

                Yii::import('ext.imperavi.ImperaviRedactorWidget');
                $this->widget('ImperaviRedactorWidget', array(
                    // Селектор для textarea
                    'selector' => '.'.$this->attribute,
                    // Немного опций, см. http://imperavi.com/redactor/docs/
                    'options' => array(
                        'autoresize'=>true,
                        'lang'=>$this->language,
                    ),
                    'plugins' => array(
                        'fullscreen' => array(
                            'js' => array('fullscreen.js',),
                        ),
                        'fontsize' => array(
                            'js' => array('fontsize.js',),
                        ),
                        'fontfamily' => array(
                            'js' => array('fontfamily.js',),
                        ),
                        'textdirection' => array(
                            'js' => array('textdirection.js',),
                        ),
                    )
                ));

                break;
        }

    }

    public function run()
    {
    }

}