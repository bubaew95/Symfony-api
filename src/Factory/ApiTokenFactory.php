<?php

namespace App\Factory;

use App\Entity\ApiToken;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ApiToken>
 */
final class ApiTokenFactory extends PersistentProxyObjectFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return ApiToken::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'scopes' => [ApiToken::SCOPE_TREASURE_CREATE, ApiToken::SCOPE_USER_EDIT],
            'userBy' => UserFactory::new(),
        ];
    }

    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(ApiToken $apiToken): void {})
        ;
    }
}
