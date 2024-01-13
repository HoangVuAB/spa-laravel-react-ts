<?php

namespace App\Console\Commands\MakeFile;

class MakeEnum extends BaseMakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make enums file';

    protected string $folder = 'Enums';

    protected string $successMessage = 'Create enum success';

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
        return $this->generateEnum();
    }

    protected function generateEnum(): bool
    {
        $fileFullName = "{$this->fileName}.php";
        $fileContent = "<?php\n\nnamespace App\Enums;\n\nenum {$this->fileName}: int\n{\n\tcase CASE_NAME = 1;\n\n\tpublic function text(): string\n\t{\n\t\treturn match (\$this) {\n \t\t\tself::CASE_NAME => 'text value',\n\t\t};\n\t}\n\n}";

        return $this->generateMarkup($fileFullName, $fileContent);
    }
}
