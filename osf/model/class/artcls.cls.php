<?php
class artcls
{
	/* CONSTRUCTOR */
	function __construct()
	{
	    global $DB,$APP,$USER;
		$this->DB   = $DB;
		$this->APP  = $APP;
		$this->USER = $USER;
		$this->table='app_article';
		$this->user='app_od_user';
		return true;
	}

	public function columns(){
	// $q = $this->DB->prepare("DESCRIBE ".$this->table);
	// $q->execute();
	$sql="DESCRIBE ".$this->table;
	$result=$this->DB->query($sql);
	return $table_columns = $result->fetchAll(PDO::FETCH_COLUMN);
}

	function insertarticle()
	{
		$sql="INSERT INTO app_article ";
		$sql .="(";

		foreach ($this->columns() as $key => $value) {
				$sql .= $value.',';
		}

		$sql = trim($sql, ',');

		$sql .= ") ";
		$sql .="VALUES (";

		// echo '<pre>';
		// print_r($this->columns());
		// exit();

		foreach ($this->columns() as $key => $value) {
				if ($value == 'image') {

					$file_name = '';
					if ($_FILES['image']['error'] == '0') {
						$target_dir = "../../pub/uploads/";
						$target_file = $target_dir . basename($_FILES["image"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

						$check = getimagesize($_FILES["image"]["tmp_name"]);
						if($check !== false) {
								$uploadOk = 1;
						} else {
								echo "File is not an image.";
								$uploadOk = 0;
						}

						$file_name = md5(time().'_'.mt_rand("00000","99999")).".".$imageFileType;
						$target_file = $target_dir.$file_name;

						// Check file size
						if ($_FILES["image"]["size"] > 10000000) {
								echo "Sorry, your file is too large.";
								$uploadOk = 0;
						}
						// Allow certain file formats
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
						&& $imageFileType != "gif" ) {
								echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
								$uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
								echo "Sorry, your file was not uploaded.";
						// if everything is ok, try to upload file
						} else {
								if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
										//echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
								} else {
										echo "Sorry, there was an error uploading your file.";
								}
						}
					}



					$sql .="'".$file_name."',";
				}

				 else if($value == 'name') {
					$sql .= "'".base64_encode($_POST[$value])."',";
				} else if($value == 'article') {
					$sql .= "'".base64_encode($_POST[$value])."',";
				} else {
					if ($value != 'createdat' && $value != 'userid') {
						$sql .= "'".$_POST[$value]."',";
					}
				}
				if ($value == 'createdat') {
					$sql .="'".time()."',";
				}
				if($value=='userid')
				{
					$sql .= "'".$this->USER->ID."'";
				}
		}


			$sql=trim($sql, ',');
			$sql .=")";

				// echo '<pre>';
				// print_r($sql);
				// echo "<hr  />";
				// print_r($_POST);

			// exit();

			try{
				$this->DB->exec($sql);
				$result=array('status'=>true, 'message' => '<h2><i class="far fa-check-circle"></i>Article Uploaded Successfully</h2>');
			}
			catch(PDOException $e)
			{
				$result=array(
					'status'=>false,
					'message' => 'Error',
					'detailed_message' => '<i class="fa fa-times"></i> '.$e->getMessage()
				);
				// echo '<pre>';
				// print_r($e->getMessage());
				// echo '</pre>';
			}

			return $result;
	}

	function newuser()
	{
		$sql="INSERT INTO app_od_user (idprovider,idverifier,username,password,email,ph_number,firstname,lastname,userstatus,roleid,lastlogin) ";
		$username=$_POST['uname'];
		$password=md5($_POST['password']);
		$email=$_POST['email'];
		$firstname=$_POST['fname'];
		$lastname=$_POST['lname'];
		$number=$_POST['number'];
		$roleid=5;
		$lastlogin=date("Y-m-d H:i:s", time());
		$idverifier=uniqid();
		$sql .="VALUES ('Native', '".$idverifier."','".$username."','".$password."','".$email."','".$number."','".$firstname."','".$lastname."','1','".$roleid."','".$lastlogin."')";

		try{
			$this->DB->exec($sql);
			// $targetUrl = $this->APP->BASEURL.'/login';
			// header("Location: ".$targetUrl, true, 301);
			// exit();
			$result=array('status'=>true, 'message' => '<h2><i class="far fa-check-circle"></i>Registered Successfully!</h2>');
		}
		catch(PDOException $e)
		{
			$result=array(
				'status'=>false,
				'message' => 'Error',
				'detailed_message' => '<i class="fa fa-times"></i> '.$e->getMessage()
			);
			// echo '<pre>';
			// print_r($e->getMessage());
			// echo '</pre>';
		}

		return $result;
	}


	function setpreference($id)
	{	$sql="";

		$pre=$_POST['preference'];
		$pre=implode(",",$pre);
		$sql2="SELECT * FROM app_profile WHERE userid='".$_SESSION['USERID']."' "; //for Preferences
		$result = $this->DB->query($sql2);
  	//$user=$result['username'];
		$rowCount = $result->rowCount();
		if($rowCount==1)
		{
			$sql="UPDATE app_profile SET preference='".$pre."' WHERE userid='".$id."' ";

		}
		else if($rowCount==0)
		{
		$sql="INSERT INTO app_profile (userid,preference) ";
		//$ob= new viewarticle();
		// $result=$ob->fetchuser($id);

		// $result2=$ob->fetch_category($pre);
		// $preference=$result2['category'];


		$sql .="VALUES ('".$id."','".$pre."')";
	}
		try{
			$this->DB->exec($sql);
			$result3=array('status'=>true, 'message' => '<h2><i class="far fa-check-circle"></i>Preference Set!</h2>');
		}
		catch(PDOException $e)
		{
			$result3=array(
				'status'=>false,
				'message' => 'Error',
				'detailed_message' => '<i class="fa fa-times"></i> '.$e->getMessage()
			);
			// echo '<pre>';
			// print_r($e->getMessage());
			// echo '</pre>';
		}
		return $result3;
	}


	function role($id)
	{
		$sql="SELECT * FROM app_od_user WHERE userid='".$id."' ";
		$query=$this->DB->query($sql);
		$row=$query->fetch(PDO::FETCH_ASSOC);
		$value=$row['roleid'];
		return $value;
	}

	function bookmark()
	{
		$article = $_POST["articleid"];
		$user = $_SESSION['USERID'];

		$sql="";
		$sql="SELECT * FROM app_profile WHERE userid='".$user."' ";
		$check=$this->DB->query($sql);

		if($check->rowCount() == 0) {
			$sql="INSERT into app_profile (id, userid, bookmarks, preference) values(null, '".$user."', '', '')";
			$this->DB->exec($sql);
		}

		$sql="SELECT * FROM app_profile WHERE userid='".$user."' ";
		$check=$this->DB->query($sql);

		$row=$check->fetch(PDO::FETCH_ASSOC);
		$book= $row['bookmarks'];
		$value=explode(",", $book);
		$sql = '';

		if (in_array($article, $value)) {
			$res=array('status'=>1, 'detailed_message' => 'Already Bookmark Added!!');//$sql="UPDATE app_bookmark SET articleid='".$pre."' WHERE userid='".$id."' ";
			return $res;
		}
		// if (record exists) {
		// 	/insert
		// } else {
		// 	collect the data
		// 	previous article id = $result['articleid'];
		// 	$new__artie_sjd = $previous article id.','.$article;
		// }

		$value= $book.",".$article;
		$value=trim($value,",");
		$sql2="UPDATE app_profile SET bookmarks = '".$value."' WHERE userid='".$user."'";

		try {
			$this->DB->exec($sql2);
			$res=array('status'=>1, 'detailed_message' => 'Bookmark Added!!');

		} catch (PDOException $e) {
			$res=array(
				'status'=>0,
				'message' => 'Error',
				'detailed_message' => '<i class="fa fa-times"></i> '.$e->getMessage()
			);
		}
		return $res;
	}

	function unmark()
	{
		$article=$_POST['articleindex'];
		$user=$_SESSION['USERID'];

		$sql2="SELECT * FROM app_profile WHERE userid='".$user."' ";
		$query=$this->DB->query($sql2);
		$row=$query->fetch(PDO::FETCH_ASSOC);

		$res=explode(',',$row['bookmarks']);
		unset($res[$article]);
		$res = implode(",",$res);
		$sql="UPDATE app_profile set bookmarks='".$res."' WHERE userid='".$user."' ";
		try {
			$this->DB->exec($sql);
			$res=array('status'=>1, 'detailed_message' => 'Bookmark Removed!!');

		} catch (PDOException $e) {
			$res=array(
				'status'=>0,
				'message' => 'Error',
				'detailed_message' => '<i class="fa fa-times"></i> '.$e->getMessage()
			);
		}

		return $res;
	}

} //End Of Class Statement
?>
