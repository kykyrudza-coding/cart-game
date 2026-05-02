<?php

namespace Illea\TestExerice\Classes\Input;

class KeyboardInput
{
    /** @var resource|null */
    private $process = null;

    /** @var resource|null */
    private $pipe = null;

    private ?string $tmpFile = null;

    public function __construct()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $this->initWindows();
        } else {
            system('stty -echo -icanon min 1 time 0');
        }
    }

    private function initWindows(): void
    {
        $script = implode("\r\n", [
            '$OutputEncoding = [System.Text.Encoding]::UTF8',
            '[Console]::OutputEncoding = [System.Text.Encoding]::UTF8',
            'while ($true) {',
            '    $k = [Console]::ReadKey($true)',
            '    $n = $k.Key.ToString()',
            '    [Console]::Out.WriteLine($n)',
            '    [Console]::Out.Flush()',
            '    if ($n -eq "Q") { break }',
            '}',
        ]);

        $this->tmpFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cg_' . getmypid() . '.ps1';
        file_put_contents($this->tmpFile, $script);

        $descriptors = [
            0 => ['file', 'CONIN$', 'r'],
            1 => ['pipe', 'w'],
            2 => ['file', 'CONOUT$', 'w'],
        ];

        $pipes = [];
        $this->process = proc_open(
            'powershell -NoProfile -NonInteractive -File "' . $this->tmpFile . '"',
            $descriptors,
            $pipes
        );

        if (is_resource($this->process)) {
            $this->pipe = $pipes[1];
            stream_set_read_buffer($this->pipe, 0);
        }
    }

    public function readKey(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            if (!is_resource($this->pipe)) {
                return 'QUIT';
            }
            $raw = rtrim((string) fgets($this->pipe));
            if ($raw === '') {
                return 'QUIT';
            }
            return $this->mapKey($raw);
        }

        $char = fread(STDIN, 1);
        if ($char === "\x1B") {
            $seq = fread(STDIN, 2);
            return match($seq) {
                '[A' => 'UP',
                '[B' => 'DOWN',
                '[C' => 'RIGHT',
                '[D' => 'LEFT',
                default => 'UNKNOWN',
            };
        }
        return $this->mapKey(strtoupper((string) $char));
    }

    private function mapKey(string $key): string
    {
        return match($key) {
            'UpArrow', 'W'    => 'UP',
            'DownArrow', 'S'  => 'DOWN',
            'LeftArrow', 'A'  => 'LEFT',
            'RightArrow', 'D' => 'RIGHT',
            'Q'               => 'QUIT',
            default           => strtoupper($key),
        };
    }

    public function close(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            if (is_resource($this->pipe)) {
                fclose($this->pipe);
                $this->pipe = null;
            }
            if (is_resource($this->process)) {
                proc_terminate($this->process);
                proc_close($this->process);
                $this->process = null;
            }
            if ($this->tmpFile !== null && file_exists($this->tmpFile)) {
                @unlink($this->tmpFile);
                $this->tmpFile = null;
            }
        } else {
            system('stty echo icanon');
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}
