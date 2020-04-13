<?php

if (!defined('_PS_VERSION_'))
    exit;

class cmntuploadodooinvoice extends Module
{
    public function __construct()
    {
      $this->name = 'cmntuploadodooinvoice';
      $this->tab = 'Use the PDF uploaded from odoo to the server when printing invoices';
      $this->version = '1.0.0';
      $this->author = 'Comunitea';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
      $this->bootstrap = true;
   
      parent::__construct();
   
      $this->displayName = $this->l('CMNT upload odoo invoices');
      $this->description = $this->l('Use the PDF uploaded from odoo to the server when printing invoices.');
   
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
    if (!parent::install())
        return false;
    return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall())
        return false;
      return true;
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit'.$this->name)) {
            $cmntuploadodooinvoicePath = strval(Tools::getValue('cmntuploadodooinvoicePath'));

            if (
                !$cmntuploadodooinvoicePath ||
                empty($cmntuploadodooinvoicePath) ||
                !Validate::isGenericName($cmntuploadodooinvoicePath)
            ) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                Configuration::updateValue('cmntuploadodooinvoicePath', $cmntuploadodooinvoicePath);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        return $output.$this->displayForm();
    }
    public function displayForm()
    {
        // Get default language
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');
    
        // Init Fields form array
        $fieldsForm[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Invoices path'),
                    'name' => 'cmntuploadodooinvoicePath',
                    'size' => 20,
                    'required' => true
                ]
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ]
        ];
    
        $helper = new HelperForm();
    
        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
    
        // Language
        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;
    
        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];
    
        // Load current value
        $helper->fields_value['cmntuploadodooinvoicePath'] = Configuration::get('cmntuploadodooinvoicePath');
    
        return $helper->generateForm($fieldsForm);
    }
    

  
}