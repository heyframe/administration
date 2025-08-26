<?php declare(strict_types=1);

namespace HeyFrame\Administration\Controller;

use HeyFrame\Administration\Framework\Routing\AdministrationRouteScope;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\Tag\Service\FilterTagIdsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [AdministrationRouteScope::ID]])]
#[Package('framework')]
class AdminTagController extends AbstractController
{
    /**
     * @internal
     */
    public function __construct(private readonly FilterTagIdsService $filterTagIdsService)
    {
    }

    #[Route(path: '/api/_admin/tag-filter-ids', name: 'api.admin.tag-filter-ids', defaults: ['_acl' => ['tag:read'], '_entity' => 'tag'], methods: ['POST'])]
    public function filterIds(Request $request, Criteria $criteria, Context $context): JsonResponse
    {
        $filteredTagIdsStruct = $this->filterTagIdsService->filterIds($request, $criteria, $context);

        return new JsonResponse([
            'total' => $filteredTagIdsStruct->getTotal(),
            'ids' => $filteredTagIdsStruct->getIds(),
        ]);
    }
}
