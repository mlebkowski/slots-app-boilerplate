<?php

declare(strict_types=1);

namespace Enraged\Interactions\Cli\Command;

use Doctrine\DBAL\Connection;
use Enraged\Application\Command\Doctor\SynchronizeDoctorCommand;
use Enraged\Application\Query\Doctor\ExternalDoctors\ExternalDoctorsQueryInterface;
use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorsQuery;
use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorTimeSlotsQuery;
use Enraged\Domain\Exception\DomainException;
use Enraged\Infrastructure\BUS\CommandBus;
use Enraged\Infrastructure\Exception\InfrastructureException;
use Enraged\Interactions\Exception\InteractionsCliException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizeDoctorsCliCommand extends Command
{
    protected static $defaultName = 'interactions:synchronize-doctors';
    protected static $defaultDescription = 'Synchronizes doctors from external api.';
    protected LoggerInterface $logger;
    protected CommandBus $command_bus;
    protected ExternalDoctorsQueryInterface $external_doctors_query;
    protected Connection $connection;

    public function __construct(
        LoggerInterface $logger,
        CommandBus $commandBus,
        ExternalDoctorsQueryInterface $external_doctors_query
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->command_bus = $commandBus;
        $this->external_doctors_query = $external_doctors_query;
    }

    protected function configure() : void
    {
        $this
            ->setHelp('In case of error when importing doctor data he will be skipped, but process will continue.');
    }

    /**
     * @throws InteractionsCliException
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        try {
            foreach ($this->external_doctors_query->listDoctors(new ListExternalDoctorsQuery()) as $doctor) {
                try {
                    $this->command_bus->command(
                        new SynchronizeDoctorCommand(
                            $doctor->getExternalId(),
                            $doctor->getName(),
                            iterator_to_array(
                                $this
                                    ->external_doctors_query
                                    ->listDoctorTimeSlots(
                                        new ListExternalDoctorTimeSlotsQuery(
                                            $doctor->getExternalId()
                                        )
                                    )
                            )
                        )
                    );
                    $this->logger->info(
                        sprintf(
                            '[CLI] [%s] Doctor #%d imported with time slots.',
                            static::$defaultName,
                            $doctor->getExternalId()
                        ),
                        [
                            'external_doctor_id' => $doctor->getExternalId(),
                        ]
                    );
                } catch (Exception $exception) {
                    $this->logger->error(
                        sprintf('[CLI] [%s] Doctor #%d skipped because exception during processing.', static::$defaultName, $doctor->getExternalId()),
                        [
                            'external_doctor_id' => $doctor->getExternalId(),
                            'exception' => $exception,
                        ]
                    );
                }
            }
        } catch (InfrastructureException|DomainException $exception) {
            throw new InteractionsCliException(sprintf('[CLI] [%s] Command failed because exception was thrown during import.', static::$defaultName), Command::FAILURE, $exception);
        }

        return Command::SUCCESS;
    }
}
