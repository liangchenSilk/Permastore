

function salesRepCloneLineRow(row, product) {

    if (row.down('.discount')) {
        var discountField = row.down('.discount');
        var priceField = row.down('.lines_price');

        product.salesrep_base_price = priceField.readAttribute('base-value');
        product.salesrep_min_price = priceField.readAttribute('min-value');
        product.salesrep_price_title = priceField.readAttribute('title');
        product.salesrep_max_discount = discountField.readAttribute('max-value');
        product.salesrep_discount_title = discountField.readAttribute('title');

    }

    return row;
}

function salesRepAddLineRow(rowid, row, product, requires_configuration) {

    if (!requires_configuration && !product.is_custom && !valueEmpty(product.salesrep_price_title)) {

        priceparent = row.down('.lines_price').parentNode;

        if (row.hasClassName('new')) {
            rowname = 'new';
        } else {
            rowname = 'existing';
        }

        replacerow = true;
        
        var discountValue = 0;

        if (!valueEmpty(product.salesrep_discount_value)) {
            discountValue = product.salesrep_discount_value;
        }

        var base_price = product.use_price;

        var use_price = parseFloat(product.use_price).toFixed(2);

        if (!valueEmpty(product.salesrep_base_price)) {
            base_price = product.salesrep_base_price;
            use_price = parseFloat(product.salesrep_base_price).toFixed(2);
        }

        var rule_price = base_price;

        if (!valueEmpty(product.salesrep_rule_price)) {
            rule_price = product.salesrep_rule_price;
        }

        if (row.down('.lines_price')) {
            if (!valueEmpty(row.down('.lines_price').readAttribute('min-value'))) {
                if (row.down('.sr_base_price').value == base_price && row.down('.lines_price').readAttribute('min-value') == product.salesrep_min_price) {
                    replacerow = false;
                }
            }
        }

        if (replacerow && base_price > 0 && rule_price > 0 && rule_price > product.salesrep_min_price) {

            priceparent.innerHTML = '';
            
            var resetStyle = (parseFloat(base_price) == parseFloat(use_price)) ? 'style="display:none"' : '';
                                   
            html = '<div class="salesrep-discount-container" id="cart-item-' + rowid + '">';
            html += $('quote_currency_symbol').value + '<input type="text" salesrep-cartid="' + rowid + '" salesrep-type="price" name="lines[' + rowname + '][' + rowid + '][price]" min-value="' + product.salesrep_min_price + '" base-value="' + rule_price + '" orig-value="' + use_price + '" web-price-value="' + base_price + '" value="' + use_price + '" size="12" title="' + product.salesrep_price_title + '" class="input-text price lines_price no_update disabled" maxlength="20" />'
            html += '<p>'+ product.salesrep_discount_title + '<input type="text" salesrep-cartid="' + rowid + '" salesrep-type="discount" name="lines[' + rowname + '][' + rowid + '][discount]" max-value="' + product.salesrep_max_discount + '" orig-value="0" size="4" title="' + product.salesrep_discount_title + '" class="input-text discount disabled" maxlength="12" value="' + discountValue + '"/>%</p>';            html += '<input type="hidden" class="sr_base_price" value="' + base_price + '" name="lines[' + rowname + '][' + rowid + '][sr_base_price]"/>'
            html += '<div id="reset_discount_' + rowid + '" ' + resetStyle + '><a href="javascript:resetDiscount(\'' + rowid + '\')">' + Translator.translate('Revert to Web Price') + '</a></div>'
            html += '<span class="lines_price_display" style="display:none"></span>';
            html += '</div>';

            priceparent.innerHTML = html;

            salesrepPricing.initializeElement(priceparent);
        }
    }

    return row;
}

document.observe('dom:loaded', function () {
    if ($('rfq_save')) {
        addRowProcessor(salesRepAddLineRow);
        addRowCloneProcessor(salesRepCloneLineRow);
    }
});