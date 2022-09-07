<?php declare(strict_types=1);
/*
 * Copyright (C) 2021 E-Comprocessing Ltd.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author      E-Comprocessing
 * @copyright   2021 E-Comprocessing Ltd.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2 (GPL-2.0)
 */

namespace Ecomprocessing\Genesis\Api\Reference\Administration;

use Ecomprocessing\Genesis\Service\Payment\Checkout;
use Ecomprocessing\Genesis\Utils\ReferenceTransactions;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Shopware\Core\Framework\Routing\Annotation\Acl;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class EcomprocessingGenesisTransactionController extends AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ReferenceTransactions
     */
    private $referenceUtilsService;

    /**
     * @var Checkout
     */
    private $checkoutService;

    public function __construct(
        ContainerInterface $container,
        LoggerInterface $logger,
        ReferenceTransactions $referenceService,
        Checkout $checkoutService
    ) {
        $this->container = $container;
        $this->logger = $logger;
        $this->referenceUtilsService = $referenceService;
        $this->checkoutService = $checkoutService;
    }

    /**
     * @Route(
     *     "/api/v{version}/ecomprocessing-v1/genesis/transaction/payment-reference-details",
     *     name="api.ecomprocessing.genesis.version-endpoint.transaction.payment-reference-details",
     *     methods={"POST"}
     * )
     *
     * @Route(
     *     "/api/ecomprocessing-v1/genesis/transaction/payment-reference-details",
     *     name="api.ecomprocessing.genesis.transaction.payment-reference-details",
     *     methods={"POST"}
     * )
     */
    public function buildReferenceDetails(Request $request, Context $context): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->referenceUtilsService->getReferenceDetails(
                    $request->request->get('orderId'),
                    $request->request->get('uniqueId')
                )
            );
        } catch (\Exception $error) {
            $this->logger->error($error->getMessage(), $error->getTrace());

            return new JsonResponse(
                $this->referenceUtilsService->getDefaultOutputData()
            );
        }
    }

    /**
     * @Route(
     *     "/api/v{version}/_action/ecomprocessing-v1/genesis/transaction/capture",
     *     name="api.ecomprocessing.genesis.version-endpoint.transaction.capture",
     *     methods={"POST"}
     * )
     *
     * @Route(
     *     "/api/_action/ecomprocessing-v1/genesis/transaction/capture",
     *     name="api.ecomprocessing.genesis.transaction.capture",
     *     methods={"POST"}
     * )
     */
    public function doCapture(Request $request, Context $context): JsonResponse
    {
        try {
            $transaction = $this->referenceUtilsService->loadInitialTransaction($request->request->get('uniqueId'));

            $this->checkoutService->prepareSdkReferenceTransactionRequest(
                ReferenceTransactions::ACTION_CAPTURE,
                $transaction->getTransactionType(),
                $transaction->getTerminalToken()
            )->setReferenceRequestProperties($transaction, $request->getClientIp(), 'capture');
            $response = $this->checkoutService->executeReferenceRequest();

            $this->checkoutService->updateCapturePaymentState(
                $transaction,
                ReferenceTransactions::ACTION_CAPTURE,
                $response,
                $context
            );

            return new JsonResponse([
                'status' => 'success',
                'response' => $response
            ]);
        } catch (\Exception $error) {
            return new JsonResponse(
                [
                    'status' => "error",
                    'message' => $error->getMessage()
                ]
            );
        }
    }

    /**
     * @Route(
     *     "/api/v{version}/_action/ecomprocessing-v1/genesis/transaction/refund",
     *     name="api.ecomprocessing.genesis.version-endpoint.transaction.refund",
     *     methods={"POST"}
     * )
     *
     * @Route(
     *     "/api/_action/ecomprocessing-v1/genesis/transaction/refund",
     *     name="api.ecomprocessing.genesis.transaction.refund",
     *     methods={"POST"}
     * )
     */
    public function doRefund(Request $request, Context $context): JsonResponse
    {
        try {
            $transaction = $this->referenceUtilsService->loadInitialTransaction($request->request->get('uniqueId'));

            $this->checkoutService->prepareSdkReferenceTransactionRequest(
                ReferenceTransactions::ACTION_REFUND,
                $transaction->getTransactionType(),
                $transaction->getTerminalToken()
            )->setReferenceRequestProperties($transaction, $request->getClientIp(), 'refund');
            $response = $this->checkoutService->executeReferenceRequest();

            $this->checkoutService->updateCapturePaymentState(
                $transaction,
                ReferenceTransactions::ACTION_REFUND,
                $response,
                $context
            );

            return new JsonResponse([
                'status' => 'success',
                'response' => $response
            ]);
        } catch (\Exception $error) {
            return new JsonResponse(
                [
                    'status' => "error",
                    'message' => $error->getMessage()
                ]
            );
        }
    }

    /**
     * @Route(
     *     "/api/v{version}/_action/ecomprocessing-v1/genesis/transaction/void",
     *     name="api.ecomprocessing.genesis.version-endpoint.transaction.void",
     *     methods={"POST"}
     * )
     *
     * @Route(
     *     "/api/_action/ecomprocessing-v1/genesis/transaction/void",
     *     name="api.ecomprocessing.genesis.transaction.void",
     *     methods={"POST"}
     * )
     */
    public function doVoid(Request $request, Context $context): JsonResponse
    {
        try {
            $transaction = $this->referenceUtilsService->loadInitialTransaction($request->request->get('uniqueId'));

            $this->checkoutService->prepareSdkReferenceTransactionRequest(
                ReferenceTransactions::ACTION_VOID,
                $transaction->getTransactionType(),
                $transaction->getTerminalToken()
            )->setReferenceRequestProperties($transaction, $request->getClientIp(), 'void');
            $response = $this->checkoutService->executeReferenceRequest();

            $this->checkoutService->updateCapturePaymentState(
                $transaction,
                ReferenceTransactions::ACTION_VOID,
                $response,
                $context
            );

            return new JsonResponse([
                'status' => 'success',
                'response' => $response
            ]);
        } catch (\Exception $error) {
            return new JsonResponse(
                [
                    'status' => "error",
                    'message' => $error->getMessage()
                ]
            );
        }
    }
}
