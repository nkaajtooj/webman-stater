<?php

namespace app\command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('make:addon', 'Create an addon under app/addons')]
class MakeAddon extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Addon name (lowercase letters, numbers, and underscores)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = (string) $input->getArgument('name');
        if (!preg_match('/^[a-z][a-z0-9_]*$/D', $name)) {
            $output->writeln('<error>Invalid addon name. Use lowercase letters, numbers, and underscores; start with a letter.</error>');
            return self::FAILURE;
        }

        $base = app_path('addons') . DIRECTORY_SEPARATOR . $name;
        if (file_exists($base)) {
            $output->writeln("<error>Addon already exists: app/addons/$name</error>");
            return self::FAILURE;
        }

        if (!mkdir($base . '/controller', 0777, true)) {
            $output->writeln("<error>Could not create app/addons/$name</error>");
            return self::FAILURE;
        }
        if (!mkdir($base . '/view', 0777)) {
            $output->writeln("<error>Could not create app/addons/$name/view</error>");
            return self::FAILURE;
        }

        $files = [
            'addon.php' => "<?php\n\nreturn [\n    'enabled' => true,\n];\n",
            'routes.php' => "<?php\n\nuse Webman\\Route;\nuse app\\addons\\$name\\controller\\IndexController;\n\nRoute::get('/addons/$name', [IndexController::class, 'index']);\n",
            'controller/IndexController.php' => "<?php\n\nnamespace app\\addons\\$name\\controller;\n\nclass IndexController\n{\n    public function index(): string\n    {\n        return 'Hello from $name addon';\n    }\n}\n",
            'view/.gitkeep' => '',
        ];

        foreach ($files as $path => $contents) {
            if (file_put_contents($base . '/' . $path, $contents) === false) {
                $output->writeln("<error>Could not write app/addons/$name/$path</error>");
                return self::FAILURE;
            }
        }

        $output->writeln("<info>Created app/addons/$name</info>");
        $output->writeln("Route: /addons/$name");
        return self::SUCCESS;
    }
}
