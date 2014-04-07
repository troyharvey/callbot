<?php namespace Indatus\Callbot\Commands;

use Indatus\Callbot\Commands\CallCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * This command can be used to run multiple batches of calls,
 * each with it's own call script. Configure your batches
 * in config.php prior to running this command.
 *
 * Usage:
 *
 * $ ./callbot call:multi
 */
class CallMultiCommand extends CallCommand
{
    /**
     * Array of completed call ids
     *
     * @var array
     */
    protected $callIds = array();

    /**
     * Command configuration
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('call:multi')
            ->setDescription('Run multiple batches of calls using multiple call scripts')
            ->addOption('batches', 'b', InputOption::VALUE_REQUIRED, 'Specify which batches to run');
    }

    /**
     * Execute the command
     *
     * @param InputInterface  $input  InputInterface instance
     * @param OutputInterface $output OutputInterface instance
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $batches = $this->getBatchesToRun($input->getOption('batches'));

        foreach ($batches as $batch) {

            $script = file_get_contents($batch['script']);

            if (!$this->uploadScript($script)) {

                $output->writeln('<error>Failed to upload script.</error>');
                die;

            }

            foreach ($batch['to'] as $to) {

                $from = $this->getFrom($batch);

                $this->callIds[] = $this->callService->call(
                    $from,
                    $to,
                    $this->uploadName
                );

            }

        }

        if (!empty($this->callIds)) {

            $results = $this->callService->getResults($this->callIds);

            if (!empty($results)) {

                $table = $this->buildResultsTable($results);

                $table->render($output);

            }

        }

    }

    /**
     * Sets the batches to be ran based on what is
     * present in config.php and what the user passes
     * to the batches option
     *
     * @param string $batches Comma separated list of batch numbers
     *
     * @return array
     */
    protected function getBatchesToRun($batches)
    {
        $allBatches = $this->config->get('batches');

        if ($batches) {

            $numbers = explode(',', $batches);

            $batchesToRun = array();

            foreach ($numbers as $number) {

                $batchesToRun[] = $allBatches[$number - 1];

            }

            return $batchesToRun;

        } else {

            return $allBatches;

        }
    }

    /**
     * Get the from phone number for the call
     *
     * @param string $overrideFrom From phone number
     *
     * @return string
     */
    protected function getFrom($batch)
    {
        if (array_key_exists('from', $batch)) {

            return $batch['from'];

        }

        return $this->config->get('callService.defaultFrom');
    }
}
