<?php

$tpl = erLhcoreClassTemplate::getInstance('lhinstance/edit.tpl.php');

$Instance =erLhcoreClassModelInstance::fetch((int)$Params['user_parameters']['instance_id']);

if ( isset($_POST['Cancel_departament']) ) {
    erLhcoreClassModule::redirect('instance/list');
    exit;
}

if (isset($_POST['Update_departament']) || isset($_POST['Save_departament'])  )
{
   $definition = array(
        'Address' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'Email' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'validate_email'
        ),
        'Request' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'string'
        ),
        'RequestUsed' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
        ),
        'Status' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int',array('min_range' => 0)
        ),
        'Expires' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'string'
        )
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( $form->hasValidData( 'Address' ) )
    {
        $Instance->address = $form->Address;
    }

    if ( $form->hasValidData( 'Email' ) )
    {
        $Instance->email = $form->Email;
    } else {
    	$Errors[] = 'Please enter valid e-mail';
    }

    if ( $form->hasValidData( 'Request' ) )
    {
        $Instance->request = $form->Request;
    }

    if ( $form->hasValidData( 'RequestUsed' ) )
    {
        $Instance->request_used = $form->RequestUsed;
    }

    if ( $form->hasValidData( 'Status' ) )
    {
        $Instance->status = $form->Status;
    }

    if ( $form->hasValidData( 'Expires' ) && ($time = strtotime($form->Expires)) !== false )
    {
    	$Instance->expires = $time;
    } else {
    	$Errors[] = 'Please enter valid date';
    }

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
     	erLhcoreClassModule::redirect('instance/list');
    	exit;
    }

    if (count($Errors) == 0)
    {
        $Instance->saveThis();

        if (isset($_POST['Save_departament'])) {
            erLhcoreClassModule::redirect('instance/list');
            exit;
        } else {
            $tpl->set('updated',true);
        }

    }  else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->set('instance',$Instance);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','System configuration')),
array('url' => erLhcoreClassDesign::baseurl('instance/list'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Instances')),
array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Edit an instance').' - '.$Instance->address));

?>