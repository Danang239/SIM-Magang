<?php

namespace Tests\Feature;

use Tests\TestCase;

class DeploymentTest extends TestCase
{
    /**
     * Test deploy route returns 403 on wrong token.
     */
    public function test_deploy_route_returns_403_on_wrong_token(): void
    {
        $response = $this->get('/deploy-migrations-and-links/wrong-token');
        $response->assertStatus(403);
    }

    /**
     * Test deploy route runs successfully on correct token.
     */
    public function test_deploy_route_runs_successfully_on_correct_token(): void
    {
        $response = $this->get('/deploy-migrations-and-links/brmp-biogen-deploy-token-2026');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'migration',
            'storage_link',
        ]);
    }
}
