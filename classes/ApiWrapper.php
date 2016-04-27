<?php

class ApiWrapper {
    private $content;
    
    public function __construct($content) {
        $this->content = $content;
    }
    
    public function convert_content_to_json() {
        // Convert all content to JSON
        return json_encode($this->content, JSON_UNESCAPED_UNICODE);
    }
    
    public function respond_as_json() {
        // Respond to clients with the appropriate header and JSON content
        header("Content-Type: application/json; charset=utf-8");
        echo $this->convert_content_to_json();
    }
}

class ErrorApiWrapper extends ApiWrapper {
    public function __construct($exception) {
        // Use the exception message as the content
        parent::__construct(array("error" => $exception->getMessage()));
    }
    
    public function respond_as_json($httpStatus = 400) {
        // We deliver a different response code (default = HTTP 400)
        //  when responding with the error JSON response
        http_response_code($httpStatus);
        parent::respond_as_json();
    }
}

?>
