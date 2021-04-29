<?php
    class Smsgateway
    {
        public function send($config = [])
        {            
            //$config['to'] = $this->validMobile($config['to']);
            //if (sizeof($config) < 6) exit('Sms Gateway configuration missing'); 
            
            switch (strtolower($config['apiProvider'])) {

                case 'nexmo':
                        return $this->nexmo($config);
                    break; 
                 case 'clickatell':
                        return $this->send_clickatell_message($config);
                    break;
                                       
                default:
                        return json_encode(['exception' => 'No api found']);
                    break;
            }
        } 

 
        #--------------------------------------------   
        # For nexmo provider
        public function nexmo($config = [])
        {                       
            $url = "https://rest.nexmo.com/sms/json?api_key=".urlencode($config['username'])."&api_secret=".urlencode($config['password'])."&to=".urlencode($config['to'])."&from=".urlencode($config['from'])."&text=".urlencode($config['message'])."";                       
            try {
                return @file_get_contents($url);
            }
            catch (Exception $e) {
                echo "Nexmo error : ".$e->getMessage();
            }

        }

		public function smspk($config = [])
		{
			$username = "923454087418";///Your Username
			$password = "5614";///Your Password
			$mobile = $postData['mobile'];///Recepient Mobile Number
			$sender = "TDCLHR";
			$message = $sms_teamplate->teamplate;
			
			////sending sms
			
			$post = "sender=".urlencode($sender)."&mobile=".urlencode($config['to'])."&message=".urlencode($config['message'])."";
			$url = "https://sendpk.com/api/sms.php?username=923454087418&password=5614";
			$ch = curl_init();
			$timeout = 30; // set to zero for no timeout
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result = curl_exec($ch); 	
			
		}
        #--------------------------------------------       
        public function send_clickatell_message($config = [])
        {
           $url = "https://platform.clickatell.com/messages/http/send?apiKey=".urlencode($config['username'])."==&to=".urlencode($config['to'])."&content=".urlencode($config['message'])."&from=".urlencode($config['from'])."";
            $result = $this->_do_api_call($url); 
            return $result;    
        }


        private function _do_api_call($url)
        {
            $result = file($url);      
            return $result;
        }
        #---------------------------------------



        private $operator = array('11','12','13','14','15','16','17','18','19'); 

        public function validMobile($mobile = null)
        {    
           $mobile = trim($mobile); 
            if ($this->checkValidMobileOperator($mobile) != false) { 
                $countryCode = substr($mobile, 0, 2);
                if (in_array($countryCode, $this->operator)) {
                    $newMobileNo = substr_replace($mobile,"880",0,0);
                } elseif ($countryCode == "01") {
                    $newMobileNo = substr_replace($mobile,"88",0,0);
                } elseif ($countryCode == "80") {
                    $newMobileNo = substr_replace($mobile,"8",0,0);
                } elseif ($countryCode == "+8") {
                    $newMobileNo = substr_replace($mobile,"",0,1);
                } else {
                    $newMobileNo = $mobile;
                } 
                return $newMobileNo; 
            }
        }


        protected function checkValidMobileOperator($mobile = null)
        {
            if(10 <= strlen($mobile) && strlen($mobile) <= 15){

                if(strlen($mobile) == 10){ /*for 10 digits*/
                    return in_array(substr($mobile,0,2), $this->operator);
                } elseif (strlen($mobile) == 11) { /*for 11 digits*/
                    return in_array(substr($mobile,1,2), $this->operator);
                } elseif (strlen($mobile) == 12) { /*for 12 digits*/ 
                    return in_array(substr($mobile,2,2), $this->operator);
                } elseif(strlen($mobile) == 13){ /*for 13 digits*/  
                    return in_array(substr($mobile,3,2), $this->operator);
                } elseif(strlen($mobile) == 14){ /*for 14 digits*/ 
                    return in_array(substr($mobile,4,2), $this->operator);
                } elseif(strlen($mobile) == 15){ /*for 15 digits*/
                    return in_array(substr($mobile,5,2), $this->operator);
                }

            } else {
                return false;
            }
        } 


        public function template($config = null)
        {
            $newStr = $config['message'];
            foreach ($config as $key => $value) {
                $newStr = str_replace("%$key%", $value, $newStr);
            }  
            return $newStr; 
        }

    } 
