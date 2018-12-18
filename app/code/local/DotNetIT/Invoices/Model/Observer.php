<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class DotNetIT_Invoices_Model_Observer 
{
    public function __construct() 
    {
        
    }
    
    public function ChangeDescription($observer)
    {
        //echo'<pre>';
        //var_dump('Change Desc hit');
        //exit;
        
        $message = $observer->getEvent()->getMessage();
        $response = $message->getResponse();
        $invoice = $response->getInvoice();
        $lines = $invoice->getLines();
        $line = $lines->getLine();
        //$desc = $line->getDescription();
        foreach($line as $item)
        {
            $additional = $item->getAdditionalText();
            $item->setDescription($additional);
        }
        return $this;
    }
    
}
