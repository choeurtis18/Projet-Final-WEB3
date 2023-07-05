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

        //
        //  Compositeurs
        //
        $composer_1 = new Composer();
        $composer_1->setName("Giuseppe Verdi");
        $composer_1->setDescription("Giuseppe Fortunino Francesco Verdi, né Joseph Fortunin François Verdi le 10 octobre 1813 à Roncole et mort le 27 janvier 1901 à Milan, est un compositeur romantique italien.");
        $manager->persist($composer_1);

        $composer_2 = new Composer();
        $composer_2->setName("Mozart");
        $composer_2->setDescription("Wolfgang Amadeus Mozart ou Johannes Chrysostomus Wolfgangus Theophilus Mozart, né le 27 janvier 1756 à Salzbourg et mort le 5 décembre 1791 à Vienne, est un compositeur autrichien de la période classique. Il est considéré comme l'un des plus grands compositeurs de l'histoire de la musique européenne.");
        $manager->persist($composer_2);

        $composer_3 = new Composer();
        $composer_3->setName("Ludwig van Beethoven");
        $composer_3->setDescription("Ludwig van Beethoven est un compositeur, pianiste et chef d'orchestre allemand, né à Bonn le 15 ou le 16 décembre 1770 et mort à Vienne le 26 mars 1827 à 56 ans.");
        $manager->persist($composer_3);

        $composer_4 = new Composer();
        $composer_4->setName("Gioachino Rossini");
        $composer_4->setDescription("Gioachino Rossini — Gioacchino Rossini pour certains auteurs francophones et Giovacchino Antonio Rossini pour l'état civil — est un compositeur italien né le 29 février 1792 à Pesaro et mort le 13 novembre 1868 à Passy, Paris.");
        $manager->persist($composer_4);


        //
        //  Instrument
        //
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


        //
        //  Badge
        //
        for ($i = 1; $i <= 10; $i++) {
            $badge = new Badge();
            $badge->setName($faker->word);
            $badge->setImage($faker->imageUrl());
            $manager->persist($badge);
        }

        //
        //  Classroom
        //
        for ($i = 1; $i <= 5; $i++) {
            $classroom = new Classroom();
            $classroom->setName($faker->word);
            // Set a random user for each classroom
            $classroom->setUser($admin);
            $manager->persist($classroom);
        }

        //
        //  Fun Facts
        //
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
        $funFact3->setName("The Largest Orchestra in the World has over 12,000 members.");
        $funFact3->setDescription("In November 2021, Venezuela entered the Guinness Book of World Records for the world's largest orchestra after 12,000 local musicians performed Tchaikovsky's 'Marche Slave'.");
        $manager->persist($funFact3);
        
        $funFact4 = new FunFact();
        $funFact4->setName("Beethoven's Best Work Was After Losing His Hearing");
        $funFact4->setDescription("Beethoven composed some of his most famous works after he had lost his hearing  including his Ninth Symphony.        ");
        $manager->persist($funFact4);

         
        //
        //  Masterclasses
        //
        $masterclass = new Masterclass();
        $masterclass->setTitle("Requiem");
        $masterclass->setDescription("La messe de Requiem en ré mineur, de Wolfgang Amadeus Mozart, composée en 1791, est une œuvre de la dernière année de la vie de Mozart, mais pas exactement la dernière œuvre du compositeur. Elle n'est de la main de Mozart que pour les deux tiers environ, la mort en ayant interrompu la composition.");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
        $masterclass->setInstrument($instrument1);
        $masterclass->setComposer($composer_2);
        $manager->persist($masterclass);
    
        $masterclass = new Masterclass();
        $masterclass->setTitle("Sonate pour piano no 11 de Mozart");
        $masterclass->setDescription("La Sonate pour piano nᵒ 11 en la majeur, K. 331/300ⁱ, de Wolfgang Amadeus Mozart, est une sonate pour piano composée dans les années 1780. Elle est notamment célèbre pour son troisième mouvement, dit « alla turca » ou « Marche turque ». ");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("https://www.youtube.com/watch?v=dP9KWQ8hAYk");
        $masterclass->setInstrument($instrument);
        $masterclass->setComposer($composer_2);

        $manager->persist($masterclass);
    
        $masterclass = new Masterclass();
        $masterclass->setTitle("Douze variations en do majeur pour piano sur « Ah ! vous dirai‑je,");
        $masterclass->setDescription("Les douze variations en do majeur pour piano sur « Ah ! vous dirai-je, maman », KV 265/300ᵉ, sont une œuvre pour piano de Wolfgang Amadeus Mozart, écrite en 1781 ou 1782, quand il avait vingt-cinq ans. La pièce est formée de douze variations basées sur la chanson française Ah!");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("https://www.youtube.com/watch?v=7BTvoqVK420");
        $masterclass->setInstrument($instrument);
        $masterclass->setComposer($composer_3);
        $manager->persist($masterclass);
       
        $masterclass = new Masterclass();
        $masterclass->setTitle("Symphonie no 5 de Beethoven");
        $masterclass->setDescription("La Symphonie nᵒ 5 en ut mineur, op. 67, dite Symphonie du Destin, a été écrite par Ludwig van Beethoven en 1805-1807 et créée le 22 décembre 1808 au Theater an der Wien de Vienne.");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("https://www.youtube.com/watch?v=iyPtQOv7sa0");
        $masterclass->setInstrument($instrument4);
        $masterclass->setComposer($composer_3);
        $manager->persist($masterclass);

        $masterclass = new Masterclass();
        $masterclass->setTitle("La Cenerentola");
        $masterclass->setDescription("La Cenerentola est le dernier opéra-bouffe composé par Gioachino Rossini pour le public italien. Il s'agit d'un dramma giocoso en deux actes dont le livret est de Jacopo Ferretti, d’après le conte Cendrillon de Charles Perrault. Cet opéra a été créé le 28 janvier 1817 au Teatro Valle de Rome.");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("https://www.youtube.com/watch?v=eoIHiswqHOg");
        $masterclass->setInstrument($instrument5);
        $masterclass->setComposer($composer_4);
        $manager->persist($masterclass);

        $masterclass = new Masterclass();
        $masterclass->setTitle("Otello");
        $masterclass->setDescription("Otello est un opéra en trois actes composé par Gioachino Rossini. L'œuvre est tirée de la tragédie Othello ou le Maure de Venise de 1792 de Jean-François Ducis. L'opéra fut présenté pour la première fois à Naples le 4 décembre 1816 au Teatro del Fondo.");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("https://www.youtube.com/watch?v=iy5CGMsxBhE");
        $masterclass->setInstrument($instrument5);
        $masterclass->setComposer($composer_4);
        $manager->persist($masterclass);

        $masterclass = new Masterclass();
        $masterclass->setTitle("La traviata");
        $masterclass->setDescription("La traviata est un opéra en trois actes de Giuseppe Verdi créé le 6 mars 1853 à La Fenice de Venise sur un livret de Francesco Maria Piave d'après le roman d'Alexandre Dumas fils, La Dame aux camélias et son adaptation théâtrale.");
        $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
        $masterclass->setVideo("https://www.youtube.com/watch?v=YsLtrlHh4YE");
        $masterclass->setInstrument($instrument2);
        $masterclass->setComposer($composer_1);
        $manager->persist($masterclass);


        //
        //  MasterclassesQuizz
        //
        $masterclassQuizz = new MasterclassQuizz();
        $masterclassQuizz->setName("La musique classique");
        $manager->persist($masterclassQuizz);
    


        //
        //  MasterclassesQuestions
        //
        $masterclassQuestion = new MasterclassQuestion();
        $masterclassQuestion->setTitle("De quel compositeur Buxtehude a peut-être été un des maîtres ?");
        $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
        $masterclassQuestion->setProposition(['Bach', 'Mozart', 'Pachelbel', 'Beethoven']);
        $masterclassQuestion->setAnswer('Mozart');
        $manager->persist($masterclassQuestion);


        $manager->flush();
    }
}
