<?php
declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Cycle\Schema\Tests\Visitor;

use Cycle\Schema\Registry;
use Cycle\Schema\Tests\BaseTest;
use Cycle\Schema\Tests\Fixtures\Dummy;
use Cycle\Schema\Processor\RenderTable;

abstract class RenderTableTest extends BaseTest
{
    public function testRenderTable()
    {
        $e = Dummy::makeEntity();

        $builder = new Registry($this->dbal);
        $builder->register($e)->linkTable($e, 'default', 'dummy')->compute(new RenderTable());

        $table = $builder->getTable($e);

        $this->assertSame('dummy', $table->getName());
        $this->assertSame(['id'], $table->getPrimaryKeys());
        $this->assertTrue($table->hasColumn('id'));
        $this->assertSame('primary', $table->column('id')->getAbstractType());
    }
}