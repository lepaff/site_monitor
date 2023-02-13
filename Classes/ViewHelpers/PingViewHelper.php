<?php

namespace LEPAFF\SiteMonitor\ViewHelpers;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Closure;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ping ViewHelper.
 */
class PingViewHelper extends AbstractViewHelper
{
    public static function renderStatic(
        array $arguments,
        Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $url = explode('://', $arguments['url']);
        $url = explode('/', $url[1]);
        $ping = shell_exec('ping -c1 '.$url[0]);

        if (null === $ping) {
            return;
        }
        $times = explode(' = ', $ping);
        $avg = explode('/', $times[1]);

        return $avg[1];
    }

     public function initializeArguments(): void
     {
         $this->registerArgument('url', 'string', 'The url', true);
     }
}
