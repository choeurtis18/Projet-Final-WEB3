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
        $users = [];
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
        }
        
        // Instruments
        $instrument_1 = new Instrument();
        $instrument_1->setName('piano');
        $manager->persist($instrument_1);  
        $instrument_2 = new Instrument();
        $instrument_2->setName('violon');
        $manager->persist($instrument_2);  
        $instrument_3 = new Instrument();
        $instrument_3->setName('alto');
        $manager->persist($instrument_3);  
        $instrument_4 = new Instrument();
        $instrument_4->setName('flute');
        $manager->persist($instrument_4);  

        $manager->flush();

        $instruments = $manager->getRepository(Instrument::class)->findAll();
        $totalInstruments = count($instruments);

        $formations = $manager->getRepository(Formation::class)->findAll();
        $totalFormations = count($formations);

        $composers = $manager->getRepository(Composer::class)->findAll();
        $totalComposers = count($composers);

        $users_admin = $manager->getRepository(User::class)->getAllAdminUser();
        $totalUsers_admin= count($users_admin);

              //  MasterclassesQuizz
              $masterclassQuizzPiano = new MasterclassQuizz();
              $masterclassQuizzPiano->setName("Connais-tu bien le piano ?");
  
              //  MasterclassesQuizz
              $masterclassQuizzClassique = new MasterclassQuizz();
              $masterclassQuizzClassique->setName("La musique classique ");

              //  MasterclassesQuizz
              $masterclassQuizzCompositeurs = new MasterclassQuizz();
              $masterclassQuizzCompositeurs->setName("Les grands compositeurs ");

              
            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle(" Qui a composé « La truite » ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(['Franz Schubert', 'Franz Liszt', ' Frederic Chopin', 'Patrick Saumon']);
            $masterclassQuestion->setAnswer("Franz Schubert");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclassQuestion);
  
            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("Qu’a composé Maurice Ravel ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(['Le bolero', 'La vareuse', 'Le veston', 'Le cache-coeur']);
            $masterclassQuestion->setAnswer("Le bolero");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("Quel est l’intrus parmi ces compositions de Tchaïkovsky ");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(['Le lac des Cygnes', 'Casse-noisette', 'Ave Maria', 'Manfred']);
            $masterclassQuestion->setAnswer("Ave Maria");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("Complétez le titre de cette musique de Richard Wagner « La ... des walkyries » :");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(['La balade', 'La danse', 'La chevauchée', 'Montée']);
            $masterclassQuestion->setAnswer("La chevauchée");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("Avec qui Frédéric Chopin a-t-il été en couple ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(['George Sand', 'Amantine Dupin', 'Les deux, ce sont la même personne', "Il n'a jamais été en couple"]);
            $masterclassQuestion->setAnswer("Les deux, ce sont la même personne");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("De quel compositeur Buxtehude a peut-être été un des maîtres ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(['Bach', 'Pachelbel', 'Beethoven', "Mozart"]);
            $masterclassQuestion->setAnswer("Bach");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclassQuestion);

             //  MasterclassesQuestions
             $masterclassQuestion = new MasterclassQuestion();
             $masterclassQuestion->setTitle("Combien de Consolations Liszt a-t-il composé ?");
             $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
             $masterclassQuestion->setProposition(['7', '6', '3', "4"]);
             $masterclassQuestion->setAnswer("6");
             $masterclassQuestion->addMasterclassQuizz($masterclassQuizzClassique);
             $manager->persist($masterclassQuestion);

             //  MasterclassesQuestions
             $masterclassQuestion = new MasterclassQuestion();
             $masterclassQuestion->setTitle("Quel est l’apport majeur que l’on reconnaît à Schoenberg ?");
             $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
             $masterclassQuestion->setProposition(["L'introduction de chants dans les concertos", 'Le développement de la musique atonale', "L'introduction du jazz dans la musique savante", "L'invention du contrepoint"]);
             $masterclassQuestion->setAnswer("Le développement de la musique atonale");
             $masterclassQuestion->addMasterclassQuizz($masterclassQuizzClassique);
             $manager->persist($masterclassQuestion);

             //  MasterclassesQuestions
             $masterclassQuestion = new MasterclassQuestion();
             $masterclassQuestion->setTitle("Qu'est-ce qu'une sonate ?");
             $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
             $masterclassQuestion->setProposition(["Un motif musical qui se répète à plusieurs reprises dans une symphonie", "Une œuvre musicale formée à partir d'un livret, qui compte notamment des danses", "Une composition musicale de plusieurs mouvements pour un soliste ou pour un petit ensemble", "Une pièce musicale écrite pour un seul instrument en trois mouvements"]);
             $masterclassQuestion->setAnswer("Une composition musicale de plusieurs mouvements pour un soliste ou pour un petit ensemble");
             $masterclassQuestion->addMasterclassQuizz($masterclassQuizzClassique);
             $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("Le côté gauche de ce piano concerne les notes ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(["Graves", "Aigües", "Les deux", "Normales"]);
            $masterclassQuestion->setAnswer("Graves");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzPiano);
            $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("Combien de touches y a-t-il sur un piano ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(["97 ou 96", "55", "77 ou 75", "88 ou 85"]);
            $masterclassQuestion->setAnswer("88 ou 85");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzPiano);
            $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("Le premier piano a été fabriqué en quelle année ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(["en 1698", "en 1734", "en 1874", "en 1842"]);
            $masterclassQuestion->setAnswer("en 1698");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzPiano);
            $manager->persist($masterclassQuestion);

            //  MasterclassesQuestions
            $masterclassQuestion = new MasterclassQuestion();
            $masterclassQuestion->setTitle("A quelle famille d'instruments appartient le piano ?");
            $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            $masterclassQuestion->setProposition(["percussion", "cordes frappées", "vent", "claviers"]);
            $masterclassQuestion->setAnswer("cordes frappées");
            $masterclassQuestion->addMasterclassQuizz($masterclassQuizzPiano);
            $manager->persist($masterclassQuestion);

             
             $manager->persist($masterclassQuizzClassique);
             $manager->persist($masterclassQuizzCompositeurs);
             $manager->persist($masterclassQuizzPiano);

        for ($i = 1; $i <= 5; $i++) {
            try {
            //Get Random Instrument
            $randomInstrumentsIndex = rand(0, $totalInstruments - 1);
            $randomInstrument = $instruments[$randomInstrumentsIndex];

            //Get Random Formation
            $randomFormationsIndex = rand(0, $totalFormations - 1);
            $randomFormation = $formations[$randomFormationsIndex];

            //Get Random Composer
            $randomComposersIndex = rand(0, $totalComposers - 1);
            $randomComposer  = $composers[$randomComposersIndex];

            //Get Users
            $randomUsers_adminIndex = rand(0, $totalUsers_admin - 1);
            $randomUser  = $users_admin[$randomUsers_adminIndex];

            //  Badges
            $badge = new Badge();
            $badge->setName($faker->word);
            $badge->setImage($faker->imageUrl());
            $badge->setXpThreshold(random_int(0, 500));
            $manager->persist($badge);

            

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
            $masterclass->addMasterclassQuizz($masterclassQuizzClassique);
            $manager->persist($masterclass);

            $masterclass = new Masterclass();
            $masterclass->setTitle("Partita No. 2");
            $masterclass->setDescription("Jacques Rouvier et son élève Julien Braidi travaillent sur le développement d'une trajectoire musicale et d'un jeu expressif. En outre, ils travaillent sur des aspects plus techniques tels que la posture, le doigté et la création d'un son plus profond en exerçant une pression plus forte sur les touches du bout des doigts. ");
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $masterclass->addMasterclassQuizz($masterclassQuizzClassique);
            $manager->persist($masterclass);


            $masterclass = new Masterclass();
            $masterclass->setTitle("Oboe Concerto in D Major, Op. 144");
            $masterclass->setDescription("Dans cette masterclass de hautbois, Céline Moinet souligne la relation entre le soliste et l'orchestre. Elle commence son cours en recommandant à Ho Ting Tsui d'écouter attentivement l'accompagnement. Cette recommandation est reprise tout au long du cours, lorsqu'elle conseille à son élève d'éviter de précipiter les notes afin d'assurer un dialogue entre le soliste et l'orchestre. Il est impératif de maintenir un tempo stable, comme le dit le maître. De plus, le professeur de hautbois précise que jouer vivace ne consiste pas à jouer vite, mais à jouer avec caractère et humour. Il doit être joué comme s'il était plein de vie. Même avec le vivace, le maître indique qu'il est important de garder un tempo solide et d'éviter de précipiter les notes.D'autres éléments cruciaux sont abordés dans cette session, notamment la respiration, et plus précisément la manière de respirer pour économiser l'air et l'énergie, ainsi que le moment où il faut respirer pour atteindre un haut niveau d'expression. L'objectif est de raconter une histoire, ce qui se fait en étant expressif, en changeant de couleur et en ajoutant du contraste.");
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $masterclass->addMasterclassQuizz($masterclassQuizzPiano);
            $manager->persist($masterclass);


            $masterclass = new Masterclass();
            $masterclass->setTitle("Concerto No. 5 in A Major, 1st movement");
            $masterclass->setDescription("Miriam Fried ouvre cette masterclass avec un discours sur l'interprétation d'une cadence par Anatol Janos Toth, soulignant l'importance de jouer une fin claire en établissant une trajectoire dès le début. Ils discutent ensuite du caractère jovial et humoristique de la composition et de la manière de l'exprimer dans le jeu de Toth. Fried explique qu'il ne faut pas en faire trop et se concentrer sur la simplicité afin de vraiment saisir la nature comique de ce concerto.
            En outre, le professeur et l'étudiant abordent l'harmonie, la forme classique traditionnelle d'une phrase, la distribution de l'archet et la valeur de la réflexion sur le type de son qu'il faut affirmer pour communiquer des idées claires à l'orchestre et au public.");
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $masterclass->addMasterclassQuizz($masterclassQuizzClassique);
            $manager->persist($masterclass);


            $masterclass = new Masterclass();
            $masterclass->setTitle("Clarinet Sonata No. 1 in F Minor, Op. 120, 1st movement");
            $masterclass->setDescription("Dans cette masterclass pour clarinette, Sharon Kam souligne l'importance de connaître et de comprendre la section piano ainsi que la partie solo de clarinette dans la Sonate n° 1 de Brahms.
            Selon Sharon Kam, la partie de piano au début du premier mouvement a plus de substance et le clarinettiste doit donc comprendre quand son rôle est secondaire. De même, lorsque le piano a un contenu thématique, la clarinette doit créer des couleurs par la dynamique afin de soutenir le piano sans le dominer.
            Parmi les autres éléments abordés, citons le phrasé et le jeu naturel.");
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $masterclass->addMasterclassQuizz($masterclassQuizzPiano);
            $manager->persist($masterclass);

            $masterclass = new Masterclass();
            $masterclass->setTitle("String Quartet in G minor, 1st movement");
            $masterclass->setDescription("Dans cette masterclass, le professeur Clive Greensmith travaille avec le Quatuor Magenta sur les nuances et l'exagération des idées musicales dans le premier mouvement du Quatuor à cordes de Debussy. Il commence par un bref aperçu historique de la pièce qui aide à éclairer la façon d'aborder la prise de décision musicale. Il encourage l'ensemble à faire ressortir les détails de la pièce et à être confiant et clair dans ses idées musicales. Il leur offre plusieurs suggestions sur la façon d'utiliser des aspects techniques tels que le coup d'archet et la distribution, le vibrato et l'articulation pour faire ressortir le contraste dans la musique et mettre en évidence les caractères distincts des différentes sections. Greensmith aide également le groupe à maintenir un sentiment d'énergie et d'urgence sous-jacente tout au long du travail afin qu'il reste toujours passionnant, même dans les sections calmes ou calmes. Dans l'ensemble, il aide chaque joueur à mieux comprendre son rôle individuel, par exemple quand il doit diriger et quand il doit soutenir. Il enseigne également à l'ensemble comment créer plus de tension et de relâchement, comment jouer avec une forte résonance de groupe et comment réagir et s'équilibrer les uns avec les autres pour donner une performance engageante et excitante.");
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $masterclass->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclass);


            $masterclass = new Masterclass();
            $masterclass->setTitle("Sonate pour violoncelle et piano Nr. 2 en Fa Majeur, Op. 99, part 1");
            $masterclass->setDescription("Dans cette session, le professeur Martin Beaver aide les élèves Robin de Talhouët et Julie Haismann à perfectionner la belle, mais difficile Sonate Nr. 2 en Fa majeur, Op.99, 1er mouvement de Johann Brahms. Les deux musiciens recoivent des directions et conseils de la part de Martin Beaver car dans ce morceau, une grande collaboration entre le violoncelle et le piano est essentielle. 
            Selon le professeur, un des plus grands défis de cette Sonate et de ce mouvement en particulier est d y insuffler une qualité héroïque tout en gardant un lyrisme et une rondeur sans faille. Il faut en effet jouer avec cette étincelle de vie, cette énergie, tout en sachant que quelque chose de sombre se profile à l horizon. Le professeur donne également des conseils techniques aux élèves, comme de faire très attention aux expressions et accents que Brahms a choisi et écrit, ainsi que d essayer de ne perdre aucune note et de jouer les vibratos avec intensité. C'est un mouvement “qui va vers l extérieur” et beaucoup de mesures doivent être un peu exagérées. ");
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $masterclass->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclass);
            

            $masterclass = new Masterclass();
            $masterclass->setTitle("Fantaisie, Op. 38");
            $masterclass->setDescription("Le professeur Jacques Mauger et l'étudiant Victor Bufferne s'attaquent à la pièce de concours pour trombone Fantaisie, op. 27 du compositeur franco-polonais Zygmunt Stojowski. 
            Jacques Mauger insiste sur l'importance de jouer la pièce à son plein potentiel romantique en donnant plus de forme à la dynamique et à la musique dans son ensemble.  
            En outre, Bufferne est encouragée à prendre des risques malgré sa propension à se sentir intimidée ou nerveuse. Malgré l'anxiété de l'interprète, ajoute Mauger, le musicien doit déclarer quelque chose à propos de la pièce.");
            $masterclass->setCertification($faker->randomElement(['Débutant', 'Intérmédiaire', 'Avancé']));
            $masterclass->setVideo("https://www.youtube.com/watch?v=Dp2SJN4UiE4");
            $masterclass->setInstrument($randomInstrument);
            $masterclass->setComposer($randomComposer);
            $masterclass->addFormation($randomFormation);
            $masterclass->setUser($randomUser);
            $masterclass->addMasterclassQuizz($masterclassQuizzCompositeurs);
            $manager->persist($masterclass);



            //FunFact
            $funFact = new FunFact();
            $funFact->setName($faker->word);
            $funFact->setMasterclass($masterclass);
            $funfact_description = $faker->realText(20);
            $funFact->setDescription($funfact_description);
            $manager->persist($funFact);


            //Event
            $event = new Event();
            $event->setName("Concours international de chant Elizabeth Connell Prize");
            $event->setDescription("Elizabeth Connell était une soprano dramatique sud-africaine qui a atteint une renommée internationale grâce à ses performances tout au long de sa carrière. Elle a commencé sa carrière professionnelle en tant que mezzo-soprano avant de passer au soprano.");
            $event->setDateStart(new \DateTime("2023-09-24 15:30:00"));
            $event->setDateEnd(new \DateTime("2023-09-24 15:30:00"));
            $manager->persist($event);

            $event = new Event();
            $event->setName("Le Concours international de musique Reine Sonja");
            $event->setDescription("Le concours est organisé sous forme de fondation. Ses partenaires institutionnels sont l'Opéra national et le Ballet de Norvège, l'Académie norvégienne de musique, l'Académie nationale des arts d'Oslo et la Société norvégienne de radiodiffusion.");
            $event->setDateStart(new \DateTime("2023-09-24 15:30:00"));
            $event->setDateEnd(new \DateTime("2023-09-24 18:30:00"));
            $manager->persist($event);
      


            //  MasterclassesQuestions
            // $masterclassQuestion = new MasterclassQuestion();
            // $masterclassQuestion->setTitle($faker->realText(10));
            // $masterclassQuestion->setXpValue($faker->numberBetween(1, 100));
            // $masterclassQuestion->setProposition(['Bach', 'Mozart', 'Pachelbel', 'Beethoven']);
            // $masterclassQuestion->setAnswer($faker->randomElement(['Bach', 'Mozart', 'Pachelbel', 'Beethoven']));
            // $manager->persist($masterclassQuestion);

            
            } catch(\Throwable $e) {
                dump($e);
            }
        }
        
        $manager->flush();


        
    }
}
