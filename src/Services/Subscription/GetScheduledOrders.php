<?php

namespace App\Services\Subscription;

use App\Entities\Subscription;
use App\Entities\ScheduledOrder;

class GetScheduledOrders
{
    /**
     * Handle generating the array of scheduled orders for the given number of weeks and subscription.
     *
     * @param \App\Entities\Subscription $subscription
     * @param int                        $forNumberOfWeeks
     *
     * @return array
     */
    public function handle(Subscription $subscription, $forNumberOfWeeks = 6)
    {
        if ($subscription->getStatus() === Subscription::STATUSES_ALLOWED[Subscription::STATUS_ACTIVE]) {
            $scheduledOrders = [];
            $nextDeliveryDate = $subscription->getNextDeliveryDate();
            $deliveryDate = $nextDeliveryDate->copy();
            $isInterval = $subscription->getPlan() === Subscription::PLANS_ALLOWED[Subscription::PLAN_WEEKLY] ? TRUE : FALSE;
            $interval = true;
            for ($i = 0; $i < $forNumberOfWeeks; $i++) {
                $scheduledOrder = new ScheduledOrder($deliveryDate, $interval);
                $scheduledOrder->setHoliday(!$interval);
                $scheduledOrder->setOptIn($interval);
                $scheduledOrders[] = $scheduledOrder;
                $deliveryDate = $deliveryDate->copy()->addWeek();
                $interval = $isInterval ? $interval : !$interval;
            }
            return $scheduledOrders;
        } else {
            return [];
        }
    }
}