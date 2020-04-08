<?php

namespace Tests;

class MysqliTest extends \PHPUnit_Framework_TestCase
{
    private function getEnvConfig()
    {
        $config = [
            'hostname' => getenv('DB_HOSTNAME'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ];

        return array_filter($config);
    }

    public function providerConfig()
    {
        return [
            [
                'test', [
                    'type' => 'MySQLi',
                    'charset'    => 'utf8',
                    'connection' => $this->getEnvConfig() + [
                        'hostname' => 'localhost',
                        'database' => 'ohanzee',
                        'username' => 'ohanzee',
                        'password' => false,
                    ],
                ]
            ],
        ];
    }

    /**
     * @dataProvider providerConfig
     */
    public function testCanConnect($name, $config)
    {
        $db = new \Ohanzee\Database\MySQLi($name, $config);

        $this->assertEquals(null, $db->connect());
    }

    /**
     * @dataProvider providerConfig
     */
    public function testCanCreateWithInstance($name, $config)
    {
        $db = \Ohanzee\Database::instance($name, $config);

        $this->assertEquals(null, $db->connect());
    }
}
