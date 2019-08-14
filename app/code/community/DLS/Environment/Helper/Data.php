<?php

class DLS_Environment_Helper_Data extends Mage_Core_Helper_Data
{
    const DLS_ENVIRONMENT_CONFIG_PATH = 'environment_flag/environment_settings';

    const LOCAL_CODE = 'local';
    const DEV_CODE = 'dev';
    const STAGE_CODE = 'stage';
    const LIVE_CODE = 'live';
    const DEFAULT_CODE = 'other';
    const BACKGROUND_COLOR_INDEX = 'background_color';

    protected $_base_urls_to_check = array();

    protected $_environment_config_data = null;
    protected $_environment_subdomain = null;
    protected $_current_environment_data = null;
    protected $_default_environment_data = null;

    public function __construct()
    {
        $this->_base_urls_to_check = array(
            self::LOCAL_CODE => self::LOCAL_CODE . '_base_url',
            self::DEV_CODE => self::DEV_CODE . '_base_url',
            self::STAGE_CODE => self::STAGE_CODE . '_base_url',
            self::LIVE_CODE => self::LIVE_CODE . '_base_url',
        );

        $this->_default_environment_data = array(
            'name' => 'other',
            self::BACKGROUND_COLOR_INDEX => '#4E3E07',
            'color' => '#ffffff',
        );
    }

    public function getCurrentEnvironmentData()
    {
        if (is_null($this->_current_environment_data))
        {
            $matched_environment_code = $this->matchCurrentBaseUrlToEnvironment();
            $environment_config_data = $this->getEnvironmentConfigDataArray();

            if (isset($environment_config_data[$matched_environment_code]))
            {
                $this->_current_environment_data = $environment_config_data[$matched_environment_code];
            }
            else
            {
                $this->_current_environment_data = $this->_default_environment_data;
            }
        }

        return $this->_current_environment_data;
    }

    public function matchCurrentBaseUrlToEnvironment()
    {
        $base_url = $this->getAdminBaseUrl();
        $base_urls_to_match_against = $this->getBaseUrlsToMatchAgainst();

        foreach ($base_urls_to_match_against as $environment_code => $base_url_to_check)
        {
            if (!strcmp($base_url, $base_url_to_check))
            {
                return $environment_code;
            }
        }

        return self::DEFAULT_CODE;
    }

    public function getAdminBaseUrl()
    {
        $urlModel = Mage::getModel('core/url');
        $is_admin_url_secure = $urlModel->getSecure();
        $url_params = array('_secure' => $is_admin_url_secure,
                            '_type' => Mage_Core_Model_Store::URL_TYPE_WEB,
                            '_store' => Mage_Core_Model_Store::ADMIN_CODE);

        $admin_base_url = $urlModel->getBaseUrl($url_params);
        return $admin_base_url;
    }

    /**
     * This is currently implemented to keep performance in mind, not keeping in mind the future possibility
     * of allowing dynamic declaration of environments by the user
     *
     */
    public function getBaseUrlsToMatchAgainst()
    {
        $base_urls_to_match_against = array();
        $environment_config_data = $this->getEnvironmentConfigDataArray();
        foreach ($this->_base_urls_to_check as $environment_code => $base_url_to_check)
        {
            // Be overly cautious, make sure the config value is set
            if (isset($environment_config_data[$base_url_to_check]))
            {
                $base_url_to_check_value = $environment_config_data[$base_url_to_check];
                $base_urls_to_match_against[$environment_code] = $base_url_to_check_value;
            }
        }

        return $base_urls_to_match_against;
    }

    public function getEnvironmentConfigDataArray()
    {
        if (is_null($this->_environment_config_data))
        {
            $environment_config_data = Mage::getStoreConfig(self::DLS_ENVIRONMENT_CONFIG_PATH);
            $this->_environment_config_data = $environment_config_data;
        }

        return $this->_environment_config_data;
    }

    /**
     * Returned the value before the first . in the Mage:getBaseUrl() domain
     *
     * This method is no longer in use
     *
     * @return mixed|null|string
     */
    public function getCurrentEnvironmentSubdomain()
    {
        if (is_null($this->_environment_subdomain))
        {
            $url = Mage::getBaseUrl();
            $split_on_slash = explode('/', $url);
            if (!is_array($split_on_slash) || !isset($split_on_slash[2]))
            {
                $this->_environment_subdomain = self::DEFAULT_CODE;
                return $this->_environment_subdomain;
            }

            $domain = $split_on_slash[2];
            $split_on_dot = explode('.', $domain);

            if (!is_array($split_on_slash) || (count($split_on_dot) < 1))
            {
                $this->_environment_subdomain = self::DEFAULT_CODE;
                return $this->_environment_subdomain;
            }

            $this->_environment_subdomain = reset($split_on_dot);
        }
    
        return $this->_environment_subdomain;
    }
}
