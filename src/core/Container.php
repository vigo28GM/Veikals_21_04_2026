<?php

/**
 * Container - Vienkārša Dependency Injection (DI) konteinera implementācija.
 * Atbild par servisu reģistrēšanu un to objektu vienreizēju izveidi (Singleton pattern).
 */
class Container {
    /** @var array Glabā funkcijas (callbacks), kas definē, kā izveidot servisu */
    private $bindings = [];

    /** @var array Glabā jau izveidotos servisu objektus atkārtotai izmantošanai */
    private $instances = [];

    /**
     * Reģistrē jaunu servisu konteinerā.
     * 
     * @param string $name Servisa nosaukums
     * @param callable $callable Funkcija, kas atgriež servisa objektu
     */
    public function set($name, $callable) {
        $this->bindings[$name] = $callable;
    }

    /**
     * Iegūst servisa objektu no konteinera.
     * Ja objekts jau ir izveidots, atgriež to pašu instanci.
     * 
     * @param string $name Servisa nosaukums
     * @return mixed Servisa objekts
     * @throws Exception Ja serviss nav reģistrēts
     */
    public function get($name) {
        // Atgriežam jau esošu instanci, ja tāda ir
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        // Ja serviss ir reģistrēts, izsaucam tā izveides funkciju
        if (isset($this->bindings[$name])) {
            $this->instances[$name] = $this->bindings[$name]($this);
            return $this->instances[$name];
        }

        throw new Exception("Service not found: " . $name);
    }
}
