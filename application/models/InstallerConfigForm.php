<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * LimeSurvey
* Copyright (C) 2007 The LimeSurvey Project Team / Carsten Schmitz
* All rights reserved.
* License: GNU/GPL License v2 or later, see LICENSE.php
* LimeSurvey is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
*	$Id$
*	Files Purpose: lots of common functions
*/

class InstallerConfigForm extends CFormModel
{
	// Database
	public $dbtype;
	public $dblocation = 'localhost';
	public $dbname;
	public $dbuser;
	public $dbpwd;
	public $dbprefix = 'lime_';

	public $supported_db_types = array();
	public $db_names = array(
		'mysql' => 'MySQL',
		'mysqli' => 'MySQL (newer driver)',
		'sqlsrv' => 'Microsoft SQL Server (sqlsrv)',
		'mssql' => 'Microsoft SQL Server (mssql)',
		//		'dblib' => 'Microsoft SQL Server (dblib)',
	//		'sybase' => 'Microsoft SQL Server (sybase)',
		'pgsql' => 'PostgreSQL',
	);

	// Optional
	public $adminLoginPwd = 'password';
	public $confirmPwd = 'password';
	public $adminLoginName = 'admin';
	public $adminName = 'Administrator';
	public $adminEmail = 'your-email@example.net';
	public $siteName = 'LimeSurvey';
	public $surveylang = 'en';

	public function __construct($scenario = 'database') {
		$drivers=array();
		if (extension_loaded('pdo'))
		{
			$drivers=CDbConnection::getAvailableDrivers();
		}
		foreach($drivers as $driver) {
			if (isset($this->db_names[$driver]))
				$this->supported_db_types[$driver] = $this->db_names[$driver];
		}

		asort($this->supported_db_types);

		parent::__construct();

		// Default is database
		$this->setScenario($scenario);
	}

	public function rules()
	{
		return array(
			// Database
			array('dbtype, dblocation, dbname, dbuser', 'required', 'on' => 'database'),
			array('dbpwd, dbprefix', 'safe', 'on' => 'database'),
			array('dbtype', 'in', 'range' => array_keys(CDbConnection::getAvailableDrivers()), 'on' => 'database'),

			//Optional
			array('adminLoginName, adminName, siteName, confirmPwd', 'safe', 'on' => 'optional'),
			array('adminEmail', 'email', 'on' => 'optional'),
			array('surveylang', 'in', 'range' => array_keys(getLanguageData(true, Yii::app()->session['installerLang'])), 'on' => 'optional'),
			array('adminLoginPwd', 'compare', 'compareAttribute' => 'confirmPwd', 'message' => Yii::app()->getController()->lang->gT('Passwords do not match!'), 'strict' => true, 'on' => 'optional'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'dbtype' => 'Database type',
			'dblocation' => 'Database location',
			'dbname' => 'Database name',
			'dbuser' => 'Database user',
			'dbpwd' => 'Database password',
			'dbprefix' => 'Table prefix',
		);
	}
}
?>
