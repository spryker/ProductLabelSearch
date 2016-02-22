<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Nopayment\Business;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

interface NopaymentFacadeInterface
{

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return array
     */
    public function setAsPaid(array $orderItems);

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return array
     */
    public function isPaid(SpySalesOrderItem $orderItem);

}