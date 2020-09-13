<?php

namespace App\Entities;

use Carbon\Carbon;

class ScheduledOrder
{
    /**
     * The delivery date of this scheduled order.
     *
     * @var \Carbon\Carbon
     */
    protected $deliveryDate;

    /**
     * Is this delivery marked as a holiday that will be skipped.
     *
     * @var bool
     */
    protected $holiday = false;

    /**
     * Is this scheduled order an opt in order that is not part of the normal subscription's plan cycle.
     *
     * @var bool
     */
    protected $optIn = false;

    /**
     * Is this scheduled order part of the subscriptions normal plan cycle.
     *
     * @var bool
     */
    protected $interval = true;

    /**
     * ScheduledOrder constructor.
     *
     * @param \Carbon\Carbon     $deliveryDate
     * @param bool $isInterval
     */
    public function __construct(Carbon $deliveryDate, bool $isInterval)
    {
        $this->deliveryDate = $deliveryDate;
        $this->interval     = $isInterval;
    }
    
    /**
     * Is used to check scheduled order part of the subscriptions normal plan cycle.
     * @return bool
     */
    public function isInterval(): bool
    {
        return $this->interval;
    }
    
    /**
     * To set a delivery date as holiday
     * @param bool $holiday
     * @return self 
     */
    public function setHoliday(bool $holiday)
    {
        $this->holiday = $this->isInterval() ? $holiday : false;

        return $this;
    }
    
    /**
     * To check the delivery date is a holiday
     * @return bool
     */
    public function isHoliday(): bool
    {
        
        return $this->holiday;
    }
    
    /**
     * To get delivery date
     * @return \Carbon\Carbon
     */
    public function getDeliveryDate(): \Carbon\Carbon
    {
        return $this->deliveryDate;
    }
    
    /**
     * To scheduled order an opt in order that is not part of the normal subscription's plan cycle.
     * @return self
     */
    public function setOptIn(bool $isOptIn)
    {
        $this->optIn = $this->isInterval() ? false : $isOptIn;
        
        return $this;
    }
    
    /**
     * To check scheduled order an opt in order that is not part of the normal subscription's plan cycle.
     * @return bool
     */
    public function isOptIn(): bool
    {
        return $this->optIn;
    }
    
}