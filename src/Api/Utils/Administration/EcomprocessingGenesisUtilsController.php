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

namespace Ecomprocessing\Genesis\Api\Utils\Administration;

use Genesis\Utils\Currency;
use Psr\Container\ContainerInterface;
use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Shopware\Core\Framework\Routing\Annotation\Acl;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

if (file_exists(dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/autoload.php')) {
    $loader = require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/autoload.php';
    if ($loader !== true) {
        spl_autoload_unregister([$loader, 'loadClass']);
        $loader->register(false);
    }
}

/**
 * @RouteScope(scopes={"api"})
 */
class EcomprocessingGenesisUtilsController extends AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @OA\Get(
     *     path="/ecomprocessing-v1/genesis/utils/convert-amount-exponent/{amount}/{currency}",
     *     description="Converts the minor amount to exponent",
     *     operationId="convertAmountToExponent",
     *     tags={"Admin API", "Ecomprocessing"},
     *     @OA\Parameter(
     *         parameter="amount",
     *         name="amount",
     *         in="path",
     *         description="Amount",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         parameter="currency",
     *         name="currency",
     *         in="path",
     *         description="Currency",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Converted amount",
     *         @OA\JsonContent(type="array")
     *     )
     * )
     * @Route(
     *     "/api/v{version}/ecomprocessing-v1/genesis/utils/convert-amount-exponent/{amount}/{currency}",
     *     name="api.ecomprocessing.genesis.version-endpoint.utils.convert-currency-exponent",
     *     methods={"GET"}
     * )
     *
     * @Route(
     *     "/api/ecomprocessing-v1/genesis/utils/convert-amount-exponent/{amount}/{currency}",
     *     name="api.ecomprocessing.genesis.utils.convert-currency-exponent",
     *     methods={"GET"}
     * )
     */
    public function convertAmountToExponent(int $amount, string $currency, Context $context): JsonResponse
    {
        return new JsonResponse(
            ['amount' => Currency::exponentToAmount($amount, $currency)]
        );
    }
}