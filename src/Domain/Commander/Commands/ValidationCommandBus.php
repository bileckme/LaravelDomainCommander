<?php namespace Domain\Commander\Commands;

use Illuminate\Foundation\Application;

class ValidationCommandBus implements CommandBus
{
    private $app;
    protected $commandTranslator;
    /**
     * @var DefaultCommandBus
     */
    private $defaultCommandBus;

    /**
     * @param DefaultCommandBus $defaultCommandBus
     * @param Application       $app
     * @param CommandTranslator $commandTranslator
     */
    public function __construct(DefaultCommandBus $defaultCommandBus, Application $app, CommandTranslator $commandTranslator)
    {
        $this->app = $app;
        $this->commandTranslator = $commandTranslator;
        $this->defaultCommandBus = $defaultCommandBus;
    }

    /**
     * Executes a command
     * @param $command
     * @return mixed
     */
    public function execute($command)
    {
        $validator = $this->commandTranslator->toValidator($command);

        if (class_exists($validator)) {
            $this->app->make($validator)->validate($command);
        }

        return $this->defaultCommandBus->execute($command);
    }
}
