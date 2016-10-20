<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Exception;
use Log;
use Mail;
use DateTime;
use DateTimeZone;
use DB;
use App\User;
use App\Google;
use App\SmartGroup;

use Carbon\Carbon;

class Smart extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'smart';

    protected $signature = 'smart {env_name : dev or production} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'loop thru users and add to groups.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $env_name = $this->argument('env_name');
        if ($env_name != "dev" && $env_name != "production") 
            throw new Exception("Error - env_name is invalid");

	$keyfile = env("google_key_file2");
        $google = new Google($keyfile);


            $results=$google->getGoogleGroups();
            $groups = $results->getGroups();
    #    print_r($groups);

        $sg_list = SmartGroup::get();
    #    print_r($sg_list);
        
    
        $next = null;
        $page=1;
        $i=1;
        while ($next || $page==1) {
            $results=$google->getGoogleUsers($next);
            $users = $results->getUsers();
            #print_r($users);
            
            echo count($users);
    
            foreach($users as $user){
                $email = $user['primaryEmail'];
	        Log::info('smart email', ['context' => $email]);
			
		if ($email != "christyvol@dumasschools.net" && $email != "joeparttime@dumasschools.net" && $email != "joeteacher@dumasschools.net") continue; 

                echo $i . " " . $user['name']['givenName'] . " " . $user["primaryEmail"] . " " . $user['orgUnitPath'] . "\n";
                $orgUnitPath = $user['orgUnitPath'];
                $organizations = array();
                if (isset($user['organizations']))
                	$organizations = $user['organizations'];
                $relations = array();
                if (isset($user['relations']))
	                $relations = $user['relations'];

                reset($sg_list);
                foreach ($sg_list as $sg) {
                    echo "  " . $sg->name . " " . $user['id'] . "\n";
                    $group_id = $sg->google_group_id;
                    #$group_id = "03x8tuzt2gq5esc";
                    $match=0;
                    $pattern = str_replace("*",".*", $sg->regexp);
                    switch ($sg->type) {
                        case 1:  # email prefix
                            if (preg_match("/".$pattern."/", $email)) {
                                echo "  match \n";
                                $match=1;
                                $member = $google->getGroupMember($sg->google_group_id, $user['id']);
                                if (!$member) {
                                    echo "  not yet a member, so add \n";
                                    $google->addUserToGroup($user['primaryEmail'],$sg->google_group_id);
                                } else {
                                    echo "  already a member \n";
                                }

                            } else {
                                echo "  no match for $email with the pattern: $pattern \n";
                            }
                            break;
                        case 2:  # Organization Unit 
                            if (preg_match("/".$pattern."/", $orgUnitPath)) {
                                echo "  match \n";
                                 $match=1;
                                $member = $google->getGroupMember($sg->google_group_id, $user['id']);
                                if (!$member) {
                                    echo "  not yet a member, so add \n";
                                    $google->addUserToGroup($user['primaryEmail'],$sg->google_group_id);
                                } else {
                                    echo "  already a member \n";
                                }

                            } else {
                                echo "  no match for $email with the pattern: $pattern \n";
                            }
                            break;
                        case 3:  # Employee Type
				foreach($organizations as $org) {
				    if (!isset($org['description'])) continue;
				    $employee_type = $org['description'];
				    if (preg_match("/".$pattern."/", $employee_type)) {
					echo "  match \n";
                     $match=1;
					$member = $google->getGroupMember($sg->google_group_id, $user['id']);
					if (!$member) {
					    echo "  not yet a member, so add \n";
					    $google->addUserToGroup($user['primaryEmail'],$sg->google_group_id);
					} else {
					    echo "  already a member \n";
					}

				    } else {
					echo "  no match for $email with the pattern: $pattern \n";
				    }
                            	}
                            break;
                        case 4:  # Department
				foreach($organizations as $org) {
				    if (!isset($org['department'])) continue;
				    $department = $org['department'];
				    if (preg_match("/".$pattern."/", $department)) {
					echo "  match \n";
                     $match=1;
					$member = $google->getGroupMember($sg->google_group_id, $user['id']);
					if (!$member) {
					    echo "  not yet a member, so add \n";
					    $google->addUserToGroup($user['primaryEmail'],$sg->google_group_id);
					} else {
					    echo "  already a member \n";
					}

				    } else {
					echo "  no match for $email with the pattern: $pattern \n";
				    }
                            	}
                            break;
                        case 5:  # Cost Center
				foreach($organizations as $org) {
				    if (!isset($org['costCenter'])) continue;
				    $costcenter = $org['costCenter'];
				    if (preg_match("/".$pattern."/", $costcenter)) {
					echo "  match \n";
                     $match=1;
					$member = $google->getGroupMember($sg->google_group_id, $user['id']);
					if (!$member) {
					    echo "  not yet a member, so add \n";
					    $google->addUserToGroup($user['primaryEmail'],$sg->google_group_id);
					} else {
					    echo "  already a member \n";
					}

				    } else {
					echo "  no match for $email with the pattern: $pattern \n";
				    }
                            	}
                            break;
                        case 6:  # Manager Email
				foreach($relations as $relation) {
				    $type = $relation['type'];
				    if ($type != "manager") continue;
				    $manager_email = $relation['value'];
				    if (preg_match("/".$pattern."/", $manager_email)) {
					echo "  match \n";
                     $match=1;
					$member = $google->getGroupMember($sg->google_group_id, $user['id']);
					if (!$member) {
					    echo "  not yet a member, so add \n";
					    $google->addUserToGroup($user['primaryEmail'],$sg->google_group_id);
					} else {
					    echo "  already a member \n";
					}

				    } else {
					echo "  no match for $email with the pattern: $pattern \n";
				    }
                            	}
                            break;
                        case 7:  # Employee Title
				foreach($organizations as $org) {
				    if (!isset($org['title'])) continue;
				    $title = $org['title'];
				    if (preg_match("/".$pattern."/", $title)) {
					echo "  match \n";
                     $match=1;
					$member = $google->getGroupMember($sg->google_group_id, $user['id']);
					if (!$member) {
					    echo "  not yet a member, so add \n";
					    $google->addUserToGroup($user['primaryEmail'],$sg->google_group_id);
					} else {
					    echo "  already a member \n";
					}

				    } else {
					echo "  no match for $email with the pattern: $pattern \n";
				    }
                            	}
                            break;

                    }
                
                if (!$match) {
                    $member = $google->getGroupMember($sg->google_group_id, $user['id']);
                    if ($member) {
                        echo "  already a  member, so delete \n";
                        $google->deleteUserFromGroup($user['id'],$sg->google_group_id);
                    } else {
                        echo "  not yet a member \n";
                    }
                }
    
                }
                $i++;
            }



            $next = $results->getNextPageToken();
            $page++;
            }
        echo "page: $page \n";
        exit;



        $groups = SmartGroup::get();
        Log::info('smart', ['context' => "start"]);
        
        foreach ($users as $user) {
        
        }
    
    #$this->notify($late_contacts,$ok_contacts,$env_name);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['env_name', InputArgument::REQUIRED, 'An env argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            //['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    protected function notify($late_contacts,$ok_contacts,$env_name) {

        $data = array("late_contacts" => $late_contacts, "module"=>"REPORT", "env_name"=>$env_name, "error"=>"no errors", "ok_contacts"=>$ok_contacts);
        Mail::send('emails.report', $data, function($message) use ($data){
            $message->from('noreply@rhconsultingllc.com', 'NoReply Safe Call');
            $to = env('ADMIN_EMAIL');
            $subject = "Safe Call Daily Report";
             if ($data['env_name'] == "dev")
                $subject = "[dev] " . $subject;
        $message->to("richard@rhconsultingllc.com", "Richard");
            $message->to($to, "SafeCall Admin")->subject($subject);
        });
    }


    //this function converts string from UTC time zone to current user timezone
    protected function convertTimeToUSERzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){
        if(empty($str)){
        return '';
        }
        
        $new_str = new DateTime($str, new DateTimeZone('UTC') );
        $new_str->setTimeZone(new DateTimeZone( $userTimezone ));
        return $new_str->format( $format);
    }


}
