<?php

namespace App\Console\Commands\MakeFile;

class MakeService extends BaseMakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Service';

    protected string $folder = 'Services';

    protected string $successMessage = 'Create service success';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function makeFile(): bool
    {
        return $this->generateService();
    }

    protected function generateService(): bool
    {
        $fileFullName = "{$this->fileName}Service.php";
        $fileContent = "<?php\n\nnamespace App\Services;\n\nuse App\Repositories\\{$this->fileName}\\{$this->fileName}Repository;\n\nclass {$this->fileName}Service\n{\n\tpublic function __construct()\n\t{\n\t}\n}\n";

        return $this->generateMarkup($fileFullName, $fileContent);
    }
}
