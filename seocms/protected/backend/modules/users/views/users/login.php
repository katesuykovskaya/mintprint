<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Unicorn Admin</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/css/unicorn/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/css/unicorn/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/css/unicorn/css/unicorn.login.css" />
    </head>
    <body>
        <div id="logo">
            <!--<img src="img/logo.png" alt="" />-->
        </div>
        <div id="loginbox">            
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                    ),
            )); ?>

                    <?php echo $form->errorSummary($model); ?>

                    <div class="row">
                            <?php echo $form->labelEx($model,'username'); ?>
                            <?php echo $form->textField($model,'username'); ?>
                            <?php //echo $form->error($model,'username'); ?>
                    </div>

                    <div class="row">
                            <?php echo $form->labelEx($model,'password'); ?>
                            <?php echo $form->passwordField($model,'password'); ?>
                            <?php //echo $form->error($model,'password'); ?>
                    </div>

                    <div class="row rememberMe">
                            <?php echo $form->checkBox($model,'rememberMe'); ?>
                            <?php echo $form->label($model,'rememberMe'); ?>
                            <?php //echo $form->error($model,'rememberMe'); ?>
                    </div>

                    <div class="row buttons">
                            <?php echo CHtml::submitButton('Login'); ?>
                    </div>

            <?php $this->endWidget(); ?>
        </div>
        
<!--        <script src="/css/unicorn/js/jquery.min.js"></script>  -->
<!--        <script src="/css/unicorn/js/unicorn.login.js"></script> -->
    </body>
</html>
