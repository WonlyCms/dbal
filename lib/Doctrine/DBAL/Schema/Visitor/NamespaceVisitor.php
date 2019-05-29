<?php

declare(strict_types=1);

namespace Doctrine\DBAL\Schema\Visitor;

/**
 * Visitor that can visit schema namespaces.
 */
interface NamespaceVisitor
{
    /**
     * Accepts a schema namespace name.
     *
     * @param string $namespaceName The schema namespace name to accept.
     */
    public function acceptNamespace(string $namespaceName) : void;
}
