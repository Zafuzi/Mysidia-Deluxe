<?php

use Resource\Collection\ArrayList;

/**
 * The RewardTableHelper Class, extends from the TableHelper class.
 * It is a specific helper for tables that involves operations on rewards.
 * @category Resource
 * @package Helper
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class RewardTableHelper extends TableHelper{
		
	/**
     * Magic method __toString for AdoptTableHelper class, it reveals that the object is a reward table helper.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia RewardTableHelper class.");
	}    
} 
?>