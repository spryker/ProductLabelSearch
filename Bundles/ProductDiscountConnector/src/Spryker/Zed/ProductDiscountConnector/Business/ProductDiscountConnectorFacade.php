<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductDiscountConnector\Business;

use Generated\Shared\Transfer\ClauseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\ProductDiscountConnector\Business\ProductDiscountConnectorBusinessFactory getFactory()
 */
class ProductDiscountConnectorFacade extends AbstractFacade
{
    /**
     * @param QuoteTransfer $quoteTransfer
     * @param ItemTransfer $itemTransfer
     * @param ClauseTransfer $clauseTransfer
     *
     * @return bool
     */
    public function isProductAttributeSatisfiedBy(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer,
        ClauseTransfer $clauseTransfer
    )
    {
        return $this->getFactory()
            ->createProductAttributeDecisionRule()
            ->isSatisfiedBy($quoteTransfer, $itemTransfer, $clauseTransfer);
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     * @param ClauseTransfer $clauseTransfer
     *
     * @return \Generated\Shared\Transfer\DiscountableItemTransfer[]
     */
    public function collectByProductAttribute(QuoteTransfer $quoteTransfer, ClauseTransfer $clauseTransfer)
    {
        return $this->getFactory()->createProductAttributeCollector()->collect($quoteTransfer, $clauseTransfer);
    }
}
