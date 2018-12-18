<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class DotNetIT_OrderInfo_Model_Observer 
{
    public function __construct() 
    {
        
    }
    
    public function ChangeDescription($observer)
    {
        echo'<pre>';
        var_dump('Change Desc hit');
        exit;
        
        
    }
    
}
