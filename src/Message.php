<?php

namespace Gzaas;

use Doctrine\DBAL\Connection;

class Message
{
    private $conn;
    private $id;
    private $text;
    private $font;
    private $texture;
    private $hasData;

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getFont()
    {
        return $this->font;
    }

    public function setFont($font)
    {
        $this->font = $font;
    }

    public function getTexture()
    {
        return $this->texture;
    }

    public function setTexture($texture)
    {
        $this->texture = $texture;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __construct(Connection $conn, $id = null)
    {
        $this->conn    = $conn;
        $this->id      = $id;
        $this->hasData = false;

        if (!is_null($id)) {
            $data = $this->conn->fetchAll('SELECT text, font, texture FROM gzaas WHERE ID=:ID', [
                'ID' => (string)$id
            ]);

            if (count($data) > 0) {
                $this->hasData = true;
                $this->text    = $data[0]['text'];
                $this->font    = $data[0]['font'];
                $this->texture = $data[0]['texture'];
            }
        }
    }

    public function exists()
    {
        return $this->hasData;
    }

    public function persists()
    {
        $id = uniqid();

        $this->conn->insert('gzaas', [
            'id'      => $id,
            'text'    => $this->text,
            'font'    => $this->font,
            'texture' => $this->texture,
        ]);

        return $id;
    }
}