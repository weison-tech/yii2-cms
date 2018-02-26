/*
 * Yii2 File Kit library
 * Author: xiaomalover <xiaomalover@gmail.com>
 */

(function ($) {
    jQuery.fn.yiiUploadKit = function (options) {
        var $input = this;
        var $container = $input.parent('div');
        var $files = $('<ul>', {"class": "files"}).insertBefore($input);
        var $emptyInput = $container.find('.empty-value');

        var methods = {
            init: function () {
                if (options.multiple) {
                    $input.attr('multiple', true);
                    $input.attr('name', $input.attr('name') + '[]');
                }
                $container.addClass('upload-kit');
                if (options.sortable) {
                    $files.sortable({
                        placeholder: "upload-kit-item sortable-placeholder",
                        tolerance: "pointer",
                        forcePlaceholderSize: true,
                        update: function () {
                            methods.updateOrder()
                        }
                    })
                }
                $input.wrapAll($('<li class="upload-kit-input"></div>'))
                    .after($('<span class="glyphicon glyphicon-plus-sign add"></span>'))
                    .after($('<span class="glyphicon glyphicon-circle-arrow-down drag"></span>'))
                    .after($('<span/>', {
                        "data-toggle": "popover",
                        "class": "glyphicon glyphicon-exclamation-sign error-popover"
                    }))
                    .after(
                        '<div class="progress">' +
                        '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</li>'
                    );
                $files.on('click', '.upload-kit-item .remove', methods.removeItem);
                methods.checkInputVisibility();
                methods.fileuploadInit();
                methods.dragInit();
                if (options.acceptFileTypes && !(options.acceptFileTypes instanceof RegExp)) {
                    options.acceptFileTypes = new RegExp(eval(options.acceptFileTypes))
                }

            },
            fileuploadInit: function () {
                var $fileupload = $input.fileupload({
                    name: options.name || 'file',
                    url: options.url,
                    dropZone: $input.parents('.upload-kit-input'),
                    dataType: 'json',
                    singleFileUploads: false,
                    multiple: options.multiple,
                    maxNumberOfFiles: options.maxNumberOfFiles,
                    maxFileSize: options.maxFileSize, // 5 MB
                    acceptFileTypes: options.acceptFileTypes,
                    minFileSize: options.minFileSize,
                    messages: options.messages,
                    process: true,
                    getNumberOfFiles: methods.getNumberOfFiles,
                    start: function (e, data) {
                        $container.find('.upload-kit-input')
                            .removeClass('error')
                            .addClass('in-progress');
                        $input.trigger('start');
                        if (options.start !== undefined) options.start(e, data);
                    },
                    processfail: function (e, data) {
                        if (data.files.error) {
                            methods.showError(data.files[0].error);
                        }
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $container.find('.progress-bar').attr('aria-valuenow', progress).css(
                            'width',
                            progress + '%'
                        ).text(progress + '%');
                    },
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            if (!file.error) {
                                var item = methods.createItem(file);
                                item.appendTo($files);
                            } else {
                                methods.showError(file.errors)
                            }

                        });
                        methods.handleEmptyValue();
                        methods.checkInputVisibility();
                        $input.trigger('done');
                        if (options.done !== undefined) options.done(e, data);
                    },
                    fail: function (e, data) {
                        methods.showError(data.errorThrown);
                        if (options.fail !== undefined) options.fail(e, data);
                    },
                    always: function (e, data) {
                        $container.find('.upload-kit-input').removeClass('in-progress');
                        $input.trigger('always');
                        if (options.always !== undefined) options.always(e, data);
                    }

                });
                if (options.files) {
                    options.files.sort(function (a, b) {
                        return parseInt(a.order) - parseInt(b.order);
                    });
                    $fileupload.fileupload('option', 'done').call($fileupload, $.Event('done'), {result: {files: options.files}});
                    methods.handleEmptyValue();
                    methods.checkInputVisibility();
                }
            },
            dragInit: function () {
                $(document).on('dragover', function () {
                    $('.upload-kit-input').addClass('drag-highlight');
                });
                $(document).on('dragleave drop', function () {
                    $('.upload-kit-input').removeClass('drag-highlight');
                });
            },
            showError: function (error) {
                if ($.fn.popover) {
                    $container.find('.error-popover').attr('data-content', error).popover({
                        html: true,
                        trigger: "hover"
                    });
                }
                $container.find('.upload-kit-input').addClass('error');
            },
            removeItem: function (e) {
                var $this = $(this);
                var url = $this.data('url');
                var guid = methods.request(url, 'guid');
                if (url) {
                    $.post(url, {guid: guid}, function(data) {});
                }
                $this.parents('.upload-kit-item').remove();
                methods.handleEmptyValue();
                methods.checkInputVisibility();
            },

            request: function (url, name)
            {
                var seg = url.replace(/^\?/,'').split('&'),
                    len = seg.length, i = 0, s;
                for (; i<len; i++) {
                    if (!seg[i]) { continue; }
                    s = seg[i].split('=');
                    if (s[0].indexOf(name) != -1) {
                        return s[1];
                    }
                }
            },

            createItem: function (file) {
                var name = options.name;
                var index = methods.getNumberOfFiles();
                if (options.multiple) {
                    name += '[' + index + ']';
                }

                var item = $('<li>', {"class": "upload-kit-item done"})
                    .append($('<input/>', {
                        "name": name + '[order]',
                        "value": file.order,
                        "type": "hidden",
                        "data-role": "order"
                    }))
                    .append($('<input/>', {
                        "name": name + '[guid]',
                        "value": file.guid,
                        "type": "hidden"
                    }))
                    .append($('<span/>', {
                        "class": "name",
                        "title": file.name,
                        "text": options.showPreviewFilename ? file.name : null
                    }))
                    .append($('<span/>', {
                        "class": "glyphicon glyphicon-remove-circle remove",
                        "data-url": file.deleteUrl
                    }));
                if ((!file.type || file.type.search(/image\/.*/g) !== -1) && options.previewImage) {
                    item.removeClass('not-image').addClass('image');
                    item.prepend($('<img/>', {src: file.url}));
                    item.find('span.type').text('');
                } else {
                    item.removeClass('image').addClass('not-image');
                    item.css('backgroundImage', '');
                    item.find('span.name').text(file.name);
                }
                return item;
            },
            checkInputVisibility: function () {
                var inputContainer = $container.find('.upload-kit-input');
                if (options.maxNumberOfFiles && (methods.getNumberOfFiles() >= options.maxNumberOfFiles)) {
                    inputContainer.hide();
                } else {
                    inputContainer.show();
                }
            },
            handleEmptyValue: function () {
                if (methods.getNumberOfFiles() > 0) {
                    $emptyInput.val(methods.getNumberOfFiles())
                } else {
                    $emptyInput.removeAttr('value');
                }
            },
            getNumberOfFiles: function () {
                return $container.find('.files .upload-kit-item').length;
            },
            updateOrder: function () {
                $files.find('.upload-kit-item').each(function (index, item) {
                    $(item).find('input[data-role=order]').val(index);
                })
            }
        };

        methods.init.apply(this);
        return this;
    };

})(jQuery);
