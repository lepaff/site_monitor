<?php
namespace MP\SiteMonitor\ViewHelpers;

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
 * Sort versions ViewHelper
 *
 */
class SortVersionsViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('versions', 'array', 'The versions', true);
    }

   public static function renderStatic(
       array $arguments,
       \Closure $renderChildrenClosure,
       RenderingContextInterface $renderingContext
   ) {
        $versions = [];
        $versionsDev = [];
        foreach($arguments['versions'] as $version) {
            if (substr($version->getVersion(), 0, 4) === 'dev-') {
                $versionsDev[$version->getVersion()] = $version->getVersion();
            } else {
                $versions[$version->getVersion()] = $version->getVersion();
            }
        }
        arsort($versions);
        arsort($versionsDev);
        $out = array_merge($versions, $versionsDev);

        return $out;
   }
}
