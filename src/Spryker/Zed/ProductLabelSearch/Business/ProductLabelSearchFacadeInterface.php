<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductLabelSearch\Business;

use Generated\Shared\Transfer\ProductPageLoadTransfer;

interface ProductLabelSearchFacadeInterface
{
    /**
     * Specification:
     * - Gets product label ids from eventTransfers.
     * - Retrieves a list of abstract product ids by product label ids.
     * - Queries all product abstract with the given abstract product ids.
     * - Stores data as json encoded to storage table.
     * - Sends a copy of data to queue based on module config.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function writeCollectionByProductLabelEvents(array $eventTransfers): void;

    /**
     * Specification:
     * - Gets abstract product ids from eventTransfers.
     * - Queries all product abstract with the given abstract product ids.
     * - Stores data as json encoded to storage table.
     * - Sends a copy of data to queue based on module config.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function writeCollectionByProductLabelProductAbstractEvents(array $eventTransfers): void;

    /**
     * Specification:
     * - Expand product page load transfer with product label ids mapped by id product abstract and store name
     * - Returns a product page load transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $loadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageData(ProductPageLoadTransfer $loadTransfer);
}