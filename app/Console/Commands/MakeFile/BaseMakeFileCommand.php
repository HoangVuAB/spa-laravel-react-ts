<?php

namespace App\Console\Commands\MakeFile;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

abstract class BaseMakeFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:-';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make command to create file';

    protected File $file;

    protected string $fileName = '';

    protected string $folder = '';

    protected string $folderPath = '';

    protected string $filePath = '';

    protected string $successMessage = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = new File();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $this->fileName = $this->getFileName();
            $this->setFolderPath();
            $this->makeDirIfNotExists();
            $this->makeFile();
        } catch (\Throwable $e) {
            $this->info($e->getMessage());
        }
    }

    protected function makeFile(): bool
    {
        return true;
    }

    public function setFolderPath(): void
    {
        $this->folderPath = app_path($this->folder);
    }

    protected function makeDirIfNotExists(): void
    {
        if (! is_dir($this->folderPath)) {
            File::makeDirectory($this->folderPath, 0755, true, true);
        }
    }

    protected function getFileName(): string
    {
        return ucfirst($this->argument('name'));
    }

    protected function generateMarkup(string $fileFullName, string $fileContent): bool
    {
        $filePath = $this->folderPath.'/'.$fileFullName;

        return $this->writeFile($filePath, $fileContent, $fileFullName);
    }

    protected function writeFile(string $filePath, string $fileContent, string $fileFullName): bool
    {
        if (File::exists($filePath)) {
            $this->error('File exists');

            return false;
        }

        $isSuccess = File::put($filePath, $fileContent) !== false;

        if ($isSuccess) {
            $this->info($this->successMessage.': '.$fileFullName);
        }

        return $isSuccess;
    }
}
