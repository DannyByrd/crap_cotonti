<?php

class Mailchimp_Integration {
	public $api_key = '';
	public $lists;
	public $curr_list;
	private $request_error = '';
	
	public function __construct($api_key, $list_name) {
		$this->api_key = $api_key;
		if(!$api_key) return false;
		$this->setList($list_name);
	}
	
	private function getLists() {
		$curl_data = array(
			'method'	=> 'lists',
			'apikey'	=> $this->api_key,
			'limit'		=> 100
		);
		$response = $this->curlRequest($curl_data);
		return $response;
	}

	public function get_errors(){
		return $this->request_error;
	}

	private function setList($list_name){
		$lists = $this->getLists();
		$this->lists = $lists['data'];

		// var_dump($this->lists);

		foreach ($this->lists as $key => $list) {
			if($list['name'] == $list_name){
				$this->curr_list = $list;
			}
		}
	}


	
	private function curlRequest($data = array()) {
		$data_center = explode('-', $data['apikey']);
		$url = 'https://' . (isset($data_center[1]) ? $data_center[1] : 'us1') . '.api.mailchimp.com/1.3/?output=json&method=' . $data['method'];
		
        $curl = curl_init($url);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 90);
		$response = json_decode(curl_exec($curl), true);
		
		if (curl_error($curl)) {
			$response = array('code' => 'CURL', 'error' => curl_errno($curl) . ': ' . curl_error($curl));
			$this->request_error = curl_errno($curl) . ': ' . curl_error($curl);
		} elseif (empty($response)) {
			$response = array('code' => 'CURL', 'error' => 'Empty gateway response');
		} elseif (!empty($response->error)) {
			$response = array('code' => $response->code, 'error' => $response->error);
			$this->request_error = $response->error;
		}

		curl_close($curl);
		
		return $response;
	}

    public function listBatchSubscribeOne($input_data){

    	if(!$input_data['email'] && !$input_data['fname'] && !$input_data['phone']) return false;

		$batch[0]['EMAIL'] = $input_data['email'];
		$batch[0]['FNAME'] = $input_data['fname'];
		$batch[0]['PHONE'] = $input_data['phone'];
        $curl_data = array(
            'method'			=> 'listBatchSubscribe',
            'apikey'			=> $this->api_key,
            'id'				=> $this->curr_list['id'],
            'batch'				=> $batch,
            'double_optin'		=> false,
            'update_existing'	=> true
        );

        $response = $this->curlRequest($curl_data);

        if (!empty($response['error'])) {
            // if ($settings['logerrors']) $this->log->write(strtoupper($this->name) . ' ' . $response['code'] . ' ERROR: ' . $response['error']);
            return $response['error'];
        } 

        return $response;
    }
}
	
?>