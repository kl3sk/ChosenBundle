<?php

namespace Kl3sk\ChosenBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class CopyCommand extends ContainerAwareCommand
{

    /**
     * @var Filesystem
     */
    private $fs;

    public function __construct()
    {
        parent::__construct();
        // Symfony file system
        $this->fs = new Filesystem();

    }

    protected function configure()
    {
        $this
            ->setName('kl3sk:chosen:copy')
            ->setDescription('Copy Chosen asset into Kl3skBundleChose asset folder')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get kernel
        $kernel = $this->getContainer()->get('kernel');
        // Get rootDir
        $rootDir = $kernel->getRootDir();
        // Get Vendor dir
        $vendor = $rootDir . '/../vendor';
        // Set chosen folder name
        $chosen = 'drmonty/chosen';
        // Does the dir exists ?
        if(!$this->fs->exists($vendor . DIRECTORY_SEPARATOR . $chosen)) {
            $output->writeln("An error occurred while checking directory : " . $vendor . DIRECTORY_SEPARATOR . $chosen);
        }
        // Ckeck folders existence inside bundle
        if(!$this->fs->exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../Resources/public/css')) {
            $this->fs->mkdir(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../Resources/public/css', 0777);
        }
        if(!$this->fs->exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../Resources/public/js')) {
            $this->fs->mkdir(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../Resources/public/js', 0777);
        }


        // Get environnement
        $env = $kernel->getEnvironment();
        // Get files
        if($env == "dev") {
            $files = [
                'css' => 'chosen.css',
                'js' => 'chosen.jquery.js'
            ];
        } else {
            $files = [
                'css' => 'chosen.min.css',
                'js' => 'chosen.jquery.min.js'
            ];
        }


        // Copy files into Public bundle's folder
        try {
            $this->fs->copy(
                $vendor . DIRECTORY_SEPARATOR . $chosen . DIRECTORY_SEPARATOR . 'css/' . $files['css'],
                dirname(__FILE__) . DIRECTORY_SEPARATOR . '../Resources/public/css' . DIRECTORY_SEPARATOR . $files['css'],
                true
            );
        } catch(IOExceptionInterface $e) {
            $output->writeln("An error occurred while copying file ".$e->getPath());
        }
        try {
            $this->fs->copy(
                $vendor . DIRECTORY_SEPARATOR . $chosen . DIRECTORY_SEPARATOR . 'js/' . $files['js'],
                dirname(__FILE__) . DIRECTORY_SEPARATOR . '../Resources/public/js' . DIRECTORY_SEPARATOR . $files['js'],
                true
            );
        } catch(IOExceptionInterface $e) {
            $output->writeln("An error occurred while copying file ".$e->getPath());
        }

        $output->writeln("<info>Your files have been copied to Kl3skChosenBundle, dont forget to install assets<info> <comment>php app/console asset:install</comment>");
    }
}