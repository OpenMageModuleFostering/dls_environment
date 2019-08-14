<?php

class DLS_Environment_Block_Adminhtml_Base extends Mage_Core_Block_Template
{
    protected $_dlsEnvironmentHelper = null;
    protected $_environment_config_data_json = null;
    protected $_current_environment_config_data_json = null;

    public function getEnvironmentConfigDataJson()
    {
        if (is_null($this->_environment_config_data_json))
        {
            $environment_config_data_array = $this->_getDlsEnvironmentHelper()->getEnvironmentConfigDataArray();
            $this->_environment_config_data_json = json_encode($environment_config_data_array);
        }

        return $this->_environment_config_data_json;
    }

    public function getCurrentEnvironmentConfigDataJson()
    {
        if (is_null($this->_current_environment_config_data_json))
        {
            $current_environment_config_data = $this->_getDlsEnvironmentHelper()->getCurrentEnvironmentData();
            $this->_current_environment_config_data_json = json_encode($current_environment_config_data);
        }

        return $this->_current_environment_config_data_json;
    }

    public function getDLSWebsiteUrl()
    {
        return $this->_getDlsEnvironmentHelper()->getDLSWebsiteUrl();
    }

    protected function _getDlsEnvironmentHelper()
    {
        if (is_null($this->_dlsEnvironmentHelper))
        {
            $this->_dlsEnvironmentHelper = Mage::helper('dls_environment');
        }

        return $this->_dlsEnvironmentHelper;
    }
}
