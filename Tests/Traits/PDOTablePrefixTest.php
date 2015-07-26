<?php
/**
 * \file PDOTablePrefixTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 17/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Traits;

use Spark\FrameworkBundle\Traits\PDOTablePrefix;

/**
 * Class PDOTablePrefixTest
 *
 * @package Spark\FrameworkBundle\Tests\Traits
 */
class PDOTablePrefixTest extends \PHPUnit_Framework_TestCase
{
    use PDOTablePrefix;

    /**
     * Test trait for PDO table prefix
     */
    public function testTrait()
    {
        $this->tablePrefix = 'test_';

        $this->assertEquals('test_user', $this->getTableName('user'));

        $this->tablePrefix = null;

        $this->assertEquals('user', $this->getTableName('user'));
    }
}
