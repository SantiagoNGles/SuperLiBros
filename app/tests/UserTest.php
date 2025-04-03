<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/models/User.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $mockPdo;
    private $mockStmt;
    private $user;

    protected function setUp(): void
    {
        // Création d'un mock pour PDOStatement
        $this->mockStmt = $this->createMock(PDOStatement::class);

        // Création d'un mock pour PDO
        $this->mockPdo = $this->createMock(PDO::class);
        $this->mockPdo->method('prepare')->willReturn($this->mockStmt);

        // Instanciation de User avec le mock PDO
        $this->user = new User($this->mockPdo);
        $this->user->setConnection($this->mockPdo);
    }

    public function testGetUserByIdReturnsUser()
    {
        // Simuler les données retournées par la requête
        $expectedUser = ['id' => 1, 'username' => 'testUser', 'email' => 'test@example.com'];

        // Configurer le mock pour fetch()
        $this->mockStmt->method('fetch')->willReturn($expectedUser);

        // Exécuter le test
        $result = $this->user->getUserById(1);

        // Vérifier que le résultat est bien ce qu'on attend
        $this->assertEquals($expectedUser, $result);
    }

    public function testGetUserByIdReturnsFalseWhenNotFound()
    {
        // Simuler un utilisateur non trouvé
        $this->mockStmt->method('fetch')->willReturn(false);

        // Exécuter le test
        $result = $this->user->getUserById(999);

        // Vérifier que le retour est false
        $this->assertFalse($result);
    }
}
