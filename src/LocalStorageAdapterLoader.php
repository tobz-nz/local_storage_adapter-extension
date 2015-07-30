<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\FilesModule\Adapter\Contract\DiskLoaderInterface;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;

/**
 * Class LocalStorageAdapterLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension
 */
class LocalStorageAdapterLoader implements DiskLoaderInterface
{

    /**
     * The driver utility.
     *
     * @var LocalStorageAdapterDriver
     */
    protected $driver;

    /**
     * The disk mounter.
     *
     * @var LocalStorageAdapterMounter
     */
    protected $mounter;

    /**
     * The Laravel integrator.
     *
     * @var LocalStorageAdapterIntegrator
     */
    protected $integrator;

    /**
     * Create a new LocalStorageAdapterLoader instance.
     *
     * @param LocalStorageAdapterDriver     $driver
     * @param LocalStorageAdapterMounter    $mounter
     * @param LocalStorageAdapterIntegrator $integrator
     */
    function __construct(
        LocalStorageAdapterDriver $driver,
        LocalStorageAdapterMounter $mounter,
        LocalStorageAdapterIntegrator $integrator
    ) {
        $this->driver     = $driver;
        $this->mounter    = $mounter;
        $this->integrator = $integrator;
    }

    /**
     * Load the disk.
     *
     * @param DiskInterface $disk
     */
    public function load(DiskInterface $disk)
    {
        $driver = $this->driver->make($disk);

        $this->mounter->mount($disk, $driver);
        $this->integrator->integrate($disk, $driver);
    }
}
