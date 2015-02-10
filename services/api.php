<?php 

require_once("Rest.inc.php");

class API extends REST {
	
		public $data = "";
		
		const DB_SERVER = "localhost";
		const DB_USER = "xxxxxxxxxxx"; //Database Username
		const DB_PASSWORD = 'xxxxxxxxxxx'; //Database Password
		const DB = "xxxxxxxxxxx"; //Database name
		
		private $db = NULL;

		public function __construct()
		{
			parent::__construct();// Initiate parent contructor
			$this->dbConnect();// Initiate Database connection
		}

		/*
		*	Database connection
		*/
		private function dbConnect()
		{
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db){
			mysql_select_db(self::DB,$this->db);
			}	
		}
		
		/*
		 * Dynmically call the method based on the query string
		 */
		public function processApi(){
			$func = strtolower(trim($_GET['x']));
			if((int)method_exists($this,$func) > 0)
				return $this->$func();
			else
				$this->response('',404); // If the method not exist with in this class "Page not found".
		}
				
		/*
		 * Insert the customer name , password into database.
		 */
		private function insertCustomer(){
				if($this->get_request_method() != "POST"){
					$this->response('',406);
				}
				$customer = file_get_contents("php://input");
				$tempvalues = explode('&',$customer);
				foreach($tempvalues as $value) {
				   $value = explode('=',$value);
				   $values[$value[0]] = $value[1];
				}
				$name = $values['name'];
				$hashkey = $values['hashkey'];
				if((int)strlen($name) < 3 && (int)strlen($haskey) < 3)
					$this->response('',204);	//"No Content" status
				else
				$query = "insert into wallet (name,hashkey) values ('".$name."','".$hashkey."')";
				if(mysql_query($query)){
					$success = array('status' => "Success", "msg" => "Customer Created Successfully.");
					$this->response($this->json($success),200);
				}else{
					$this->response('no',204);	//"No Content" status
				}
		}

		/*
		 * Delete the customer by id.
		 */
		private function deletecustomer(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = $_GET['id'];
			if($id){				
				$query="DELETE FROM wallet WHERE id = '".$id."' ";
				$r = mysql_query($query) or die(mysql_error());
				$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	// If no records "No Content" status
		}

		/*
		 * Get All Customers.
		 */
		private function customer(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			
				$query="SELECT name,hashkey FROM wallet";
				$r = mysql_query($query) or die(mysql_error());
				if(mysql_num_rows($r) > 0) {
					while($result = mysql_fetch_assoc($r)){	

							$results[] = $result;
					
					}
					$this->response($this->json($results), 200); // send user details
				}

			$this->response('',204);	// If no records "No Content" status
		}

		
		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
		
		
	}
	
	
?>