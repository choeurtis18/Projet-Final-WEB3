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


class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

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
                // Set a random user for each formation
                $formation->setUser( $users[$i]);
                $manager->persist($formation);

            }

          
    
    
        }

        // Composer
        $composer = new Composer();
        $composer->setName("Debussy’s L'isle joyeuse");
        $composer->setDescription("rien");
       

        $manager->persist($composer);


         // Instrument
         $instrument = new Instrument();
         $instrument->setName("piano");
 
         $manager->persist($instrument);

         $instrument1 = new Instrument();
         $instrument1->setName("violon");
 
         $manager->persist($instrument1);

         $instrument2 = new Instrument();
         $instrument2->setName("violoncelle");
 
         $manager->persist($instrument2);

         $instrument3  = new Instrument();
         $instrument3->setName("clarinette");
 
         $manager->persist($instrument3);

         $instrument4 = new Instrument();
         $instrument4->setName("flûte");
 
         $manager->persist($instrument4);

         $instrument5 = new Instrument();
         $instrument5->setName("alto");
 
         $manager->persist($instrument5);

        // Badge
        for ($i = 1; $i <= 10; $i++) {
            $badge = new Badge();
            $badge->setName($faker->word);
            $badge->setImage($faker->imageUrl());
            $manager->persist($badge);
        }

        // Classroom
        for ($i = 1; $i <= 5; $i++) {
            $classroom = new Classroom();
            $classroom->setName($faker->word);
            // Set a random user for each classroom
            $classroom->setUser($admin);
            $manager->persist($classroom);
        }

        //Fun Facts
        $funFact = new FunFact();
        $funFact->setName("Classical Music Health Benefits");
        $funFact->setDescription("classical music has been found to improve sleep quality, with people who listen to classical music before bed falling asleep more quickly and spending more time in deep sleep.");
        $manager->persist($funFact);
        
        $funFact1 = new FunFact();
        $funFact1->setName("Mozart Began Composing At 5");
        $funFact1->setDescription("Mozart was a prodigious child. he started composing at the age of five and his first opera was performed when he was just 12 years old. Mozart's talent was quickly recognized by his family and they devoted themselves to nurturing his gift.");
        $manager->persist($funFact1);

        $funFact2 = new FunFact();
        $funFact2->setName("The Longest Marathon Played On A Piano Was 127 Hours");
        $funFact2->setDescription("19-year-old B.Com student of Shri Ram College of Commerce holds the Guinness World Record for the longest marathon playing keyboard/piano that lasted 127 hours eight minutes and 38 seconds.");
        $manager->persist($funFact2);

        $funFact3= new FunFact();
        $funFact3->setName("The Largest Orchestra in the World has over 12,000 members.
        ");
        $funFact3->setDescription("In November 2021, Venezuela entered the Guinness Book of World Records for the world's largest orchestra after 12,000 local musicians performed Tchaikovsky's 'Marche Slave'.");
        $manager->persist($funFact3);
        
        $funFact4 = new FunFact();
        $funFact4->setName("Beethoven's Best Work Was After Losing His Hearing");
        $funFact4->setDescription("Beethoven composed some of his most famous works after he had lost his hearing  including his Ninth Symphony.        ");
        $manager->persist($funFact4);


       

         $manager->persist($instrument);
         
      // Masterclasses
        $masterclass = new Masterclass();
        $masterclass->setTitle("Partita Nr. 2");
        $masterclass->setDescription("Jacques Rouvier et son élève Julien Braidi travaillent à développer une trajectoire musicale et à jouer de manière expressive. De plus, la paire travaille sur des aspects plus techniques tels que jouer avec une bonne posture, choisir le bob doigté et créer un son plus profond en appliquant plus de pression sur les touches du bout des doigts.");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("null");

        $manager->persist($masterclass);
    
    
       
        // MasterclassesQuizz
        $masterclassQuizz = new MasterclassQuizz();
        $masterclassQuizz->setName("La musique classique");
        $manager->persist($masterclassQuizz);
    


        // MasterclassesQuestions
        $masterclassQuestion = new MasterclassQuestion();
        $masterclassQuestion->setTitle("De quel compositeur Buxtehude a peut-être été un des maîtres ?");
        $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
        $masterclassQuestion->setProposition(['Bach', 'Mozart', 'Pachelbel', 'Beethoven']);
        $masterclassQuestion->setAnswer('Mozart');
        $manager->persist($masterclassQuestion);


        $manager->flush();

    }


    
}
