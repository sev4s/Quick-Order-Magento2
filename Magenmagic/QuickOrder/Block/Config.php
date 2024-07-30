<?php

namespace Magenmagic\QuickOrder\Block;

use Magenmagic\QuickOrder\Model\ConfigProvider;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

use Magento\Framework\Serialize\Serializer\Json;

class Config extends Template
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var Json
     */
    private $serializer;

    public function __construct(
        Context        $context,
        ConfigProvider $configProvider,
        Json           $serializer,
        array          $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configProvider = $configProvider;
        $this->serializer = $serializer;
    }

    public function getNoteText(): string
    {
        return $this->serializer->serialize($this->configProvider->getNoteText());
    }
}
