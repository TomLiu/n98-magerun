<?php

namespace N98\Magento\Command\System\Store\Config;

use N98\Magento\Command\AbstractMagentoCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BaseUrlListCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
        $this
            ->setName('sys:store:config:base-url:list')
            ->setDescription('Lists all base urls');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output, true);

        $this->writeSection($output, 'Magento Stores - Base URLs');
        $this->initMagento();

        foreach (\Mage::app()->getStores() as $store) {
            $table[$store->getId()] = array(
                $store->getId(),
                $store->getCode(),
                \Mage::getStoreConfig('web/unsecure/base_url', $store),
                \Mage::getStoreConfig('web/secure/base_url', $store),
            );
        }

        ksort($table);
        $this->getHelper('table')
            ->setHeaders(array('id', 'code', 'unsecure_baseurl', 'secure_baseurl'))
            ->setRows($table)
            ->render($output);
    }
}
