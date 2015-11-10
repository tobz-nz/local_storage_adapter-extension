<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\FilesModule\Disk\Adapter\Contract\AdapterInterface;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use Anomaly\LocalStorageAdapterExtension\Command\LoadDisk;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class LocalStorageAdapterExtension
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension
 */
class LocalStorageAdapterExtension extends Extension implements AdapterInterface
{

    use DispatchesJobs;

    /**
     * This module provides the local
     * storage adapter for the files module.
     *
     * @var string
     */
    protected $provides = 'anomaly.module.files::adapter.local';

    /**
     * Load the disk.
     *
     * @param DiskInterface $disk
     */
    public function load(DiskInterface $disk)
    {
        $this->dispatch(new LoadDisk($disk));
    }

    /**
     * Validate adapter configuration.
     *
     * @param array $configuration
     * @return bool
     */
    public function validate(array $configuration)
    {
        return true;
    }
}
