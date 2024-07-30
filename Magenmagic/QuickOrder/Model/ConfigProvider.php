<?php

namespace Magenmagic\QuickOrder\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const NOTE_TEXT = 'quick_order/general/note_text';

    public const  EMAIL_TEMPLATE = 'quick_order/general/email_template';

    public const ADDITIONAL_EMAIL = 'quick_order/general/send_emails_to';

    public const EMAIL_SENDER = 'quick_order/general/sender_email_identity';

    public const ADMIN_EMAIL = 'trans_email/ident_general/email';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getNoteText(): ?string
    {
        return $this->scopeConfig->getValue(self::NOTE_TEXT, ScopeInterface::SCOPE_STORE);
    }

    public function getEmailTemplateId(): string
    {
        return $this->scopeConfig->getValue(self::EMAIL_TEMPLATE, ScopeInterface::SCOPE_STORE);
    }

    public function getSendEmailsTo(): ?string
    {
        return $this->scopeConfig->getValue(self::ADDITIONAL_EMAIL, ScopeInterface::SCOPE_STORE);
    }

    public function getEmailSender(): string
    {
        return $this->scopeConfig->getValue(self::EMAIL_SENDER, ScopeInterface::SCOPE_STORE);
    }

    public function getAdminEmail(): string
    {
        return $this->scopeConfig->getValue(self::ADMIN_EMAIL, ScopeInterface::SCOPE_STORE);
    }
}
