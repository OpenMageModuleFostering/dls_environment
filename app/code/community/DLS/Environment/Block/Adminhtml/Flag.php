<?php


class DLS_Environment_Block_Adminhtml_Flag extends Mage_Core_Block_Template
{
    protected $is_foreground_light = null;

    public function getDLSLogoSrcUrl()
    {
        return Mage::helper('dls_base/logo')->getDLSLogoURL($this->isForegroundLight());
    }

    public function isForegroundLight()
    {
        if (is_null($this->is_foreground_light))
        {
            // Get the environment config data
            $current_environment_config_data = Mage::helper('dls_environment')
                                                ->getCurrentEnvironmentData();

            if (isset($current_environment_config_data[DLS_Environment_Helper_Data::BACKGROUND_COLOR_INDEX]))
            {
                $current_background_color = $current_environment_config_data[DLS_Environment_Helper_Data::BACKGROUND_COLOR_INDEX];
                $this->is_foreground_light = Mage::helper('dls_utility/color')->isColorDark($current_background_color);
            }
            else
            {
                // Light by default
                $this->is_foreground_light = true;
            }
        }

        return $this->is_foreground_light;
    }

    public function getDLSWebsiteUrl()
    {
        return Mage::helper('dls_base')->getDLSWebsiteUrl();
    }
}
