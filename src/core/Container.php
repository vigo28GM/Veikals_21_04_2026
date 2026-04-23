<?php

class Container {
    private $services = [];

    public function set($name, $callback) {
        $this->services[$name] = $callback;
    }

    public function get($name) {
        if (!isset($this->services[$name])) {
            throw new Exception("Serviss '$name' nav atrasts konteinerī.");
        }

        // Izpildām callback, lai iegūtu servisa instanci
        return is_callable($this->services[$name]) 
            ? $this->services[$name]($this) 
            : $this->services[$name];
    }
}
