<?php
include "simple_html_dom.php";
class viewarticle extends category
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

	function updatetable() {
		$sql = "SELECT * FROM app_agencies";
		$result = $this->DB->query($sql);
		$data = json_decode(json_encode($result->fetchAll(PDO::FETCH_ASSOC)));

		foreach ($data as $key => $value) {
			$title = base64_decode(unserialize($value->title));
			$sql = "UPDATE app_agencies SET title = '".$title."' WHERE id = '".$value->id."'";
			$this->DB->exec($sql);
		}
	}

	function view($field_name = null, $field_value = null)
	{
		$sql="";
		$arr=$this->fetchuser($_SESSION['USERID']);
		if ($field_name == 'category') {
				$categoryData = $this->fetch_category_by_name($field_value);
				$sql="SELECT * FROM app_article WHERE category='".$categoryData['id']."' AND status='3'";
		}

		else {	//this section is used to return the total number of articles viewable for user
			if($arr['roleid']==4)	//only editor and admin can access this section
			{$sql="SELECT * FROM app_article WHERE status>='1' ";}
			else if($arr['roleid']==1)
			{
				$sql="SELECT * FROM app_article WHERE status>='0' "; //Admin can see everything
			}
			else{
				$sql="SELECT * FROM app_article WHERE userid='".$_SESSION['USERID']."' ";} //fetch articles of the writer
		}

		$sql .= ' ORDER BY id DESC';

		$result = $this->DB->query($sql);
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		return $row;
  }


	function view2($limit, $offset) //called by main page to show 4 articles max and rest be loaded by Loader. Most Important function
	{
		$sql2="SELECT * FROM app_profile WHERE userid='".$_SESSION['USERID']."' "; //for Preferences
		$result = $this->DB->query($sql2);
		// $rowCount = $result->rowCount();
		$preference = $result->fetch(PDO::FETCH_ASSOC);
		$user_preference = explode(",", $preference['preference']);

		if (!empty($preference['preference'])) {
			$sql="SELECT * FROM app_article WHERE ";

			foreach ($user_preference as $key => $value) {
					$sql .= " category='".$value."' OR"; //multiple preferences and hence every article is to be showm
			}

			$sql = trim($sql, " OR");

			$sql .= " AND status='3' ORDER BY id DESC LIMIT ".$offset.", ".$limit;
		} else {
			$sql="SELECT * FROM app_article WHERE status = '3' ORDER BY id DESC LIMIT ".$offset.", ".$limit;  //only those articles to be shown that are published by editor. For now I am showing everything
		}

		$result = $this->DB->query($sql);
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		return $row;
  }

	function view3($offset, $limit)  //for the panel view
	{
		$sql="";
		$arr=$this->fetchuser($_SESSION['USERID']);

			if($arr['roleid']==4)	//only editor and admin can access this section
			{$sql="SELECT * FROM app_article WHERE status>='1' ORDER BY id DESC LIMIT ".$offset.", ".$limit;} //editor can only see submitted articles are edit them
			else if($arr['roleid']==1)
			{
			 $sql="SELECT * FROM app_article WHERE status>='0' ORDER BY id DESC LIMIT ".$offset.", ".$limit; //Admin can see everything
			}
			else{
				$sql="SELECT * FROM app_article WHERE userid='".$_SESSION['USERID']."' ORDER BY id DESC LIMIT ".$offset.", ".$limit;} //fetch articles of the writer

		$result = $this->DB->query($sql);
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}


	function delete()
	{
		if(isset($_GET["articleid"])){

		    $sql = "DELETE FROM app_article WHERE id = :id ";

		    if($stmt = $this->DB->prepare($sql)){
		        // Bind variables to the prepared statement as parameters
		        $stmt->bindParam(":id", $param_id);

		        // Set parameters
		        $param_id = trim($_GET["articleid"]);

		        // Attempt to execute the prepared statement
		        if($stmt->execute()){
		            // Records deleted successfully. Redirect to landing page);
								return true;
		        } else{
		            echo "Oops! Something went wrong. Please try again later.";
		        }
		    }

		}
		 else{
		    // Check existence of id parameter
		    if(isset($_GET["articelid"])==false){
		        // URL doesn't contain id parameter. Redirect to error page
		        return false;
		    }
		}
	}

	function article_read()
	{
		if(isset($_GET["articleid"])){
		    // Prepare a select statement
		    $sql = "SELECT * FROM app_article WHERE id = :id";

		    if($stmt = $this->DB->prepare($sql)){
		        // Bind variables to the prepared statement as parameters
		        $stmt->bindParam(":id", $param_id);

		        // Set parameters
		        $param_id = trim($_GET["articleid"]);

		        // Attempt to execute the prepared statement
		        if($stmt->execute()){
		            if($stmt->rowCount() == 1){
		                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
		                $row = $stmt->fetch(PDO::FETCH_ASSOC);
										return $row;
									}
									else {
										echo "Clone Article";
										exit();
									}

							}
							else {
								echo "Oops! Something went wrong. Please try again later.";
							}
						}
					}
					else{
					    // URL doesn't contain id parameter. Redirect to error page
					    echo "error2";
					    exit();
				}
			}

	function update()
	{
			$id = $_POST["id"];
	    // Validate name
	    $input_name = trim($_POST["name"]);


			$name_err = '';
			$article_err = '';
	    /*if(empty($input_name)){
	        $name_err = "Please enter a name.";
	    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
	        $name_err = "Please enter a valid name.";
	    } else{
	        $name = $input_name;
	    }*/

	    // Validate article article
	    $input_article = trim($_POST["article"]);
	    if(empty($input_article)){
	        $article_err = "Please enter an article.";
	    } else{
	        $article = $input_article;
	    }

			$category=$_POST["category"];
			$status=$_POST["status"];

			try{
						$sql = "UPDATE app_article SET name=:name, article=:article, category=:category, status=:status ";

						if ($_FILES['image']['error'] == '0') {
								$sql .= ' , image=:image';
						}

						$sql .= ' WHERE id=:id';
						$file_name = '';
						if ($_FILES['image']['error'] == '0') {
							$file_name = $this->imgupload();
						}


						$stmt = $this->DB->prepare($sql);

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":article", $param_article);
            $stmt->bindParam(":id", $param_id);
						$stmt->bindParam(":category", $param_category);
						$stmt->bindParam(":status", $param_status);
						if (!empty($file_name)) {
								$stmt->bindParam(":image", $imageName);
						}

            // Set parameters
            $param_name = base64_encode($_POST["name"]);
            $param_article = base64_encode($article);
            $param_id = $id;
						$param_category=$category;
						$param_status=$status;


						if (!empty($file_name)) {
							$imageName = $file_name;
						} else {
							$imageName = '';
						}

            $stmt->execute();
						return true;
			} catch(PDOException $e){
			    die("ERROR: Could not prepare/execute query: $sql. " . $e->getMessage());
			}
	}

	function imgupload()
	{
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
						return $file_name;
				} else {
						return '';
				}
		}
	}

	function fetchuser($id)
	{
		$sql="SELECT * FROM app_od_user WHERE userid='".$id."' ";
		$result=$this->DB->query($sql);
		$row=$result->fetch(PDO::FETCH_ASSOC);
		return $row;

	}

	function fetchBookmark($id)
	{
		$sql="SELECT * FROM app_profile WHERE userid='".$id."' ";
		$result=$this->DB->query($sql);
		// if($result->rowCount===0)
		// {
		// 	return false;
		// }
		// else{
		// $row=$result->fetchAll(PDO:: FETCH_ASSOC);

		$row=$result->fetch(PDO::FETCH_ASSOC);
		$string=$row['bookmarks'];
		$answer=explode(",",$string);
		return $answer;
	}

	function countart($more,$less) //counts number of articles per month for the graph in admin panel
	{
		// echo $more;
		// echo ' - '.$less;
		// exit();
		$more=strtotime($more);
		$less=strtotime($less);
		$sql="SELECT * FROM app_article WHERE createdat>='".$less."' AND createdat<'".$more."' ";
		$res=$this->DB->query($sql);
		$row=$res->fetchAll(PDO::FETCH_ASSOC);
		return $res->rowCount();
	}


	function comment()
	{
		$uid=$_SESSION['USERID'];
		$comment=$_POST['comment'];
		$timestamp=time();
		$sql="INSERT INTO app_comment  (article, userid, comment, cur_time) VALUES ('".$_POST['articl']."', '".$uid."', '".$comment."','".$timestamp."')";
		$sql1="SELECT * FROM app_comment WHERE article='".$_POST['articl']."' ";

		try{
			$this->DB->exec($sql);

			$result=$this->DB->query($sql1);
			$row=$result->fetchAll(PDO::FETCH_ASSOC);
			$content = '<div class="row w-100 mx-0">';
			foreach ($row as $key => $value) {
					$userData = $this->fetchuser($value['userid']);
					$content.= '
						<div class="mt-1 col-12">
							<div class="float-left">
								'.$value['comment'].'<br />
								<div class="text-muted">
									'.$userData['firstname'].' '.$userData['lastname'].'
								</div>
							</div>
						</div>
					';
			}
			$content .= '</div>';
			$result=array('status'=>1, 'message' =>'Comment added!', 'comments' => $content);
		}
		catch(PDOException $e)
		{
			$result=array(
				'status'=>0,
				'message' => 'Error',
				'detailed_message' => ''.$e->getMessage()
			);
			// echo '<pre>';
			// print_r($e->getMessage());
			// echo '</pre>';
		}
		return $result;
	}

	function scrapeimg($name, $id)
	{
		$sql="INSERT INTO app_preview (name, photoid) VALUES ('".$name."', '".$id."') ";

		try {
			$this->DB->exec($sql);
			$result=array('status'=>1, 'message' => 'true');

		} catch (PDOException $e) {
			$result=array(
				'status'=>0,
				'message' => 'Error',
				'detailed_message' => ''.$e->getMessage()
			);
		}

		return $result;

	}

	function viewscrapeimg($name)
	{
		$sql="SELECT * FROM app_preview WHERE name LIKE '".$name."' ";
		$res=$this->DB->query($sql);
		$row=$res->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	function countries()
	{
		$sql="SELECT * FROM app_countries ";
		$res=$this->DB->query($sql);
		$row=$res->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	function states($id)
	{
		$sql="SELECT * FROM app_states WHERE country_id ='".$id."' ";
		$res=$this->DB->query($sql);
		$row=$res->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
	function cities($id)
	{
		$sql="SELECT * FROM app_cities WHERE state_id ='".$id."' ";
		$res=$this->DB->query($sql);
		$row=$res->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	function testscrape($path)
	{

		if(file_get_contents($path))
		{
			$c=1;
		}
		else {
			$c=0;
		}
		return $c;
	}
	function cities_main()
	{
		$sql="SELECT * FROM indexed_cities " ;
		$res=$this->DB->query($sql);
		$row=$res->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function countUrl($path) {
		$stmt = $this->DB->prepare("SELECT * FROM indexed_cities WHERE url=:url");
		$stmt->bindParam(':url', $path);
		$stmt->execute();
		return $q = $stmt->rowCount();
	}


} //End Of Class Statement
?>
