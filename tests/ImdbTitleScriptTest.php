<?php

declare(strict_types=1);

namespace Martinandrasi\Hugmarket\Tests;

use PHPUnit\Framework\TestCase;

final class ImdbTitleScriptTest extends TestCase
{
    private string $binDir;

    protected function setUp(): void
    {
        $this->binDir = sys_get_temp_dir() . '/hugmarket-bin-' . bin2hex(random_bytes(6));
        mkdir($this->binDir);
    }

    protected function tearDown(): void
    {
        if (is_file($this->binDir . '/curl')) {
            unlink($this->binDir . '/curl');
        }

        if (is_dir($this->binDir)) {
            rmdir($this->binDir);
        }
    }

    public function testItRequiresAnOmdbApiKey(): void
    {
        $this->fakeCurlResponse('{"Title":"Titanic","Response":"True"}');

        $result = $this->runScript(['PATH' => $this->binDir . ':' . getenv('PATH')]);

        self::assertSame(1, $result['exitCode']);
        self::assertSame("OMDB_API_KEY is required\n", $result['stderr']);
        self::assertSame('', $result['stdout']);
    }

    public function testItPrintsTheMovieTitle(): void
    {
        $this->fakeCurlResponse('{"Title":"Titanic","Response":"True"}');

        $result = $this->runScript([
            'OMDB_API_KEY' => 'test-key',
            'PATH' => $this->binDir . ':' . getenv('PATH'),
        ]);

        self::assertSame(0, $result['exitCode']);
        self::assertSame("Titanic\n", $result['stdout']);
        self::assertSame('', $result['stderr']);
    }

    public function testItReportsMissingMovieTitles(): void
    {
        $this->fakeCurlResponse('{"Response":"False","Error":"Movie not found!"}');

        $result = $this->runScript([
            'OMDB_API_KEY' => 'test-key',
            'PATH' => $this->binDir . ':' . getenv('PATH'),
        ]);

        self::assertSame(1, $result['exitCode']);
        self::assertSame("Movie title not found\n", $result['stderr']);
        self::assertSame('', $result['stdout']);
    }

    /**
     * @param array<string, string> $environment
     *
     * @return array{exitCode: int, stdout: string, stderr: string}
     */
    private function runScript(array $environment): array
    {
        $process = proc_open(
            'sh bin/imdb-title.sh tt0120338',
            [
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ],
            $pipes,
            dirname(__DIR__),
            $environment,
        );

        self::assertIsResource($process);

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        return [
            'exitCode' => $exitCode,
            'stdout' => $stdout,
            'stderr' => $stderr,
        ];
    }

    private function fakeCurlResponse(string $response): void
    {
        file_put_contents(
            $this->binDir . '/curl',
            "#!/bin/sh\nprintf '%s\n' " . escapeshellarg($response) . "\n",
        );
        chmod($this->binDir . '/curl', 0755);
    }
}
