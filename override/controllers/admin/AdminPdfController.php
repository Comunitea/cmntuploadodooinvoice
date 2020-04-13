<?php

class AdminPdfController extends AdminPdfControllerCore
{

    public function processGenerateInvoicePdf()
    {
        $invoice_folder_path = Configuration::get('cmntuploadodooinvoicePath');
        $invoice_path = NULL;
        $order_name = NULL;
        if (Tools::isSubmit('id_order')) {
            $id_order = Tools::getValue('id_order');
            $order = new Order((int)$id_order);
            if (!Validate::isLoadedObject($order)) {
                die(Tools::displayError('The order cannot be found within your database.'));
            }
            $invoice_path = $invoice_folder_path.$id_order.'.pdf';
            $order_name = $order->reference;
        } elseif (Tools::isSubmit('id_order_invoice')) {
            $id_order_invoice = Tools::getValue('id_order_invoice');
            $order_invoice = new OrderInvoice((int)$id_order_invoice);
            if (!Validate::isLoadedObject($order_invoice)) {
                die(Tools::displayError('The order invoice cannot be found within your database.'));
            }
            $id_order = $order_invoice->id_order;
            $order = new Order((int)$id_order);
            $invoice_path = $invoice_folder_path.$id_order.'.pdf';
            $order_name = $order->reference;
        } else {
            die(Tools::displayError('The order ID -- or the invoice order ID -- is missing.'));
        }
        if ($invoice_path && file_exists($invoice_path)) {
            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$order_name.'.pdf"');
            return readfile($invoice_path);
        }
        else{
            die(Tools::displayError('Invoice file not found.'));
        }
    }
}
