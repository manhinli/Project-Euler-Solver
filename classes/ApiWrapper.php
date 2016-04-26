<?php

class ApiWrapper {
    private $content;
    
    public function __construct($content) {
        $this->content = $content;
    }
    
    public function convert_content_to_json() {
        return json_encode($this->content, JSON_UNESCAPED_UNICODE);
    }
    
    public function respond_as_json() {
        header("Content-Type: application/json; charset=utf-8");
        echo $this->convert_content_to_json();
    }
}

class ErrorApiWrapper extends ApiWrapper {
    public function __construct($exception) {
        parent::__construct(array("error" => $exception->getMessage()));
    }
    
    public function respond_as_json($httpStatus = 400) {
        http_response_code($httpStatus);
        parent::respond_as_json();
    }
}

?>
