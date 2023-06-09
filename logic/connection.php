<?php

class DbInteraction{

    protected $url;

    public function __construct($url) {
        $this->url = $url;
    }
    
    public function getData() {
        $credenciales["http"]["method"] = "GET";
        $config = stream_context_create($credenciales);
        $_DATA = file_get_contents($this->url, false, $config);
        return json_decode($_DATA, true);
    }
    
    public function postData($datas) {
        header('Content-Type: application/json');
        $credenciales["http"]["method"] = "POST";
        $credenciales["http"]["headers"]["Content-Type"] = "application/json";
        $credenciales["http"]["content"] = $datas;
        $config = stream_context_create($credenciales);
        $_DATA = file_get_contents($this->url, false, $config);
        print_r(json_decode($_DATA, true));
    }
    
    public function deleteData($cedula) {
        $dataToSearch = $this->getData();
        $matchingElement = null;
        foreach ($dataToSearch as $element) {
            if ($element['Cedula'] == $cedula) {
                $matchingElement = $element;
                break;
            }
        }
        header('Content-Type: application/json');
        $credenciales["http"]["method"] = "DELETE";
        $config = stream_context_create($credenciales);
        $_DATA = file_get_contents($this->url . "/" . $matchingElement["id"], false, $config);
        return json_decode($_DATA, true);
    }
    
    public function putData($datas, $id) {
        header('Content-Type: application/json');
        $credenciales["http"]["method"] = "PUT";
        $credenciales["http"]["headers"]["Content-Type"] = "application/json";
        $credenciales["http"]["content"] = $datas;
        $config = stream_context_create($credenciales);
        $_DATA = file_get_contents($this->url . "/" . $id, false, $config);
        print_r(json_decode($_DATA, true));
    }
    
    public function getUserData($cedula) {
        $dataToSearch = $this->getData();
        $matchingElement = null;
        foreach ($dataToSearch as $element) {
            if ($element['Cedula'] == $cedula) {
                $matchingElement = $element;
                break;
            }
        }
        $credenciales["http"]["method"] = "GET";
        $config = stream_context_create($credenciales);
        $_DATA = file_get_contents($this->url . "/" . $matchingElement["id"], false, $config);
        return json_decode($_DATA, true);
    }
    
}