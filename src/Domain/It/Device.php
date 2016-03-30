<?php

namespace Milhojas\Domain\It;

/**
 * Represents a Device able to report about its working status. 
 * The device can be asked if is up, is listening in a port, nneds service or needs supplies
 * 
 * If there is a problem, details can be obtained via getReport()
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */

interface Device {
	/**
	 * Device responds to pings
	 *
	 * @return boolean true if responds
	 */
	public function isUp();
	/**
	 * Device is listening in a port if defined
	 *
	 * @return boolean true if is listening
	 */
	public function isListening();
	/**
	 * Device needs some kind of service (it is not working because a fail)
	 *
	 * @return boolean true if it needs some service
	 */
	public function needsService();
	/**
	 * Device needs supplies (it is not woring because some supplies are exhausted or near of been exhausted)
	 *
	 * @return boolean true if it needs supplies
	 */
	public function needsSupplies();
	/**
	 * Returns a text report of the detected problem
	 *
	 * @return string
	 */
	public function getReport();
	/**
	 * Returns device identity
	 *
	 * @return DeviceIdentity object
	 */
	public function getIdentity();
}

?>