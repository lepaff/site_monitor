<?php

namespace LEPAFF\SiteMonitor\Domain\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class ClientValidator extends AbstractValidator
{
    protected function isValid($client): void
    {
        if (empty(trim($client->getTitle()))) {
            $this->addErrorForProperty('title', $this->translateErrorMessage(
                'validator.title.empty',
                'site_monitor'
            ), 1262341470);
        }
    }
}