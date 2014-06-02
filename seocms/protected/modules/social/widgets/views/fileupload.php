<?php
/**
 * Created by PhpStorm.
 * User: Kate
 * Date: 30.05.14
 * Time: 15:38
 */
$this->widget('ext.EAjaxUpload.EAjaxUpload',
    array(
        'id'=>'uploadFile',
        'config'=>array(
            'action'=>Yii::app()->createUrl('site/upload'),
            'allowedExtensions'=>array("jpg","jpeg","gif","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
            'sizeLimit'=>1000*1024*1024,// maximum file size in bytes
            'minSizeLimit'=>1*1024,
            'auto'=>true,
            'multiple' => true,
            'onComplete'=>"js:function(id, fileName, responseJSON){ console.log(responseJSON); }",
            'messages'=>array(
                'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                'emptyError'=>"{file} is empty, please select files again without it.",
                'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
            ),
            'showMessage'=>"js:function(message){ alert(message); }"
        )

    ));
?>

<script>
    $(document).ready(function(){
        $('#fileUpload').change(function(){
            console.log(this.files);
            sendFile(this.files[0]);
            $(this).closest('form').ajaxSubmit({
                url: 'site/fileUpload',
                success: function(response) {
                    try {
                        var res = $.parseJSON(response);
                        if(res.success) {
                            addToPanel(res.files);
                        }
                    } catch( e) {

                    }
                }
            });
        });

        function sendFile(file) {
            console.log(file);
            $.ajax({
                type: 'post',
                url: '/site/fileUpload?name=' + file.name,
                data: file,
                success: function (response) {
                    //console.log(response);
                },
                xhrFields: {
                    // add listener to XMLHTTPRequest object directly for progress (jquery doesn't have this yet)
                    onprogress: function (progress) {
                        // calculate upload progress
                        var percentage = Math.floor((progress.total / progress.totalSize) * 100);
                        // log upload progress to console
                        console.log('progress', percentage);
                        if (percentage === 100) {
                            console.log('DONE!');
                        }
                    }
                },
                processData: false,
                enctype: 'multipart/form-data',
                contentType: false
//                contentType: /*file.type*/'image/jpeg'
            });
        }

        function addToPanel(paths) {
            var images = [];
            var start = $(".all-photos-thumbs .no-image").eq(0),
                index = $(".all-photos-thumbs img").index(start);
            console.log(start);
            console.log(index);
            for(var i=0;i<paths.length; i++) {
                $(".all-photos-thumbs img").eq(index).parent().remove();
            }
            var c = index-1;
            for(var i=0;i<paths.length; i++) {
                var wrap = $('<div>', {
                    'class': 'photo-wrap'
                });
                images[i] = $('<img>', {
                    src: paths[i]
                }).appendTo(wrap);
                wrap.insertAfter($(".all-photos-thumbs img").eq(c++).parent());
            }
        }

        $('body').on('click', '#upload', function(e){
            e.preventDefault();
            var formData = new FormData($(this).parents('form')[0]);

            $.ajax({
                url: '/site/fileUpload/',
                type: 'POST',
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                success: function (data) {
                    alert("Data Uploaded: "+data);
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        });

//        function
    });
</script>