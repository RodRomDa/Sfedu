<?php


namespace Sfedu\ShopsManage\Plugin;

use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Integration\Model\Oauth\TokenFactory;
use Sfedu\ShopsManage\Block\ReviewList;


class InjectAdminToken {

    /** @var TokenFactory */
    private $tokenFactory;

    /** @var AdminSession */
    private $adminSession;


    public function __construct(
        TokenFactory $tokenFactory,
        AdminSession $adminSession
    ) {
        $this->tokenFactory = $tokenFactory;
        $this->adminSession = $adminSession;
    }

    public function afterGetConfig(ReviewList $subject, $details): array
    {
        $details['token'] = $this->getToken();

        return $details;
    }

    private function getToken()
    {
        $token = $this->tokenFactory->create()
            ->createAdminToken($this->adminSession->getUser()->getId());

        return $token->getToken();
    }
}
