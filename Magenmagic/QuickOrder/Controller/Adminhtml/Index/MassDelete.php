<?php

namespace Magenmagic\QuickOrder\Controller\Adminhtml\Index;

use Magenmagic\QuickOrder\Model\QuickOrderRepository;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\App\Response\RedirectInterface;

class MassDelete implements ActionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var QuickOrderRepository
     */
    private $quickOrderRepository;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var RedirectInterface
     */
    private $redirect;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    public function __construct(
        RequestInterface            $request,
        QuickOrderRepository        $quickOrderRepository,
        MessageManagerInterface     $messageManager,
        RedirectInterface           $redirect,
        ResultFactory               $resultFactory
    )
    {
        $this->request = $request;
        $this->quickOrderRepository = $quickOrderRepository;
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        $ids = $this->request->getParam('selected');
        $deletedItemsCounter = 0;

        foreach ($ids as $id) {
            $this->quickOrderRepository->deleteById($id);
            $deletedItemsCounter++;
        }

        $this->messageManager->addSuccessMessage(__('A total of ' . $deletedItemsCounter . ' record(s) have been deleted'));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->redirect->getRefererUrl());

        return $resultRedirect;
    }
}
