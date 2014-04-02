/*
 * jQuery File Upload Plugin JS Example 8.9.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, regexp: true */
/*global $, window, blueimp */

$(function () {
    'use strict';

    var id = $('#widgetId').val();
    var url = id !== undefined ? '/backend/gallery/gallery/init/wid/'+id : '/backend/gallery/gallery/init/';
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: url

    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

        // Load existing files:

        // loading png
        $('#fileupload').addClass('fileupload-processing');

        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},

            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });

    $('#fileupload').bind('fileuploadsubmit', function (e, data) {
        // The example input, doesn't have to be part of the upload form:
        var widget = $('#widgetId');
        var entity = $('#entity');
        var entityId = $('#entityId');
        var versions = $('#versions');
        var tempUrl = $('#tempUrl');
        var uploadUrl = $('#uploadUrl');
        var webTmp = $('#webTmp');
        var webUrl = $('#webUrl');
        var filePath = $('#filePath');
        var token = $('#token');
        var scriptUrl = $('#scriptUrl');

        data.formData = {
            widgetId: widget.val(),
            entity: entity.val(),
            entitytId: entityId.val(),
            versions: versions.val(),
            tempUrl: tempUrl.val(),
            uploadUrl: uploadUrl.val(),
            webTmp: webTmp.val(),
            webUrl: webUrl.val(),
            filePath: filePath.val(),
            token: token.val(),
            scriptUrl: scriptUrl.val()
        };
//        if (!data.formData.example) {
//            data.context.find('button').prop('disabled', false);
//            input.focus();
//            return false;
//        }
    });

});
