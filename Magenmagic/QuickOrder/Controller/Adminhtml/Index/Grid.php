<?php

namespace Magenmagic\QuickOrder\Controller\Adminhtml\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Grid implements ActionInterface
{
    public const MENU_ID = 'Magenmagic_QuickOrder::sales_quick';

    public const TITLE_PAGE = 'Quick Sales';

    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(PageFactory $rawFactory)
    {
        $this->pageFactory = $rawFactory;
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(self::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__(self::TITLE_PAGE));

        return $resultPage;
    }
}
