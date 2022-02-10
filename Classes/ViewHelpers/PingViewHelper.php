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

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ping ViewHelper
 *
 */
class PingViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('url', 'string', 'The url', true);
    }

   public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext
   ) {
        $url = explode('://', $arguments['url']);
        $url = explode('/', $url[1]);
        $ping = shell_exec('ping -c1 ' . $url[0]);
        if ($ping === null) {
            return null;
        }
        $times = explode(' = ', $ping);
        $avg = explode('/', $times[1]);

        return $avg[1];
   }
}
