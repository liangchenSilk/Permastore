document.observe('dom:loaded', function () {

    // Attachments

    attachment_count = $$('#rfq_attachments_table tbody tr.attachment_row').length;

    Event.live('.attachments_delete', 'click', function (el) {
        if (deleteWarning(el)) {
            hideButtons();
            deleteElement(el, 'rfq_attachments');
            checkCount('rfq_attachments', 'attachments_row', 3);
            rfqHasChanged();
        }
    });

    Event.live('#add_attachment', 'click', function (el, event) {
        hideButtons();
        addAttachmentRow();
        rfqHasChanged();
        event.stop();
    });

});

function addAttachmentRow() {

    $$('#rfq_attachments_table tbody tr:not(.attachments_row)').each(function (e) {
        e.remove();
    });

    var row = $('attachments_row_template').clone(true);
    row.addClassName('new');
    row.setAttribute('id', 'attachments_' + attachments_count);
    row = resetInputs(row);

    row.down('.attachments_delete').writeAttribute('name', 'attachmentss[new][' + attachments_count + '][delete]');
    row.down('.attachments_description').writeAttribute('name', 'attachments[new][' + attachments_count + '][description]');
    row.down('.attachments_filename').writeAttribute('name', 'attachments[new][' + attachments_count + '][filename]');

    $('rfq_attachments').down('tbody').insert({bottom: row});
    colorRows('rfq_attachments', '');
    attachments_count += 1;
}
