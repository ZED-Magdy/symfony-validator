<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Validator;

use Symfony\Component\Validator\Context\ExecutionContextManagerInterface;
use Symfony\Component\Validator\NodeTraverser\NodeTraverserInterface;
use Symfony\Component\Validator\MetadataFactoryInterface;

/**
 * @since  %%NextVersion%%
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class Validator extends AbstractValidator
{
    /**
     * @var ExecutionContextManagerInterface
     */
    private $contextManager;

    public function __construct(NodeTraverserInterface $nodeTraverser, MetadataFactoryInterface $metadataFactory, ExecutionContextManagerInterface $contextManager)
    {
        parent::__construct($nodeTraverser, $metadataFactory);

        $this->contextManager = $contextManager;
    }

    public function validateObject($object, $groups = null)
    {
        $this->contextManager->startContext();

        $this->traverseObject($object, $groups);

        return $this->contextManager->stopContext()->getViolations();
    }

    public function validateProperty($object, $propertyName, $groups = null)
    {
        $this->contextManager->startContext();

        $this->traverseProperty($object, $propertyName, $groups);

        return $this->contextManager->stopContext()->getViolations();
    }

    public function validatePropertyValue($object, $propertyName, $value, $groups = null)
    {
        $this->contextManager->startContext();

        $this->traversePropertyValue($object, $propertyName, $value, $groups);

        return $this->contextManager->stopContext()->getViolations();
    }

    public function validateValue($value, $constraints, $groups = null)
    {
        $this->contextManager->startContext();

        $this->traverseValue($value, $constraints, $groups);

        return $this->contextManager->stopContext()->getViolations();
    }

}