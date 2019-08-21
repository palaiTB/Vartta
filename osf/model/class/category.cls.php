<?php
class category
{
	/* CONSTRUCTOR */
	function __construct()
	{
	    global $DB,$APP,$USER;
		$this->DB   = $DB;
		$this->APP  = $APP;
		$this->USER = $USER;
		return true;
	}

	function view()
	{
		$sql="SELECT * FROM app_category";
		$result=$this->DB->query($sql);
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	function fetch_category($id) {
		$sql="SELECT * FROM app_category WHERE id='".$id."'";
		$result=$this->DB->query($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	function fetch_category_by_name($name) {
		$sql="SELECT * FROM app_category WHERE category LIKE '%".$name."%'";
		$result=$this->DB->query($sql);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
} //End Of Class Statement
?>
