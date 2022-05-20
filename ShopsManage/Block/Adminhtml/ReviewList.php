<?php


namespace Sfedu\ShopsManage\Block\Adminhtml;


class ReviewList extends \Sfedu\ShopsManage\Block\ReviewList
{
    /**
     * Get config data
     *
     * @return array
     */
    public function getConfig()
    {
        $config = parent::getConfig();
        $config['approveUrl'] = $this->getBaseUrl() . $this->getApproveUrl();

        return $config;
    }
}
