<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\DependencyInjection;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

/**
 * HistoryStack tracks the history
 */
class HistoryStack implements SessionBagInterface, \IteratorAggregate
{

    protected $size;
    protected $stack;

    public function __construct($s = 10)
    {
        $this->size = $s;
    }

    public function clear()
    {
        $this->stack = [];
    }

    public function getName()
    {
        return 'history';
    }

    public function getStorageKey()
    {
        return '_sf2_history';
    }

    public function initialize(array &$array)
    {
        $this->stack = &$array;
    }

    public function push($url, $title)
    {
        if (array_key_exists($url, $this->stack)) {
            unset($this->stack[$url]);
        }

        $tmp = array_reverse($this->stack);
        $tmp[$url] = $title;
        $this->stack = array_reverse($tmp);

        array_splice($this->stack, $this->size);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->stack);
    }

}