<?php
declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Cycle\Schema\Generator;

use Cycle\Schema\Definition\Entity;
use Cycle\Schema\Generator\Table\ColumnSchema;
use Cycle\Schema\GeneratorInterface;
use Cycle\Schema\Registry;

/**
 * Generate table columns based on entity definition.
 */
class TableGenerator implements GeneratorInterface
{
    /**
     * Generate table schema based on given entity definition.
     *
     * @param Registry $registry
     * @param Entity   $entity
     */
    public function compute(Registry $registry, Entity $entity)
    {
        if (!$registry->hasTable($entity)) {
            // do not render entities without associated table
            return;
        }

        $table = $registry->getTableSchema($entity);

        $primaryKeys = [];
        foreach ($entity->getFields() as $field) {
            $column = ColumnSchema::parse($field);

            if ($column->isPrimary()) {
                $primaryKeys[] = $field->getColumn();
            }

            $column->render($table->column($field->getColumn()));
        }

        if (count($primaryKeys)) {
            $table->setPrimaryKeys($primaryKeys);
        }
    }
}