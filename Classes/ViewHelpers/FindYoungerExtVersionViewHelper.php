<?php

namespace LEPAFF\SiteMonitor\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class FindYoungerExtVersionViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('extension', 'string', 'Current extension', true);
    }

    public function render() {
        $extension = $this->arguments['extension'];
        $version = $this->sanitizeVersionNumber($extension->getVersionInstalled());
        $valid = $this->isValidExtensionVersion($version, $extension);
        if (!$valid) {
            return '';
        }
        // DebuggerUtility::var_dump($extension, 'Exts - ' . substr($version, 0, 3));
        $availableVersions = $extension->getExtensionDoc()->getVersions();
        foreach($availableVersions as $aVersion) {
            $aVersion = $this->sanitizeVersionNumber($aVersion->getVersion());
            $valid = $this->isValidExtensionVersion($aVersion, $extension);
            if (!$valid) {
                continue;
            }
            if ($this->version_compare2($aVersion, $version) === 1 && explode('.', $aVersion)[0] === explode('.', $version)[0]) {
                return $aVersion;
            }
        }

        return '';
    }

    private function sanitizeVersionNumber($version) {
        $version = str_replace('^', '', $version);
        $version = str_replace('.*', '', $version);
        if (substr($version, 0, 1) === 'v') {
            $version = substr($version, 1);
        }

        return $version;
    }

    private function isValidExtensionVersion($version, $extension) {

        if (
            $version === '@dev' ||
            str_contains($version, '-dev') ||
            substr($version, 0, 3) === 'dev' ||
            $extension->getExtensionDoc() === '' ||
            substr($extension->getTitle(), 0, 9) === 'typo3/cms'
        ) {
            return false;
        }
        return true;
    }

    //Compare two sets of versions, where major/minor/etc. releases are separated by dots.
    //Returns 0 if both are equal, 1 if A > B, and -1 if B < A.
    private function version_compare2($a, $b)
    {
        $a = explode(".", rtrim($a, ".0")); //Split version into pieces and remove trailing .0
        $b = explode(".", rtrim($b, ".0")); //Split version into pieces and remove trailing .0
        foreach ($a as $depth => $aVal)
        { //Iterate over each piece of A
            if (isset($b[$depth]))
            { //If B matches A to this depth, compare the values
                if ($aVal > $b[$depth]) return 1; //Return A > B
                else if ($aVal < $b[$depth]) return -1; //Return B > A
                //An equal result is inconclusive at this point
            }
            else
            { //If B does not match A to this depth, then A comes after B in sort order
                return 1; //so return A > B
            }
        }
        //At this point, we know that to the depth that A and B extend to, they are equivalent.
        //Either the loop ended because A is shorter than B, or both are equal.
        return (count($a) < count($b)) ? -1 : 0;
    }
}
