<?php

/*
 * This file is part of the Alice package.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nelmio\Alice\Fixtures\Parser\Methods;

use UnexpectedValueException;

/**
 * Each fixture has access to $context->fake() to generate data.
 *
 * The array format must follow this example:
 *
 *     array(
 *         'Namespace\Class' => array(
 *             'name' => array(
 *                 'property' => 'value',
 *                 'property2' => 'value',
 *             ),
 *             'name2' => array(
 *                 [...]
 *             ),
 *         ),
 *     )
 */
class Php extends Base
{
    /**
     * @var string
     **/
    protected $extension = 'php';

    /**
     * {@inheritDoc}
     */
    public function parse($file)
    {
        $context = $this->context;
        $includeWrapper = function () use ($file, $context) {
            ob_start();
            $res = include $file;
            ob_end_clean();

            return $res;
        };

        $data = $includeWrapper();

        if (!is_array($data)) {
            throw new UnexpectedValueException("Included file \"{$file}\" must return an array of data");
        }

        return $data;
    }
}
