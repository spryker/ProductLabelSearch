<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Glossary\Code\KeyBuilder;

use Spryker\Shared\Collector\Code\KeyBuilder\KeyBuilderTrait;

trait GlossaryKeyBuilder
{

    use KeyBuilderTrait;

    /**
     * @param string $idAbstractProduct
     *
     * @return string
     */
    protected function buildKey($idAbstractProduct)
    {
        return 'translation.' . $idAbstractProduct;
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return 'glossary';
    }

}
