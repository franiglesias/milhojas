<?php

namespace Milhojas\Domain\Utils;

class CheckList implements \ArrayAccess, \Countable
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = array_fill_keys($items, false);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
          return $this->items[$offset];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    public function check($items)
    {
        foreach ((array) $items as $item) {
            $this[$item] = true;
        }
    }

    public function isChecked($item)
    {
        return $this[$item];
    }

    public function getChecked()
    {
        $checked = new self(array_keys(array_filter($this->items)));

        return $checked;
    }

    public function __toString()
    {
        $ret = '';
        foreach ($this->items as $item => $check) {
            $ret .= sprintf('[%s] %s', $check ? '√' : ' ', $item).chr(10);
        }

        return $ret.chr(10);
    }

    public function checkAll()
    {
        $this->items = array_fill_keys(array_keys($this->items), true);
    }

    public function areChecked($items_to_check)
    {
        $overall = false;
        foreach ($items_to_check as $item) {
            $overall = $this->isChecked($item);
        }

        return $overall;
    }

    public function intersect(CheckList $compare)
    {
        $intersection = [];
        foreach ($compare->items as $item => $checked) {
          if (!$checked) {
            continue;
          }
          if ($this->isChecked($item)) {
            $intersection[] = $item;
          }
        }
        $intersection = new self($intersection);
        $intersection->checkAll();
        return $intersection;
    }
}
