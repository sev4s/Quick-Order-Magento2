<?php

namespace Magenmagic\QuickOrder\Controller\Index;

use Magenmagic\QuickOrder\Model\ConfigProvider;
use Magenmagic\QuickOrder\Model\QuickOrderFactory;
use Magenmagic\QuickOrder\Model\QuickOrderRepository;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Store\Model\StoreManagerInterface;

class QuickOrder implements ActionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var QuickOrderFactory
     */
    private $quickOrderFactory;

    /**
     * @var QuickOrderRepository
     */
    private $quickOrderRepository;

    public function __construct(
        RequestInterface        $request,
        TransportBuilder        $transportBuilder,
        ConfigProvider          $configProvider,
        StoreManagerInterface   $storeManager,
        ResultFactory           $resultFactory,
        MessageManagerInterface $messageManager,
        QuickOrderFactory       $quickOrderFactory,
        QuickOrderRepository    $quickOrderRepository
    )
    {
        $this->request = $request;
        $this->transportBuilder = $transportBuilder;
        $this->configProvider = $configProvider;
        $this->storeManager = $storeManager;
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
        $this->quickOrderFactory = $quickOrderFactory;
        $this->quickOrderRepository = $quickOrderRepository;
    }

    public function execute()
    {
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $storeId = (int)$this->storeManager->getStore()->getId();

        $vars = array_map('trim', $this->request->getParams());

        $templateOptions = [
            'area' => Area::AREA_FRONTEND,
            'store' => $storeId
        ];

        $addTo = [
            $this->configProvider->getAdminEmail()
        ];

        $sendEmailsTo = $this->configProvider->getSendEmailsTo();
        if ($sendEmailsTo) {
            $addTo[] = $sendEmailsTo;
        }

        $this->configProvider->getAdminEmail();

        try {
            $this->transportBuilder->setTemplateIdentifier(
                $this->configProvider->getEmailTemplateId()
            )->setTemplateOptions(
                $templateOptions
            )->setTemplateVars(
                $vars
            )->setFromByScope(
                $this->configProvider->getEmailSender()
            )->addTo(
                $addTo
            );

            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
            $response->setData(['error' => true]);

            return $response;
        }

        $quickOrder = $this->quickOrderFactory->create();
        $quickOrder->setData($vars);
        $this->quickOrderRepository->save($quickOrder);

        $this->messageManager->addSuccessMessage(__('Your quick order was successfully accepted.'));

        $response->setData(['success' => true]);

        return $response;
    }
}
