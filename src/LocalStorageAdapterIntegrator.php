<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\FilesModule\Adapter\AdapterFilesystem;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use Illuminate\Filesystem\FilesystemManager;

/**
 * Class LocalStorageAdapterIntegrator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension
 */
class LocalStorageAdapterIntegrator
{

    /**
     * The filesystem manager.
     *
     * @var FilesystemManager
     */
    protected $manager;

    /**
     * Create a new LocalStorageAdapterIntegrator instance.
     *
     * @param FilesystemManager $manager
     */
    function __construct(FilesystemManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Integrate the disk with Laravel.
     *
     * @param DiskInterface     $disk
     * @param AdapterFilesystem $driver
     */
    public function integrate(DiskInterface $disk, AdapterFilesystem $driver)
    {
        $this->manager->extend(
            $disk->getSlug(),
            function () use ($driver) {
                return $driver;
            }
        );
    }
}
