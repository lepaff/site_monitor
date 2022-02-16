<?php
namespace LEPAFF\SiteMonitor\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use LEPAFF\SiteMonitor\Service\ClientService;

class UpdateClientsCommand extends Command
{
    protected $tableClient                  = 'tx_sitemonitor_domain_model_client';
    protected $tableSite                    = 'tx_sitemonitor_domain_model_site';
    protected $tableClientSiteMM            = 'tx_sitemonitor_client_site_mm';
    protected $tableExtension               = 'tx_sitemonitor_domain_model_extension';
    protected $tableExtensionDoc            = 'tx_sitemonitor_domain_model_extensiondoc';
    protected $tableExtensionVersion        = 'tx_sitemonitor_domain_model_extensionversion';
    protected $tableExtensionDocVersionMM   = 'tx_sitemonitor_extensiondoc_extensionversion_mm';
    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setDescription('Does something!')
            ->setHelp(
                'Will process something. '
                . 'There is no possibility whatsoever due to missing configuration')
            ->setAliases([
                'sitemonitor:updateclients'
            ]);
    }

    /**
     * Executes the command for showing sys_log entries
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientService = GeneralUtility::makeInstance(ClientService::class);
        $clients = $clientService->getAllClients();

        foreach ($clients as $client) {
            $dateNow = new \DateTime();
            $dateNow->modify("-5 minutes");

            if (count($client->getSite()) > 0) {
                $dateSite = $client->getSite()[0]->getTstamp();
                if ($dateNow > $dateSite) {
                    $clientService->executeGenerate($client->getUid());

                    // DebugUtility::debug($clientProcess, 'client', 'Client');
                    return 0;
                }
            } else {
                $clientService->executeGenerate($client->getUid());

                // DebugUtility::debug($clientProcess, 'client new site', 'Client');
                return 0;
            }

        }

        return 0;
    }
}
