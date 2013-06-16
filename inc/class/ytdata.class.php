<?php
class ytdata {
	var $url;
	
	public function get_api_data() {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
		$data = json_decode($data);
		if (!$data) {
			throw new Exception('get_api_data: No data found. ');
		}
        return $data;
    }

};
?>