<?php
class ytdata {
	private $_title;
	private $_likeCount;
	private $_viewCount;
	private $_id;
	private $_description;
	private $_duration;
	private $_rating;
	private $_hqDefault;
	private $_errorCode;
	private $_errorMsg;
	
	function ytdata($url){
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
		$data = json_decode($data);
		if (!$data) {
			throw new Exception('ytdata: No data found. ');
			return;
		}
		if($data->error){
		    $this->_errorCode = $data->error->code;
		    $this->_errorMsg = $data->error->message;
		    return;
		}
		$this->_title = $data->data->title;
		$this->_likeCount = $data->data->likeCount;
		$this->_viewCount = $data->data->viewCount;
		$this->_id = $data->data->id;
		$this->_description = $data->data->description;
		$this->_duration = $data->data->duration;
		$this->_rating = $data->data->duration;
		$this->_hqDefault = $data->data->thumbnail->hqDefault;
	}
	public function get_title(){
	    return $this->_title;
	}
	public function get_likeCount() {
        return $this->_likeCount;
    }
    public function get_viewCount(){
        return $this->_viewCount;
    }
    public function get_id(){
        return $this->_id;
    }
    public function get_description(){
        return $this->_description;
    }
    public function get_duration(){
        $tmp = $this->_duration;
        while($tmp != 0){
            if($tmp > 3600){
                $h++;
                $tmp -= 3600;
            }else if($tmp > 60){
                $m++;
                $tmp -= 60;
            } else if($tmp > 0){
                $s++;
                $tmp--;
            }
        }
        if($h){
            $t .= $h .":";
        }
        if($m){
            $t .= $m .":";
        }
        if($s){
            $t .= $s;
        }
        return  $t;
    }
    public function get_rating(){
        return $this->_rating;
    }
    public function get_thumbnail(){
        return $this->_hqDefault;
    }
    public function get_errorMsg(){
        return $this->_errorMsg;
    }
    public function get_errorCode(){
        return $this->_errorCode;
    }
};
?>