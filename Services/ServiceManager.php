<?php

namespace Services;

include_once 'IService.php';

/**
 * Cria um serviço
 */
class ServiceManager implements IService {

    /**
     * Cria um servico
     * @param String $services O nome do servico a ser criado
     * @param Array $params Um array de parametros para o construtor da classe chamada
     * @return Object
     */
    public function getService($services, array $params = null) {

        include_once $services . '.php';
        $classname = str_replace('/', '\\', $services);
        if (class_exists($classname)) {

            return new $classname($this, $params);
        } else {
            exit("class not found: {$classname}");
        }
    }

}
