<?php

/**
 * Copyright (c) 2013-2017 OpenCFP
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/opencfp/opencfp
 */

namespace OpenCFP\Domain\Services;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidator
{
    public function isValid(Request $request): bool;
}
