<?php

class PdfInvoiceController extends PdfInvoiceControllerCore
{

	public function display()
	{
        $invoice_folder_path = Configuration::get('cmntuploadodooinvoicePath');
        $invoice_path = NULL;
		$order_name = $this->order->reference;
		$invoice_path = $invoice_folder_path.$order_name.'.pdf';
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

