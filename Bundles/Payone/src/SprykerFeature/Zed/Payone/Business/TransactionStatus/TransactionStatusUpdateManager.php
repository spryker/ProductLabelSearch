<?php

namespace SprykerFeature\Zed\Payone\Business\TransactionStatus;


use Generated\Zed\Ide\AutoCompletion;
use SprykerFeature\Shared\Payone\Dependency\StandardParameterInterface;
use SprykerFeature\Shared\Payone\Dependency\TransactionStatusUpdateInterface;
use SprykerFeature\Zed\Payone\Business\Api\TransactionStatus\TransactionStatusRequest;
use SprykerFeature\Zed\Payone\Business\Api\TransactionStatus\TransactionStatusResponse;
use SprykerFeature\Zed\Payone\Business\Key\KeyHashInterface;
use SprykerFeature\Zed\Payone\Persistence\PayoneQueryContainerInterface;
use SprykerFeature\Zed\Payone\Persistence\Propel\SpyPaymentPayoneTransactionStatusLog;
use SprykerFeature\Zed\Payone\Persistence\Propel\SpyPaymentPayone;


class TransactionStatusUpdateManager
{

    /**
     * @var PayoneQueryContainerInterface
     */
    protected $queryContainer;
    /**
     * @var StandardParameterInterface
     */
    protected $standardParameter;
    /**
     * @var KeyHashInterface
     */
    protected $keyHashProvider;


    /**
     * @param PayoneQueryContainerInterface $queryContainer
     * @param StandardParameterInterface $standardParameter
     * @param KeyHashInterface $keyHashProvider
     */
    public function __construct(
        PayoneQueryContainerInterface $queryContainer,
        StandardParameterInterface $standardParameter,
        KeyHashInterface $keyHashProvider)
    {
        $this->queryContainer = $queryContainer;
        $this->standardParameter = $standardParameter;
        $this->keyHashProvider = $keyHashProvider;
    }

    /**
     * @param TransactionStatusUpdateInterface $request
     * @return TransactionStatusResponse
     */
    public function processTransactionStatusUpdate(TransactionStatusUpdateInterface $request)
    {
        $validationResult = $this->validate($request);
        if ($validationResult instanceof TransactionStatusResponse) {
            return $validationResult;
        }
        $this->transformCurrency($request);
        $this->persistRequest($request);

        return $this->createSuccessResponse();
    }

    /**
     * @param TransactionStatusRequest $request
     * @return void
     */
    protected function persistRequest(TransactionStatusRequest $request)
    {
        $entity = new SpyPaymentPayoneTransactionStatusLog();

        $entity->setSpyPaymentPayone($this->findPaymentByTransactionId($request->getTxid()));
        $entity->setTransactionId($request->getTxid());
        $entity->setReferenceId($request->getReference());
        $entity->setMode($request->getMode());
        $entity->setStatus($request->getTxaction());
        $entity->setTransactionTime($request->getTxtime());
        $entity->setSequenceNumber($request->getSequencenumber());
        $entity->setClearingType($request->getClearingtype());
        $entity->setPortalId($request->getPortalid());
        $entity->setBalance($request->getBalance());
        $entity->setReceivable($request->getReceivable());

        $entity->save();
    }

    /**
     * @param TransactionStatusRequest $request
     * @return void
     */
    protected function transformCurrency(TransactionStatusUpdateInterface $request)
    {
        $balance = $request->getBalance();
        $newBalance = (int)(round($balance * 100));
        $request->setBalance($newBalance);

        $receivable = $request->getReceivable();
        $newReceivable = (int)(round($receivable * 100));
        $request->setReceivable($newReceivable);
    }

    /**
     * @param TransactionStatusRequest $request
     * @return bool|TransactionStatusResponse
     */
    protected function validate(TransactionStatusUpdateInterface $request)
    {
        $systemHashedKey = $this->keyHashProvider->hashKey($this->standardParameter->getKey());
        if ($request->getKey() != $systemHashedKey) {
            return $this->createErrorResponse(false, 'Payone transaction status update: Given and internal key do not match!');
        }

        if ($request->getAid() != $this->standardParameter->getAid()) {
            return $this->createErrorResponse(false, 'Payone transaction status update: Invalid Aid! System: ' . $this->standardParameter->getAid() . ' Request: ' . $request->getAid());
        }

        if ($request->getPortalid() != $this->standardParameter->getPortalId()) {
            return $this->createErrorResponse(false, 'Payone transaction status update: Invalid Portalid! System: ' . $this->standardParameter->getPortalId() . ' Request: ' . $request->getPortalid());
        }

        return true;
    }

    /**
     * @param $errorMessage
     * @return TransactionStatusResponse
     */
    protected function createErrorResponse($errorMessage)
    {
        $response = new TransactionStatusResponse(false);
        $response->setErrorMessage($errorMessage);

        return $response;
    }

    /**
     * @return TransactionStatusResponse
     */
    protected function createSuccessResponse()
    {
        $response = new TransactionStatusResponse(true);

        return $response;
    }

    /**
     * @param string $transactionId
     * @return SpyPaymentPayone
     */
    protected function findPaymentByTransactionId($transactionId)
    {
        return $this->queryContainer->getPaymentByTransactionIdQuery($transactionId)->findOne();
    }

}