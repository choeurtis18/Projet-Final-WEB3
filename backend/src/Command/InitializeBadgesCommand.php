<?php

namespace App\Command;

use App\Entity\Badge;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:initialize-badges',
    description: 'Initializes the badges with their XP thresholds.',
)]

class InitializeBadgesCommand extends Command
{
    protected static $defaultName = 'app:initialize-badges';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $badgesData = [
                ['name' => 'Débutant',
                'image' => 'design-scholar-badge-grey.svg',
                'threshold' => 0
                ],
                ['name' => 'Intermédiaire',
                'image' => 'design-scholar-badge-grey.svg',
                'threshold' => 500
                ],
                ['name' => 'Expert',
                'image' => 'design-scholar-badge-grey.svg',
                'threshold' => 1000
                ],
                ['name' => 'Master',
                'image' => 'design-scholar-badge-grey.svg',
                'threshold' => 1500
                ],
        ];

        foreach ($badgesData as $data) {
            $badge = new Badge();
            $badge->setName($data['name']);
            $badge->setImage($data['image']);
            $badge->setXpThreshold($data['threshold']);
            $this->entityManager->persist($badge);
        }

        $this->entityManager->flush();

        $output->writeln('Badges initialized successfully!');

        return Command::SUCCESS;
    }
}
