<?php

/**
 * Class db for Ajax Auto Refresh - Volume II - demo
 * @author Eliza Witkowska <kokers@codebusters.pl>
 * @link http://blog.codebusters.pl/en/entry/ajax-auto-refresh-volume-ii
 *
 * Modified for AWS IoT Button to PHP demo
 * https://github.com/zdrive/aws-iot-button-php 
 * 
 */

require_once ('_settings.php');

class db{

	/**
	 * db
	 *
	 * @var $	public $db;
	 */
	public $db;

 	
	/**
	 * __construct
	 *
	 * @return void
	 */
	function __construct(){
		global $dbHost,$dbUsername,$dbPassword,$dbName,$dbPort,$dbSocket;
		$this->db_connect($dbHost,$dbUsername,$dbPassword,$dbName,$dbPort,$dbSocket);
		// $this->db_connect($dbHost,$dbUsername,$dbPassword,$dbName);
	}


	/**
	 * db_connect
	 *
	 * Connect with database
	 *
	 * @param mixed $host
	 * @param mixed $user
	 * @param mixed $pass
	 * @param mixed $database
	 * @return void
	 */
	function db_connect($host,$user,$pass,$database,$port=null,$socket=null){
		$this->db = new mysqli($host, $user, $pass, $database,$port,$socket);

		if($this->db->connect_errno > 0){
			die('Unable to connect to database [' . $this->db->connect_error . ']');
		}
	}


	/**
	 * check_changes
	 *
	 * Get counter value from database
	 *
	 * @used-by checker.php
	 *
	 * @return void
	 */
	function check_changes(){
 		global $AWSbuttonSN;
		$result = $this->db->query("SELECT `IS_ButtonTrackerID` FROM `t_iotsettings` WHERE `IS_AWSbuttonSN`='" . $AWSbuttonSN . "'");

		if($result = $result->fetch_object()){
			return $result->IS_ButtonTrackerID;
		}
		return 0;
	}


	/**
	 * get_clicks
	 *
	 * Gets the most recent click that occurred today
	 *
	 * @return void
	 *
	 * @used-by index.php
	 * @used-by checker.php
	 *
	 */
	function get_clicks(){
 		global $AWSbuttonSN;
		$strIoTbuttonStatusHTML = "The AWS IoT Button has not been clicked today.";

		if($result = $this->db->query("SELECT `IO_clickType`, `IO_batteryVoltage`, `IO_StartTime` FROM `t_iotbuttontracker` WHERE `IO_serialNumber`='" . $AWSbuttonSN . "' AND DATE(IO_StartTime) = DATE(NOW()) ORDER BY `IO_StartTime` DESC LIMIT 1")){

			while($r = $result->fetch_object()){

				$dt = new DateTime($r->IO_StartTime);
				$ABdate = $dt->format('n/j/Y');
				$ABtime = $dt->format('g:i:s A');

				$strIoTbuttonStatusHTML= "<b style='color:blue'>Button Click:</b> " . $r->IO_clickType . "<br/><b style='color:blue'>Date:</b> " . htmlspecialchars($ABdate) . "<br/><b style='color:blue'>Time:</b> " . htmlspecialchars($ABtime);
			
			} // END while($r = $result->fetch_object())

		} // END if($result = $this->db->query... 
		
		return $strIoTbuttonStatusHTML;
	} // END function get_clicks()



	/**
	 * button_tracker
	 *
	 * Inserts record with data that came from Amazon AWS Lambda
	 *
	 * @used-by iot_button_click.php
	 *
	 * @return void
	 */
	function button_tracker($clickType, $serialNumber, $batteryVoltage){

	$MyInsertSQL = "INSERT INTO t_iotbuttontracker";
		$MyFieldSQL = " (`IO_clickType`, `IO_serialNumber`, `IO_batteryVoltage`, `IO_StartTime`)";
		$MyValuesSQL = " VALUES ('" . $clickType . "', '" . $serialNumber . "', '" . $batteryVoltage . "', '" . date("Y-m-d H:i:s") . "')";
		$MyStatementSQL = $MyInsertSQL.$MyFieldSQL.$MyValuesSQL;

		$this->db->query($MyStatementSQL);

		$intNewInsertID = mysqli_insert_id($this->db);

		if($intNewInsertID > 0){
			$this->db->query("UPDATE `t_iotsettings` SET `IS_ButtonTrackerID` = " . $intNewInsertID . " WHERE `IS_AWSbuttonSN` = '" . $serialNumber . "'");
		}
	} // END function button_tracker

}
/* End of file db.php */