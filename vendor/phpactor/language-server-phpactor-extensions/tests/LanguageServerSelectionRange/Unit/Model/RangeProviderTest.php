<?php

namespace Phpactor\Extension\LanguageServer\Tests\electionRange\Unit\Model;

use Generator;
use Microsoft\PhpParser\Parser;
use PHPUnit\Framework\TestCase;
use Phpactor\Extension\LanguageServerSelectionRange\Model\RangeProvider;
use Phpactor\TestUtils\ExtractOffset;
use Phpactor\TextDocument\ByteOffset;

class RangeProviderTest extends TestCase
{
    /**
     * @dataProvider provideRangeSelection
     */
    public function testRangeSelection(string $source, int $expectedCount): void
    {
        $parts = ExtractOffset::fromSource($source);
        $source = array_shift($parts);
        $offsets = array_filter(array_map(function (?int $offset) {
            if (null === $offset) {
                return false;
            }
            return ByteOffset::fromInt($offset);
        }, $parts));

        $provider = new RangeProvider(new Parser());
        $result = $provider->provide($source, $offsets);
        self::assertCount($expectedCount, $result);
    }

    /**
     * @return Generator<mixed>
     */
    public function provideRangeSelection(): Generator
    {
        yield [
            '<?php class Fo<>obar {}',
            1
        ];

        yield [
            '<?php <>class Fo<>obar {}',
            2
        ];
    }
}
