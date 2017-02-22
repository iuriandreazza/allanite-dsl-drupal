<?php

/**
 * Class CCMNodeWrapper
 *
 * Common Wrapper for Custom Nodes on Drupal
 *
 */
class CCMNodeWrapper implements CMMWrapper {

    /**
     * CCMNodeWrapper constructor.
     * @param $params
     */
    public function __construct($params) {

    }

    /**
     *
     * @return string
     */
    public function render() {
        $lines = array();
        $lines[] = '$'.$this->wrapper_name.'Node = new stdClass();';

        $lines[] = 'node_submit($'.$this->wrapper_name.'Node);';
        $lines[] = 'node_save($'.$this->wrapper_name.'Node);';
        return implode(PHP_EOL, $lines);
    }

}