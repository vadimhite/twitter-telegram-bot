<?php

namespace App\Controller\Twitter;

use App\Service\Twitter\Twitter;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthorizationController.
 */
class AuthorizationController extends AbstractController
{
    /**
     * @var Twitter Twitter service
     */
    private Twitter $twitter;

    /**
     * @param Twitter $twitter
     */
    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @Route("/twitter/authorization/url", name="twitter_authorization_url", methods={"GET"})
     *
     * @OA\Tag(name="Twitter")
     * @OA\Response(
     *     response=200,
     *     description="Twitter authorization url",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="url", type="string", example="http://example.com"),
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function getAuthorizationUrl(): JsonResponse
    {
        $scope = [
            'tweet.read',
            'tweet.write',
            'users.read',
            'offline.access',
        ];
        $url = $this->twitter->getOAuth2Client()->getAuthorizationUrl($scope);
        $response = $this->json(['url' => $url], Response::HTTP_OK);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);

        return $response;
    }
}
