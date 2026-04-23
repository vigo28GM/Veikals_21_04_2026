<?php

class Container {
    // Šeit glabājas funkcijas (closures), kas māk izveidot konkrētus objektus
    private $bindings = [];
    // Šeit glabājas jau izveidotie objekti, lai tie nebūtu jātaisa no jauna (Singleton pattern)
    private $instances = [];

    public function set($name, $callable) {
        $this->bindings[$name] = $callable;
    }

    public function get($name) {
        // Ja objekts jau ir izveidots, atdodam to
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        // Ja mums ir recepte šim nosaukumam, izpildām to
        if (isset($this->bindings[$name])) {
            $this->instances[$name] = $this->bindings[$name]($this);
            return $this->instances[$name];
        }

        throw new Exception("Service not found: " . $name);
    }
}
