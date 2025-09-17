<?php

namespace App\Tests\Service;

use App\Service\SecurityService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityServiceTest extends TestCase
{
    public function testGetLoginDataReturnsCorrectArray(): void
    {
        $authenticationException = new AuthenticationException('Some error');

        $authenticationUtils = $this->createMock(AuthenticationUtils::class);
        $authenticationUtils->method('getLastUsername')->willReturn('testuser');
        $authenticationUtils->method('getLastAuthenticationError')->willReturn($authenticationException);

        $service = new SecurityService();
        $result = $service->getLoginData($authenticationUtils);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('last_username', $result);
        $this->assertArrayHasKey('error', $result);
        $this->assertSame('testuser', $result['last_username']);
        $this->assertSame($authenticationException, $result['error']);
    }
}
