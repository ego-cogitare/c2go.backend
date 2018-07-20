<?php

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventProposal;
use App\Models\EventRequest;
use App\Models\Category;
use App\Models\User;

class EventsSeeder extends Seeder
{
    const NAMES = [
        'Adorn Your Occasion',
        'Beyond The Décor',
        'Chasing Perfection',
        'CreativeCorner',
        'Dream Creations',
        'Dream Organizers',
        'Dreams Come True',
        'DreamTeam',
        'Elegant Outcomes',
        'Elegant Planners',
        'Event Planning Experts',
        'FabFunctions',
        'Fast n\' Furious',
        'Fete n\' Fiesta',
        'Helping Hand',
        'It\'s All In The Details',
        'Last Moment Savers',
        'Lucky Charms',
        'Make It Happen',
        'Make Your Day',
        'Mapping Roads to Attainment',
        'Maverick Helpers',
        'MemoriesMade',
        'Occasions on the go',
        'Sculpted Designs',
        'Seize The Day',
        'Strategic Planners',
        'Stress Savers',
        'Style Organizers',
        'Style Savvy',
        'The Big Bash',
        'The Big Night',
        'The Big Picture',
        'The Classy Events',
        'The Magic Touch',
        'Your Planning Checklist',
        'Unique Planners',
        'We Manage Better',
        'Your Event Guide',
        'Your Planning Guardian',
        'Your Way To Enchantment',
    ];
    
    const PHRASES = [
        'Armut ist keine Schande',
        'sich abmühen wie der Fisch auf dem Trocknen',
        'auf Wolke sieben sein auf Wolke sieben schweben',
        'Das steht noch in den Sternen',
        'Da liegt der Hase im Pfeffer!',
        'Einen Bärenhunger haben',
        'Er hat Geld wie Heu',
        'Das Herz fiel [rutschte] ihm in die Hose',
        'sich etw. hinter die Ohren schreiben Schreib dir das hinter die Ohren!',
        'Was ist ihm in die Krone gefahren? (ihm ist eine Laus über die Leber gelaufen)',
        'wie weggeblasen, wie weggewischt',
        'wie gegen eine Wand reden',
        'Das ist ein Tropfen auf den heißen Stein',
        'Den Teufel mit Beelzebub austreiben ein Keil treibt den anderen',
        'wenn die Hunde mit dem Schwanz bellen',
        'Es gießt wie aus Kannen',
        'Die Welt ist ein Dorf',
        'das Kind beim rechten Namen nennen',
        'Schlafende Hunde soll man nicht wecken',
        'Sei kein Frosch!',
        'Wo Rauch ist, ist auch Feuer',
        'das ist völlig fehl am Platze',
        'Er hat das Pulver nicht erfunden',
        'Sie gleichen einander wie ein Ei dem anderen',
        'leeres Stroh dreschen',
        'wenn Ostern und Pfingsten auf einen Tag fallen',
        'voll wie eine Strandhaubitze',
        'mit j-m ist nicht gut Kirschen essen',
        'ein alter Hase',
        'zwei Fliegen mit einer Klappe schlagen',
        'wie die Katze um den heißen Brei gehen',
        'ein Sturm im Wasserglas',
        'j-n an der Nase herumführen',
        'Da liegt der Hund begraben',
        'Mit dem linken Fuß zuerst aufgestanden sein Du bist heute mit dem linken Bein aufgestanden',
        'Einem geschenkten Gaul sieht man nicht ins Maul',
        'aus einer Mücke einen Elefanten machen',
        'die Ehrensache',
        'wie Hund und Katze leben',
        'mit dem Feuer spielen',
        'das Spiel ist (nicht) die Kerzen wert',
        'Wie zweimal zwei vier ist',
        'die Katze im Sack kaufen',
        'Die Dinge beim rechten Namen nennen. ',
        'stumm wie ein Fisch',
        'die Kehrseite der Medaille',
        'j-m goldene Berge versprechen',
        'Brücken hinter sich abbrechen',
        'Creme der Gesellschaft',
        'fleißig wie eine Biene sein',
        'das tägliche Brot',
        'Der Apfel fällt nicht weit vom Stamm',
    ];
    
    const CITIES = [
        'Berlin',
        'Hamburg',
        'München',
        'Köln',
        'Frankfurt',
        'Essen',
        'Dortmund',
        'Stuttgart',
        'Düsseldorf',
        'Bremen',
        'Hannover',
        'Duisburg',
        'Nürnberg',
        'Leipzig',
        'Dresden',
        'Bochum',
        'Wuppertal',
        'Bielefeld',
        'Bonn',
        'Mannheim',
        'Karlsruhe',
        'Gelsenkirchen',
        'Wiesbaden',
        'Münster',
        'Mönchengladbach',
        'Chemnitz',
        'Augsburg',
        'Braunschweig',
        'Aachen',
        'Krefeld',
        'Halle',
        'Kiel',
        'Magdeburg',
        'Oberhausen',
        'Lübeck',
        'Freiburg',
        'Hagen',
        'Erfurt',
        'Kassel',
        'Rostock',
        'Mainz',
        'Hamm',
        'Saarbrücken',
        'Herne',
        'Mülheim',
        'Solingen',
        'Osnabrück',
        'Ludwigshafen',
        'Leverkusen',
        'Oldenburg',
        'Neuss',
        'Paderborn',
        'Heidelberg',
        'Darmstadt',
        'Potsdam',
        'Würzburg',
        'Göttingen',
        'Regensburg',
        'Recklinghausen',
        'Bottrop',
        'Wolfsburg',
        'Heilbronn',
        'Ingolstadt',
        'Ulm',
        'Remscheid',
        'Pforzheim',
        'Bremerhaven',
        'Offenbach',
        'Fürth',
        'Reutlingen',
        'Salzgitter',
        'Siegen',
        'Gera',
        'Koblenz',
        'Moers',
        'Bergisch Gladbach',
        'Cottbus',
        'Hildesheim',
        'Witten',
        'Zwickau',
        'Erlangen',
        'Iserlohn',
        'Trier',
        'Kaiserslautern',
        'Jena',
        'Schwerin',
        'Gütersloh',
        'Marl',
        'Lünen',
        'Esslingen',
        'Velbert',
        'Ratingen',
        'Düren',
        'Ludwigsburg',
        'Wilhelmshaven',
        'Hanau',
        'Minden',
        'Flensburg',
        'Dessau',
        'Villingen-Schwenningen',
    ];
    
    const MAX_ITERATIONS = 10;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::/*whereNotNull('parent_id')->*/where('is_active', 1)->pluck('id')->toArray();
        
        if (sizeof($categories) === 0) {
            throw new Exception('Categories table is empty');
        }
        
        $users = User::all()->pluck('id')->toArray();
        
        if (sizeof($users) === 0) {
            throw new Exception('Users table is empty');
        }
        
        for ($i = 0; $i < 2000; $i++) 
        {
            $user_id = $users[array_rand($users)];
            
            // Create a new event or get random one
            if (rand(1, 4) === 3 || Event::count() === 0) 
            {
                $event = Event::create([
                    'category_id' => $categories[array_rand($categories)],
                    'user_id' => $user_id, 
                    'name' => self::NAMES[array_rand(self::NAMES)], 
                    'destination' => self::CITIES[array_rand(self::CITIES)],
                    'destination_latlng' => '{}',
                    'dispatch' => self::CITIES[array_rand(self::CITIES)],
                    'dispatch_latlng' => '{}',
                    'date' => date('Y-m-d H:i:s', time() + rand(36, 1200) * 3600),
                    'is_top' => rand(1, 30) === 30,
                    'is_active' => 1
                ]);
            }
            else 
            {
                $event = Event::all()->random(1)->first();
            }
            
            $iteration = 0;
            while (EventProposal::where(['event_id' => $event->id, 'user_id' => $user_id])->first()) {
                $user_id = $users[array_rand($users)];
                $iteration++;
                if ($iteration === self::MAX_ITERATIONS) {
                    break;
                }
            }
            
            if ($iteration < self::MAX_ITERATIONS) {
                $event_proposal = EventProposal::create([
                    'event_id' => $event->id,
                    'user_id' => $user_id,
                    'tickets_bought' => rand(0, 1),
                    'price' => rand(1, 1000),
                    'message' => self::PHRASES[array_rand(self::PHRASES)],
                    'description' => self::PHRASES[array_rand(self::PHRASES)],
                    'url' => 'http://' . crc32(rand(0, 10000)) . '.com/event-about/' . rand(100, 10000)
                ]);

                // Create event request for the proposal
                EventRequest::create([
                    'event_proposals_id' => $event_proposal->id,
                    'user_id' => $users[array_rand($users)],
                    'message' => self::PHRASES[array_rand(self::PHRASES)],
                ]);
            }
        }
    }
}
