<?php


/**
 * Class pz_baseManager
 */
class pz_baseManager
{
    /**
     * @var
     */
    private $path;

    /**
     * @var
     */
    private $_I18N;

    /**
     * @var
     */
    private $addon;

    /**
     * pz_rex_baseManager constructor.
     */
    public function __construct($addon, $path, $I18N)
    {
        $this->addon = $addon;
        $this->path = $path;
        $this->_I18N = $I18N;
    }

    /**
     * @return string
     */
    public function update()
    {
        if (true === $this->isAvailable() && file_exists($this->path.'update.inc.php')) {
            try {
                require $this->path.'update.inc.php';
            } catch (rex_install_functional_exception $e) {
                return $e->getMessage();
            }

            if (($msg = OOAddon::getProperty($this->addon, 'updatemsg', '')) != '') {
                return $msg;
            }

            if (!OOAddon::getProperty($this->addon, 'update', true)) {
                return $this->_I18N->msg('package_no_reason');
            }
        }

        return $this->isUpdated();
    }

    /**
     * @return bool
     */
    private function isAvailable()
    {
        return (bool) OOAddon::isAvailable($this->addon);
    }

    /**
     * @return string
     */
    private function isUpdated()
    {
        return OOAddon::getProperty($this->addon, 'update', true);
    }
}
