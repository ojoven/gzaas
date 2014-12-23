<?php

use Doctrine\DBAL\DriverManager;
use Gzaas\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    private $conn;

    public function setUp()
    {
        $this->conn = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'memory' => true
        ]);
        $this->initDatabase();
    }

    public function testGetMessageData()
    {
        $message = new Message($this->conn, '111');

        $this->assertEquals('111', $message->getId());
        $this->assertEquals('Hola', $message->getText());
        $this->assertEquals('font1', $message->getFont());
        $this->assertEquals('texture1', $message->getTexture());
    }

    public function testCreateMessage()
    {
        $message = new Message($this->conn);
        $message->setText("Test Message");
        $message->setFont("font2");
        $message->setTexture("texture2");
        $this->assertEquals(null, $message->getId());

        $id = $message->persists();

        $message = new Message($this->conn, $id);

        $this->assertEquals($id, $message->getId());
        $this->assertEquals('Test Message', $message->getText());
        $this->assertEquals('font2', $message->getFont());
        $this->assertEquals('texture2', $message->getTexture());
    }

    private function initDatabase()
    {
        $this->conn->exec('
          CREATE TABLE gzaas (
            id VARCHAR PRIMARY KEY  NOT NULL,
            text VARCHAR,
            font VARCHAR,
            texture VARCHAR
            )');

        $this->conn->exec("
          INSERT INTO gzaas(id, text, font, texture)
          VALUES('111','Hola','font1', 'texture1')");
    }
}