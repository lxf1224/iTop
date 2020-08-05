<?php


SetupWebPage::AddModule(
	__FILE__,
	'itop-tickets/2.8.0',
	array(
		// Identification
		//
		'label' => 'Tickets Management',
		'category' => 'business',

		// Setup
		//
		'dependencies' => array(
		),
		'mandatory' => false,
		'visible' => true,
		'installer' => 'TicketsInstaller',

		// Components
		//
		'datamodel' => array(
			'main.itop-tickets.php',
			'model.itop-tickets.php',
		),
		'data.struct' => array(
	//		'data.struct.ta-actions.xml',
		),
		'data.sample' => array(
		),
		
		// Documentation
		//
		'doc.manual_setup' => '/documentation/itop-tickets.htm',
		'doc.more_information' => '',

		// Default settings
		//
		'settings' => array(
		),
	)
);

// Module installation handler
//
class TicketsInstaller extends ModuleInstallerAPI
{
	public static function AfterDatabaseCreation(Config $oConfiguration, $sPreviousVersion, $sCurrentVersion)
	{
		// Delete all Triggers corresponding to a no more valid class
		CMDBObject::SetTrackInfo('Uninstallation');
		$oSearch = new DBObjectSearch('TriggerOnObject');
		$oSet = new DBObjectSet($oSearch);
		while($oTrigger = $oSet->Fetch())
		{
			if (!MetaModel::IsValidClass($oTrigger->Get('target_class')))
			{
				$oTrigger->DBDelete();
			}
		}
	}
}
