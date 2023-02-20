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
 * phpversion ViewHelper.
 */
class PhpversionViewHelper extends AbstractViewHelper
{
    public static function renderStatic(
        array $arguments,
        Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $phpversion = explode('-', $arguments['phpversion']);

        return $phpversion[0];
    }

     public function initializeArguments(): void
     {
         $this->registerArgument('phpversion', 'string', 'The PHP version', true);
     }
}
