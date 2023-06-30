<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Twig\Cache;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

/**
 * class CacheNode.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CacheNode extends Node
{
    private static int $cacheCount = 1;

    public function __construct(AbstractExpression $key, Node $body, int $lineno, string $tag = null)
    {
        parent::__construct([
            'key' => $key,
            'body' => $body,
        ], [], $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Compiler $compiler): void
    {
        $i = self::$cacheCount++;
        $extension = TwigCacheExtension::class;
        $templateParam = "\"{$this->getTemplateName()}\", ";
        $compiler
            ->addDebugInfo($this)
            ->write("\$twigCacheExtension = \$this->env->getExtension('{$extension}');\n")
            ->write("\$twigCacheBody{$i} = \$twigCacheExtension->getCacheValue(${templateParam}")
            ->subcompile($this->getNode('key'))
            ->raw(");\n")
            ->write("if (\$twigCacheBody{$i} !== null) { echo \$twigCacheBody{$i}; } else {\n")
            ->indent()
            ->write("ob_start();\n")
            ->subcompile($this->getNode('body'))
            ->write("\$twigCacheBody{$i} = ob_get_clean();\n")
            ->write("\$twigCacheExtension->setCacheValue(${templateParam}")
            ->subcompile($this->getNode('key'))
            ->raw(',')
            ->raw("\$twigCacheBody{$i});\n")
            ->write("echo \$twigCacheBody{$i};\n")
            ->outdent()
            ->write("}\n");
    }
}
