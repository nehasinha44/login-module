<?php
 ob_start();
 session_start();
class Model {

	private  $conn;
    public function db_connection()
    {
 	 $this->conn = new mysqli("<ip-address>", "<dbName>", "<password>", "<TableName");
		
		if ($this->conn->connect_error) {
		    die("Connection failed: " .$this->conn->connect_error);
		}
 }

 public function index()
 {
 	$name      =  trim($_REQUEST['username']) ;
    $password  =   $_REQUEST['pass'];
    $error = true;

	  if ($name != "") {
	  		$this->db_connection();
	  	    $sql    	=   "SELECT username, password from login where username= '".$name."'";
		 	$result 	= 	$this->conn->query($sql);
		         if ($result->num_rows > 0) {
		            while($row = $result->fetch_assoc()) {// output data of each row
		              if (MD5($password)	== $row['password'] ) {
		                $_SESSION['name'] 	= $name; 
		                $value 				= $this->get_client_ip();
		                $get_browser_name 	= $this->get_browser_name($_SERVER['HTTP_USER_AGENT']);
		                $os 				= $this->getOS();
		                $sessioninformation = serialize($value."+".$get_browser_name."+".$os);
		                $sessionid 			= str_replace("","",$value.$get_browser_name);
		                //inser browser data
		                $sql    			=   "SELECT sessioninformation from sessioninformation where sessioninformation= '".$sessioninformation."'";
		                	$result 		= $this->conn->query($sql);
		                			if ($result->num_rows > 0) {
		                				while($row = $result->fetch_assoc()) {
		                			}
		                				header('Location: http://localhost/test/index.php');
		                			}
		                			else
		                			{
		                			$sql = "INSERT INTO sessioninformation (username, sessioninformation,sessionid)
										VALUES ('".$name."', '".$sessioninformation."','".$sessionid."');";
										 
										if ($this->conn->query($sql) === TRUE) {
											$_SESSION['sessionid'] = $sessionid;
										    header('Location: http://localhost/test/index.php');
										} 
		                			}
		              }
		              else
		              {
		              	return $nameError = "password mismatch ";
		              }
		            }
		        } else {
		          return $nameError = "wrong username";
          }
	  }
 }

 public function sessioninformation()
 {
 		$this->db_connection();
		if ($_SESSION['name']!="") {
			$sql = "SELECT * FROM sessioninformation where username='".$_SESSION['name']."'";

			if ($result = $this->conn->query($sql)) {

			    /* fetch object array */
			    while ($row = mysqli_fetch_all($result,MYSQLI_ASSOC)) {
			    	foreach ($row as $key => $value) {
			    	$finvalue[] =	$value['sessioninformation'];
			    	}
			    	return $finvalue;
			    }
			    /* free result set */
			    $result->close();
			}
		}
		else
			header('Location: localhost/test/index.php');
		  
 }

 public function logout($sessionid)
 {
 	$this->db_connection();
 	  $sql = "DELETE FROM sessioninformation WHERE sessionid='".$_REQUEST['sessionid']."'";

		if ($this->conn->query($sql) === TRUE) {
		    echo "Record deleted successfully";
		} else {
		    echo "Error deleting record: " . $this->conn->error;
		}
		header("location: index.php"); 
 	  

 }
  public function logoutall()
 {
 	$this->db_connection();
 	  $sql = "DELETE FROM sessioninformation";
 	
		if ($this->conn->query($sql) === TRUE) {
		    echo "Record deleted successfully";
		} else {
		    echo "Error deleting record: " . $this->conn->error;
		}
		unset($_SESSION['sessionid']);
		header("location: index.php"); 
 	  

 }
 public function checksessionid($sessionid)
 {
 	$this->db_connection();
 	 $sql = "SELECT sessionid FROM sessioninformation where sessionid='".$sessionid."'";
	if ($result = $this->conn->query($sql)) {
			    if ($result->num_rows > 0) {
		               while($row = $result->fetch_assoc()) {
		               return $row['sessionid'] ;
		                }
		                				
		           }
			}
		 else {
		    return false;
		}

 }
 public function get_client_ip() 
 {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
/*
method ot get brower name
*/
function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    
    return 'Other';
}
 /*
 method to get Operating system information
 */
 function getOS() { 

   $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}
}

?>