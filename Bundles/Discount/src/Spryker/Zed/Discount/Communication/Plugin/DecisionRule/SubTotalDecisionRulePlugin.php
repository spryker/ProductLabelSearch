<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Discount\Communication\Plugin\DecisionRule;

use Generated\Shared\Transfer\ClauseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Discount\Business\QueryString\ComparatorOperators;
use Spryker\Zed\Discount\Dependency\Plugin\DecisionRulePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\Discount\Business\DiscountFacade getFacade()
 */
class SubTotalDecisionRulePlugin extends AbstractPlugin implements DecisionRulePluginInterface
{

    /**
     * @param QuoteTransfer $quoteTransfer
     * @param ItemTransfer $itemTransfer
     * @param ClauseTransfer $clauseTransfer
     *
     * @return mixed
     */
    public function isSatisfiedBy(
        QuoteTransfer $quoteTransfer,
        ItemTransfer $itemTransfer,
        ClauseTransfer $clauseTransfer
    )
    {
        return $this->getFacade()
            ->isSubTotalSatisfiedBy($quoteTransfer, $itemTransfer, $clauseTransfer);
    }

    /**
     * Name of field as used in query string
     *
     * @return string
     */
    public function getFieldName()
    {
        return 'sub-total';
    }

    /**
     * Data types used by this field. (string, integer, list)
     *
     * @return array
     */
    public function acceptedDataTypes()
    {
        return [
            ComparatorOperators::TYPE_INTEGER
        ];
    }
}
