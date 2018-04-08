<?php

class Select{
    private $column;
    private $min;
    private $max;
    private $count;
    private $avg;
    private $sum;

    public function __construct($column, $min, $max, $count, $avg, $sum)
    {
        $this->column = $column;
        $this->min = $min;
        $this->max = $min;
        $this->count = $min;
        $this->avg = $min;
        $this->sum = $min;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getAvg()
    {
        return $this->avg;
    }

    public function getSum()
    {
        return $this->sum;
    }

}
