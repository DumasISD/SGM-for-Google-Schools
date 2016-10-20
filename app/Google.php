<?php
namespace App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Session;

class Google{

    protected $client;

    protected $service;
    protected $admin_user;
    protected $google_domain;

    function __construct($key_file=null){
        $this->client_id =Config::get('google.client_id');
		$this->service_account_name = Config::get('google.service_account_name');
		if (!$key_file )
			$this->key_file = Config::get('google.key_file_location');
		else
			$this->key_file = $key_file;
		$this->client = new \Google_Client();
		$this->service = new \Google_Service_Directory($this->client);
        $this->client->setApplicationName("Dumas");
        $this->google_domain = env('google_domain_name');
        $this->admin_user = env('google_admin_user');
    }

	public function getServiceToken(){
		$service_token=Session::get('google.service_token');
		if (isset($service_token)) {
		  $this->client->setAccessToken($service_token);
		}
		$key = file_get_contents($this->key_file);
		$credentials = new \Google_Auth_AssertionCredentials(
			$this->service_account_name,
			  array('https://www.googleapis.com/auth/admin.directory.group', 'https://www.googleapis.com/auth/admin.directory.user'),
			$key
		);
		$credentials->sub = $this->admin_user;
		$this->client->setAssertionCredentials($credentials);

		if ($this->client->getAuth()->isAccessTokenExpired()) {

		  $this->client->getAuth()->refreshTokenWithAssertion($credentials);

		}
		Session::put('google.service_token',  $this->client->getAccessToken());
    }
    public function addGroup($email,$name,$description) {
    	$service_token=$this->getServiceToken();
		$service = $this->service;

    	$group = new \Google_Service_Directory_Group($this->client);
		$group->setEmail($email);
		$group->setName($name);
		$group->setDescription($description);

		$results = $this->service->groups->insert($group);
		return $results;
    }

    public function addUserToGroup($email,$group_id) {
    	$service_token=$this->getServiceToken();
		$service = $this->service;

    	$member = new \Google_Service_Directory_Member($this->client);
		$member->setEmail($email);
		$member->setRole("MEMBER");

		$results = $this->service->members->insert($group_id,$member);
		return $results;
    }
public function deleteUserFromGroup($user_id,$group_id) {
    	$service_token=$this->getServiceToken();
		$service = $this->service;
		
		$results = $this->service->members->delete($group_id,$user_id);
		return $results;
    }
    public function getGroupMember($group_id, $user_id) {
    	$service_token=$this->getServiceToken();
		$service = $this->service;

		$ok=0;
   		try {   
			$results = $this->service->members->get($group_id,$user_id);
			$ok=1;
			
		} catch (\Exception $e) {
			
			$results = null;
		} 
		return $results;
	
    }

    public function getGoogleUsers($next=null){
		$service_token=$this->getServiceToken();
		
		$params = array(
		  'domain' => $this->google_domain, 
		  'maxResults' => 500,
		  'orderBy' => 'email',
		);
		if ($next) $params["pageToken"] = $next;
		$results = $this->service->users->listUsers($params);

		return $results;
    }



	 public function getGoogleGroups(){
		$service_token=$this->getServiceToken();
		
		$optParams = array(
		  'domain' => $this->google_domain,
		  'maxResults' => 500,
		);
		$results = $this->service->groups->listGroups($optParams);
		return $results;
    }
}
