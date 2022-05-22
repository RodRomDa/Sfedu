<?php


namespace Sfedu\ShopsManage\Plugin;

use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Integration\Model\Oauth\TokenFactory;
use Sfedu\ShopsManage\Block\ReviewList;


/**
 * Class InjectAdminToken
 *
 * Work around to use secure rest api in admin area
 */
class InjectAdminToken {

    /** @var TokenFactory */
    private $tokenFactory;

    /** @var AdminSession */
    private $adminSession;


    /**
     * InjectAdminToken constructor.
     * @param TokenFactory $tokenFactory
     * @param AdminSession $adminSession
     */
    public function __construct(
        TokenFactory $tokenFactory,
        AdminSession $adminSession
    ) {
        $this->tokenFactory = $tokenFactory;
        $this->adminSession = $adminSession;
    }

    /**
     * Inject admin token
     *
     * @param ReviewList $subject
     * @param $details
     * @return array
     */
    public function afterGetConfig(ReviewList $subject, $details): array
    {
        $details['token'] = $this->getToken();

        return $details;
    }

    /**
     * Get admin token
     *
     * @return string
     */
    private function getToken()
    {
        $token = $this->tokenFactory->create()
            ->createAdminToken($this->adminSession->getUser()->getId());

        return $token->getToken();
    }
}
