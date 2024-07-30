define([
        "jquery",
        "Magento_Ui/js/modal/modal",
        'mage/url',
        'text!Magenmagic_QuickOrder/template/modal/modal-popup.html',
        'mage/mage',
        'mage/translate',
        'mage/validation'
    ], function ($, modal, urlBuilder, popupTpl) {
        var previewPopup = $('<div/>');

        var options = {
            type: 'popup',
            title: $.mage.__('Quick Order'),
            modalClass: 'quick-order-modal',
            popupTpl: popupTpl,
            buttons: [],
            labelProdName: $.mage.__('Product Name'),
            labelName: $.mage.__('Name'),
            labelPhoneNum: $.mage.__('Phone Number'),
            labelComment: $.mage.__('Comment'),
            submitBtn: $.mage.__('Submit')
        };

        var modalPopup = previewPopup.modal(options);
        var formPopup = modalPopup.parent().find('form');

        var url = urlBuilder.build('quickorder/index/quickorder');
        formPopup.attr('action', url);

        formPopup.validate({
            errorClass: "field-error",
            rules: {
                phone_number: {
                    required: true,
                    pattern: /^\+\d+$/
                }
            },
            messages: {
                phone_number: {
                    pattern: $.mage.__('Invalid format. Example: +123456789'),
                }
            },
            submitHandler: function () {
                $.ajax({
                    url: url,
                    data: formPopup.serialize(),
                    type: 'post',
                    showLoader: true,
                    success: function () {
                        modalPopup.modal('closeModal');
                    }
                });
            }
        });

        modalPopup.on('modalclosed', function () {
            formPopup.trigger('reset');
        });

        $(document).on('click', '.quick-order-btn', function (event) {
            event.target.blur();
            modalPopup.modal('openModal');

            var prodName = $(this).data('product-name');
            $('#popup-product-name').text(prodName);
            $('#quick-order-note').text($.mage.__(window.noteText));
        });
    }
);
