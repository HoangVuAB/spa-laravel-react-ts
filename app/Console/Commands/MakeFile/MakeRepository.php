<?php

namespace App\Console\Commands\MakeFile;

class MakeRepository extends BaseMakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make repository';

    protected string $fileName = '';

    protected string $folder = 'Repositories';

    protected string $successMessage = 'Create repository success';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function setFolderPath(): void
    {
        $this->folderPath = app_path($this->folder).'/'.$this->fileName;
    }

    protected function makeFile(): bool
    {
        return $this->generateRepositoryInterface() && $this->generateRepository() && $this->registerRepositoryToProvider();
    }

    public function generateRepositoryInterface(): bool
    {
        $fileFullName = "{$this->fileName}RepositoryInterface.php";
        $fileContent = "<?php\n\nnamespace App\Repositories\\{$this->fileName};\n\nuse App\Repositories\RepositoryInterface;\n\ninterface {$this->fileName}RepositoryInterface extends RepositoryInterface\n{\n}\n";

        return $this->generateMarkup($fileFullName, $fileContent);
    }

    public function generateRepository(): bool
    {
        $fileFullName = "{$this->fileName}Repository.php";
        $fileContent = "<?php\n\nnamespace App\Repositories\\{$this->fileName};\n\nuse App\Repositories\RepositoryAbstract;\n\nclass {$this->fileName}Repository extends RepositoryAbstract implements {$this->fileName}RepositoryInterface\n{\n\n}\n";

        return $this->generateMarkup($fileFullName, $fileContent);
    }

    public function registerRepositoryToProvider(): void
    {
        $repositoryServiceProviderPath = app_path('Providers/RepositoryServiceProvider.php');
        $fileContent = file_get_contents($repositoryServiceProviderPath);

        $keyword = 'protected array $repositories = [';
        $preIndex = strpos($fileContent, $keyword);

        $postIndex = strpos($fileContent, ']', $preIndex);
        $postFixLength = 1;

        if ($postIndex - $preIndex == strlen($keyword)) {
            $content = "\n\t\t'{$this->fileName}'\n\t]";
        } else {
            $postIndex -= 2;
            $postFixLength += 2;
            $content = ",\n\t\t'{$this->fileName}'\n\t]";
        }
        $newFileContent = substr_replace($fileContent, $content, $postIndex, $postFixLength);

        file_put_contents($repositoryServiceProviderPath, $newFileContent);
    }
}
