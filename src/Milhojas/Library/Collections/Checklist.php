<?php

namespace Milhojas\Library\Collections;

/**
 * Represents an inmutable list of elements that can be checked/unchecked.
 */
class Checklist
{
    protected $items;

    /**
     * @param mixed $elements The elements of the check list
     */
    public function __construct($elements)
    {
        $this->items = array_fill_keys($elements, false);
        ksort($this->items);
    }

    /**
     * Returns the elements as an array.
     *
     * @return array The elements
     */
    public function asArray()
    {
        return array_keys($this->items);
    }

    /**
     * Checks the element identified by $item.
     *
     * @param mixed $item
     */
    public function check($items)
    {
        foreach ((array) $items as $item) {
            $item = $this->normalize($item);
            $this->isSupported($item);

            $this->items[$item] = true;
        }
    }

    /**
     * Unchecks the element identified by $item.
     *
     * @param mixed $item
     */
    public function unCheck($items)
    {
        foreach ((array) $items as $item) {
            $item = $this->normalize($item);
            $this->isSupported($item);

            $this->items[$item] = false;
        }
    }

    /**
     * Tells if element $item is checked.
     *
     * @param mixed $item
     *
     * @return bool true if element is checked
     */
    public function isChecked($item)
    {
        $item = $this->normalize($item);
        $this->isSupported($item);

        return $this->items[$item];
    }

    public function hasCoincidencesWith($another_list)
    {
        return 0 !== count($this->getCoincidencesWith($another_list));
    }

    public function getCoincidencesWith($another_list)
    {
        $filter = function ($item) use ($another_list) {
            return $this->items[$item] && $another_list->items[$item];
        };

        return array_filter($this->asArray(), $filter);
    }

    /**
     * Normalizes input $item to ensure is lower case.
     *
     * @param mixed $item
     *
     * @return string normalized item
     */
    private function normalize($item)
    {
        return strtolower(trim($item));
    }

    /**
     * Ensures element $item is managed by this list.
     *
     * @param mixed $item
     *
     * @throws \InvalidArgumentException if $item is not supported
     */
    private function isSupported($item)
    {
        if (!array_key_exists($item, $this->items)) {
            throw new \InvalidArgumentException(sprintf('List doesn\'t know about "%s"', $item));
        }
    }

    public function checkAll()
    {
        $this->items = array_fill_keys(array_keys($this->items), true);
    }

    public function uncheckAll()
    {
        $this->items = array_fill_keys(array_keys($this->items), false);
    }

    public function hasMarks()
    {
        return array_sum($this->items);
    }

    public function getListAsString()
    {
        return implode(', ', $this->getChecked());
    }

    public function getChecked()
    {
        return array_keys(array_filter($this->items, function ($value) {
            return $value;
        }));
    }
}
