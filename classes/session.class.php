<?php
session_start();

class session {
    private $role;
    /*
     * initialize class and set the role
     */
    function __construct($mysqli) {
        
        if(isset($_SESSION['userid'])){
	        $this->role = 1;
        }
    }
    
    /*
     * get role of the user
     */
    function getRole(){
        return $this->role;
    }
}
?>
