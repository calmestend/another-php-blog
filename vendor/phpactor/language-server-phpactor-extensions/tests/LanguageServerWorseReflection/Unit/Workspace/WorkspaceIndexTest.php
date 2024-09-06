<?php

namespace Phpactor\Extension\LanguageServerWorseReflection\Tests\Unit\Workspace;

use PHPUnit\Framework\TestCase;
use Phpactor\Extension\LanguageServerWorseReflection\Workspace\WorkspaceIndex;
use Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor\WorseReflection\Core\Name;
use Phpactor\WorseReflection\ReflectorBuilder;

class WorkspaceIndexTest extends TestCase
{
    /**
     * @var WorkspaceIndex
     */
    private $index;

    protected function setUp(): void
    {
        $reflector = ReflectorBuilder::create()->build();
        $this->index = new WorkspaceIndex($reflector, 0);
    }

    public function testIndexesClassesAndReturnsTextDocuments(): void
    {
        $document1 = TextDocumentBuilder::create('<?php namespace Test {class Foobar {}}')->uri('/test/Foobar')->build();
        $document2 = TextDocumentBuilder::create('<?php class Barfoo {}')->uri('/test/Barfoo')->build();

        $this->index->index($document1);
        $this->index->index($document2);

        self::assertSame($document1, $this->index->documentForName(Name::fromString('Test\Foobar')));
        self::assertSame($document2, $this->index->documentForName(Name::fromString('Barfoo')));
        self::assertNull($this->index->documentForName(Name::fromString('Zarbar')));
    }

    public function testIndexesFunctionsAndReturnsTextDocuments(): void
    {
        $document1 = TextDocumentBuilder::create('<?php namespace Test {function barbar() {}}')->uri('/Test/funcs')->build();
        $document2 = TextDocumentBuilder::create('<?php function barfoo{}')->uri('/globals')->build();

        $this->index->index($document1);
        $this->index->index($document2);

        self::assertSame($document1, $this->index->documentForName(Name::fromString('Test\barbar')));
        self::assertSame($document2, $this->index->documentForName(Name::fromString('barfoo')));
    }

    public function testUpdatesExistingTextDocument(): void
    {
        $document1 = TextDocumentBuilder::create('<?php namespace Test {class Foobar {}}')->uri('/test/foobar')->build();

        $this->index->index($document1);

        $updatedText = '<?php namespace Test {class Foobar {prot}}';

        $this->index->update($document1->uri(), $updatedText);

        self::assertSame($updatedText, $this->index->documentForName(Name::fromString('Test\Foobar'))->__toString());
    }

    public function testUpdateExistingEmptyDocument(): void
    {
        $document1 = TextDocumentBuilder::create('<?php')->uri('/test/foobar')->build();
        $this->index->index($document1);

        $updatedText = '<?php namespace Test {class Foobar {} function foofunc{}}';
        $this->index->update($document1->uri(), $updatedText);

        self::assertSame($updatedText, $this->index->documentForName(Name::fromString('Test\Foobar'))->__toString());
        self::assertSame($updatedText, $this->index->documentForName(Name::fromString('Test\foofunc'))->__toString());

        $updatedText = '<?php namespace Test2 {class Foobar {} function foofunc{}}';
        $this->index->update($document1->uri(), $updatedText);

        self::assertSame($updatedText, $this->index->documentForName(Name::fromString('Test2\Foobar'))->__toString());
        self::assertSame($updatedText, $this->index->documentForName(Name::fromString('Test2\foofunc'))->__toString());
        self::assertNull($this->index->documentForName(Name::fromString('Test\Foobar')));
        self::assertNull($this->index->documentForName(Name::fromString('Test\foofunc')));
    }

    public function testRemovesTextDocument(): void
    {
        $document1 = TextDocumentBuilder::create('<?php namespace Test {class Foobar {}}')->uri('/test/foobar')->build();

        $this->index->index($document1);

        self::assertNotNull($this->index->documentForName(Name::fromString('Test\Foobar'))->__toString());

        $this->index->remove($document1->uri());

        self::assertNull($this->index->documentForName(Name::fromString('Test\Foobar')));
    }
}
