<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

use App\Entity\Badge;
use App\Entity\Classroom;
use App\Entity\ClassroomQuestion;
use App\Entity\ClassroomQuizz;
use App\Entity\Composer;
use App\Entity\Event;
use App\Entity\Formation;
use App\Entity\FormationLvl;
use App\Entity\FunFact;
use App\Entity\Instrument;
use App\Entity\Masterclass;
use App\Entity\MasterclassComposer;
use App\Entity\MasterclassFormation;
use App\Entity\MasterclassLvl;
use App\Entity\MasterclassQuestion;
use App\Entity\MasterclassQuizz;
use App\Entity\User;
use App\Entity\UserBadge;
use App\Entity\UserEvent;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager)
    {
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        // Clean database tables
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        // Disable foreign key checks
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');

        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        foreach ($metadata as $classMetadata) {
            $tableName = $classMetadata->getTableName();
            $connection->executeStatement($platform->getTruncateTableSQL($tableName, true /* whether to cascade */));
        }

        // Enable foreign key checks
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');


        $faker = Faker\Factory::create();

        // Admin
        $admin = new User();
        $admin->setEmail('admin@salineacademy.com');
        $admin->setRoles(["ROLE_ADMIN"]);

        $password = $this->hasher->hashPassword($admin, 'heticadmin');
        $admin->setPassword($password);

        $manager->persist($admin);
        $manager->flush();

        //Users
        $users = Array();
        for ($i = 0; $i < 4; $i++) {
            $users[$i] = new User();
            $users[$i]->setEmail($faker->email);
            $users[$i]->setRoles(["ROLE_USER"]);
            $password = $this->hasher->hashPassword( $users[$i], 'heticuser');
            $users[$i]->setPassword($password);
    
            $manager->persist($users[$i]);

            for ($j = 1; $j <= 5; $j++) {
                
                // Masterclass levels
                $masterclassLvl = new MasterclassLvl();
                // Set a random user for each masterclass level
                $masterclassLvl->setUser( $users[$i]);
                $masterclassLvl->setProgression($faker->numberBetween(0, 100));
                $masterclassLvl->setProgressionXp($faker->numberBetween(0, 1000));
                $masterclassLvl->setStatus($faker->randomElement(['En cours', 'Terminé']));
                $manager->persist($masterclassLvl);

               // Formations levels
                $formationLvl = new FormationLvl();
                // Set a random user for each formation level
                $formationLvl->setUser($users[$i]);
                $formationLvl->setProgression($faker->numberBetween(0, 100));
                $formationLvl->setProgressionXp($faker->numberBetween(0, 1000));
                $formationLvl->setStatus($faker->randomElement(['En cours', 'Terminé']));
                $manager->persist($formationLvl);

                // Formations
                $formation = new Formation();
                $formation->setName("Formation n°" . $faker->numberBetween(0, 20));
                $formation->setDescription($faker->realText(200));
                // Set a random user for each formation
                $formation->setUser( $users[$i]);
                $manager->persist($formation);
            }
        }

        
        for ($i = 1; $i <= 5; $i++) {
            //  Classroom
            $classroom = new Classroom();
            $classroom->setName($faker->word);
            // Set a random user for each classroom
            $classroom->setUser($admin);
            $manager->persist($classroom);    

            //  Compositeurs
            $composer = new Composer();
            $composer->setName($faker->name);
            $composer_description = $faker->realText(500);
            $composer->setDescription($composer_description);
            $manager->persist($composer); 

            // Instruments
            $instrument = new Instrument();
            $instrument->setName($faker->word);
            $manager->persist($instrument);        
        }
        $manager->flush();

        for ($i = 1; $i <= 15; $i++) {
            //Get Random Instrument
            $instruments = $manager->getRepository(Instrument::class)->findAll();
            $totalInstruments = count($instruments);
            $randomInstrumentsIndex = rand(0, $totalInstruments - 1);
            $randomInstrument = $instruments[$randomInstrumentsIndex];

            //Get Random Formation
            $formations = $manager->getRepository(Formation::class)->findAll();
            $totalFormations = count($formations);
            $randomFormationsIndex = rand(0, $totalFormations - 1);
            $randomFormation = $formations[$randomFormationsIndex];

            //Get Random Composer
            $composers = $manager->getRepository(Composer::class)->findAll();
            $totalComposers = count($composers);
            $randomComposersIndex = rand(0, $totalComposers - 1);
            $randomComposer  = $composers[$randomComposersIndex];


            //Get Users
            $users_admin = $manager->getRepository(User::class)->getAllAdminUser();
            $totalUsers_admin= count($users_admin);
            $randomUsers_adminIndex = rand(0, $totalUsers_admin - 1);
            $randomUser  = $users_admin[$randomUsers_adminIndex];

            //  Badges
            $badge = new Badge();
            $badge->setName($faker->word);
            $badge->setImage($faker->imageUrl());
            $manager->persist($badge);

            //FunFact
            $funFact = new FunFact();
            $funFact->setName($faker->word);
            $funfact_description = $faker->realText(20);
            $funFact->setDescription($funfact_description);
            $manager->persist($funFact);

            //  Masterclasses
            $masterclass = new Masterclass();
            $masterclass->setTitle($faker->word);
            $masterclass_description = $faker->realText(500);
            $masterclass->setDescription($masterclass_description);
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $manager->persist($masterclass);


            //  MasterclassesQuizz
            $masterclassQuizz = new MasterclassQuizz();
            $masterclassQuizz->setName("Quizz n°" . $faker->numberBetween(0, 20));
            $manager->persist($masterclassQuizz);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle($faker->realText(10));
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(['Bach', 'Mozart', 'Pachelbel', 'Beethoven']);
            $masterclassQuestion->setAnswer($faker->randomElement(['Bach', 'Mozart', 'Pachelbel', 'Beethoven']));
            $manager->persist($masterclassQuestion);
        }

        $manager->flush();
    }
}
