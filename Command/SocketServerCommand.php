<?php
/**
 * This file is part of the RatchetBundle project.
 *
 * (c) 2013 Philipp Boes <mostgreedy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace P2\Bundle\RatchetBundle\Command;

use P2\Bundle\RatchetBundle\WebSocket\Server\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SocketServerCommand
 * @package P2\Bundle\RatchetBundle\Command
 */
class SocketServerCommand extends Command
{
    /**
     * @var string
     */
    const ARG_ADDRESS = 'address';

    /**
     * @var string
     */
    const ARG_PORT = 'port';
    protected static $defaultName = 'socket:server:start';
    private Factory $factory;

    public function __construct(
        Factory $factory
    )
    {
        parent::__construct(self::$defaultName);
        $this->factory = $factory;
    }

    protected function configure()
    {
        $this
            ->setDescription('Starts a web socket server')
            ->addArgument(static::ARG_PORT, InputArgument::OPTIONAL, 'The port to listen on incoming connections')
            ->addArgument(static::ARG_ADDRESS, InputArgument::OPTIONAL, 'The address to listen on')
            ->setHelp(<<<EOT
<info>app/console socket:server:start</info>

  The basic command starts a new websocket server listening on any connections on port 8080
EOT
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            if (null !== $address = $input->getArgument(static::ARG_ADDRESS)) {
                $this->factory->setAddress($address);
            }

            if (null !== $port = $input->getArgument(static::ARG_PORT)) {
                $this->factory->setPort($port);
            }

            $server = $this->factory->create();

            $output->writeln(
                sprintf(
                    '<info><comment>Ratchet</comment> - listening on %s:%s</info>',
                    $this->factory->getAddress(),
                    $this->factory->getPort()
                )
            );

            $server->run();

            return 0;
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return -1;
        }
    }
}
