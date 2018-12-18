

document.observe('dom:loaded', function () {

    window.parent.$('loading-mask').hide();


    pageHeight = $$('.quickorderpad').shift().getHeight();

    window.parent.$('linesearch-iframe').setStyle({
        height: pageHeight + 15 + 'px'
    });


    Event.live('.addall_qty', 'keyup', function (el, e) {
        //formatNumber(el, false, false);
    });

    $$('#qop-list a').invoke('observe', 'click', function (event) {
        alert(Translator.translate('That function is not available'));
        event.stop();
    });

    $$('.qop-search input[type="submit"]').invoke('observe', 'click', function (event) {
        window.parent.$('loading-mask').show();
    });

    $$('.btn-qop').invoke('observe', 'click', function (event) {

        prodArr = [];
        qtyArr = [];
        decimalArr = [];
        var message = '';
        if(checkDecimal(this.readAttribute('check'),1))
        {
        if (this.readAttribute('id') == 'add_all_to_basket') {
            $$('.addall_qty').each(function (ele) {
                if (ele.value > 0) {
                    var product = ele.readAttribute('id').replace('qty_', '');
                    name = ele.readAttribute('name');
                    if (name != 'qty') {
                        product = name.replace('super_group[', '').replace(']', '');
                    }

                    prodArr[prodArr.length] = product;
                    qtyArr[qtyArr.length] = ele.value;
                    decimalArr[decimalArr.length] = ele.readAttribute('decimal');
                    ele.value = 0;
                }
            });

            message = Translator.translate('Lines added successfully');

        } else {
            ele = this.up().select('.addall_qty').shift();

            var qnty = (ele.value == 0) ? 1 : ele.value;
            if (qnty > 0) {
                var product = ele.readAttribute('id').replace('qty_', '');
                name = ele.readAttribute('name');
                if (name != 'qty') {
                    product = name.replace('super_group[', '').replace(']', '');
                }

                prodArr[prodArr.length] = product;
                qtyArr[qtyArr.length] = qnty;
                decimalArr[decimalArr.length] = ele.readAttribute('decimal');
                ele.value = 0;
            } else {
                alert(Translator.translate('Please enter a qty'));
            }

            message = Translator.translate('Line added successfully');
        }

        if (prodArr.length > 0) {

            var url = window.parent.$('la_msq_link').value;

            var postData = {'id[]': prodArr, 'qty[]': qtyArr, 'decimal[]': decimalArr,'currency_code': window.parent.$('quote_currency_code').value}

            window.parent.$('loading-mask').show();

            this.ajaxRequest = new Ajax.Request(url, {
                method: 'post',
                parameters: postData,
                onComplete: function (request) {
                    this.ajaxRequest = false;
                }.bind(this),
                onSuccess: function (data) {
                    var msqData = data.responseText.evalJSON();
                    var showConfiguratorMessage = false;

                    for (index = 0; index < prodArr.length; index++) {
                        id = prodArr[index];
                        qty = qtyArr[index];
                        decimal = decimalArr[index];
                        pData = msqData[id];

                        separator = window.parent.$('la_separator').value;

                        if (pData.sku.search(window.parent.escapeRegExp(separator)) != -1) {
                            pData.sku = pData.sku.replace(separator + pData.uom, '');
                        }
                        if (pData.configurator == 1 || pData.type_id == 'configurable' || (pData.type_id == 'grouped' && !pData.stk_type || pData.has_options)) {
                            showConfiguratorMessage = true;
                        }

                        window.parent.addLineRow(false, pData.sku, qty, pData,false,decimal);
                    }

                    window.parent.recalcLineTotals();

                    window.parent.$('line-search').hide();
                    window.parent.$('loading-mask').hide();

                    if (showConfiguratorMessage)
                    {
                        message += '\n\n' + Translator.translate('One or more products require configuration. Please click on each "Configure" link in the lines list');
                        alert(message);
                    }
                }.bind(this),
                onFailure: function (request) {
                    window.parent.$('loading-mask').hide();
                    alert(Translator.translate('Error occured in Ajax Call'));
                }.bind(this),
                onException: function (request, e) {
                    window.parent.$('loading-mask').hide();
                    alert(e);
                }.bind(this)
            });
        }

        
    }
    event.stop();
    });

});

function formatNumber(el, allowNegatives, allowFloats) {
    var value = el.value, firstChar, nextFirst;
    if (value.length == 0)
        return;

    firstChar = value.charAt(0);
    if (allowFloats) {
        value = value.replace(/[^0-9\.]/g, '');
        nextFirst = value.charAt(0);
    } else {
        value = parseInt(value);
        nextFirst = '';
    }

    if (nextFirst == '.') {
        value = '0' + value;
    }

    if (allowNegatives && firstChar == '-') {
        value = firstChar + value;
    }

    el.value = value;
}