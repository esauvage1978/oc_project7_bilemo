<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Validator\ProductValidator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    /**
     * @var ProductValidator
     */
    private $productValidator;

    public function __construct(ProductValidator $productValidator)
    {
        $this->productValidator = $productValidator;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < count(self::DATA); ++$i) {
            $product = new Product();

            $product->setWeight(rand(10, 1000));
            $product->setContent(self::DATA[$i]['content']);
            $product->setAvailableAt($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'Europe/Paris'));
            $product->setRef(self::DATA[$i]['ref']);
            $product->setName(self::DATA[$i]['name']);

            if (!$this->productValidator->isValide($product)) {
                throw  new \InvalidArgumentException($this->productValidator->getErrors($product));
            }

            $manager->persist($product);
        }
        $manager->flush();
    }

    const DATA =
        [
            [
                'name' => 'Samsung Galaxy Note 10 Plus',
                'content' => 'Esthétiquement, le Samsung Galaxy Note 10 Plus est une vraie réussite. À l’avant, toute la place est réservée à sa magnifique dalle OLED (considérée comme la meilleure du marché selon DisplayMate et notre test), où les bordures extrêmement fines donnent plus l’impression de tenir dans les mains un téléviseur miniature qu’un véritable smartphone',
                'ref' => 'N10+',
            ],
            [
                'name' => 'Huawei P30 Pro',
                'content' => 'Le P30 Pro est la meilleure alternative au Galaxy S10. C’est une solution également très complète qui pourra répondre sans aucun doute à la majorité des usages. S’il est également très polyvalent, Huawei a surtout mis l’accent sur la photo, ce qui a imposé quelques concessions',
                'ref' => 'P30P',
                ],
            [
                'name' => 'OnePlus 7T',
                'content' => 'C’est le OnePlus 7 Pro qui a lancé l’écran 90 Hz chez OnePlus, et si la marque n’a pas été la première  à intégrer la technologie, elle l’a mise en lumière. Autrefois réservée au modèle Pro, elle descend sur le modèle classique de cette mi-année : le OnePlus 7T. Rendant au passage la version Pro moins intéressante, qui ne mérite donc plus vraiment que l’on s’y attarde, sauf a absolument vouloir un écran sans encoche.',
                'ref' => 'O7T',
            ],
            [
                'name' => 'iPhone 11',
                'content' => 'Apple conserve encore et toujours une place de choix sur le segment des mobiles haut de gamme. Si l’iPhone 11 Pro est indéniablement excellent, nous lui préférons l’iPhone 11 « tout court », qui offre selon nous le meilleur rapport qualité-prix de la cuvée 2019-2020 d’Apple. Vous perdrez certes l’écran Amoled et le troisième capteur photo, mais vous avez tout le reste.',
                'ref' => 'IP11',
            ],
            [
                'name' => 'Google Pixel 4 XL',
                'content' => 'Le Google Pixel 4 XL profite de la même configuration photo que son petit frère le Pixel 4. Toutefois, l’autonomie de ce dernier est trop juste pour que nous puissions le conseiller, ainsi nous vous recommandons plutôt de vous tourner vers le modèle le plus grand.',
                'ref' => '4XL',
            ],
            [
                'name' => 'Apple iphone 11 PRO',
                'content' => 'L’iPhone 11 Pro d’Apple apporte des évolutions intéressantes au niveau de l’appareil photo par rapport à son prédécesseur. !Il se dote en effet de plus de capteurs photo qui lui permettent d’avoir une meilleure polyvalence en termes de prises de vue. Vous pouvez ainsi vous amusez à prendre des clichés classiques, des images en zoom x2 et d’autres en ultra grand-angle.',
                'ref' => 'IP11P',
            ],
            [
                'name' => 'Google Pixel 3a/3a XL',
                'content' => 'ors de la conférence Google I/O 2019, la firme de Mountain View a dévoilé les deux déclinaisons abordables de ses flagships de 2018. Baptisés Pixel 3a et Pixel 3a XL, ces nouveaux smartphones promettent une chose (à part leur prix intéressant) : une expérience photo digne des smartphones les plus premium.',
                'ref' => '3XL',
            ],
            [
                'name' => 'Samsung Galaxy S10e',
                'content' => 'Aux côtés des Galaxy S10 et S10 Plus, Samsung a ajouté un troisième modèle bien plus compact à cette nouvelle famille : le Galaxy S10e. Totalement borderless, il intègre un écran Dynamic AMOLED de 5,8 pouces (avec une définition maximale Full HD+ de 2280 x 1080 pixels) dans un format plus qu’agréable en main grâce à ses dimensions modérées.',
                'ref' => 'S10e',
            ],
            [
                'name' => 'Xiaomi Mi 9 SE',
                'content' => 'Le Xiaomi Mi 9 SE conserve globalement le design de son aîné, mais dans un format légèrement plus compact. En effet, l’écran AMOLED — toujours équipé d’un capteur d’empreintes optique — propose une diagonale plus petite (5,97 pouces contre 6,39 pouces) et conserve la même encoche en forme de goutte d’eau. De ce fait, cette version allégée du fleuron chinois est plus agréable en main, ce qui est idéal pour éviter la gymnastique des doigts au quotidien.',
                'ref' => 'Mi9',
            ],
            [
                'name' => 'Xiaomi Mi A2 Lite',
                'content' => 'Version allégée du Mi A2, ce modèle « Lite » possède certes une fiche technique plus minimaliste que son aîné, mais son format est bien plus agréable en main. Tout d’abord, son écran de 5,86 pouces est borderless — néanmoins avec une encoche — et adopte le format 19:9, ce qui donne un résultat plus affiné que le ratio 18:9. Ensuite, son gabarit de 71,7 mm X 149,3 mm X 8,8 mm se trouve dans la veine de ce qui est globalement proposé dans ce guide, mais force est de constater qu’il est plus lourd que ses concurrents (178 grammes contre 150 grammes pour le Galaxy S10e, par exemple).',
                'ref' => 'MiA2',
            ],
            [
                'name' => 'Asus Zenfone 6',
                'content' => 'L’évolution du Zenfone 6 se fait clairement ressentir par rapport à son prédécesseur. Le changement est notamment visible sur le design avec en premier lieu cet écran borderless sans encoche et de belles finitions pour un ensemble très premium. Cependant, il se distingue surtout par son autonomie pour occuper aujourd’hui la première place du podium. Sa grosse batterie de 5 000 mAh fait tout simplement des miracles au quotidien. Sur notre test personnalisé viSer, il a tenu 13 heures et 36 minutes avant de tomber en dessous des 10%',
                'ref' => 'AZ6',
            ],
            [
                'name' => 'Honor 20 Pro',
                'content' => 'omparé au Honor 20 classique, ce modèle Pro a revu sa batterie à la hausse. Au lieu de 3 750 mAh, la batterie du Honor 20 Pro pousse la barre pour atteindre une capacité de 4 000 mAh. 250 mAh de plus, c’est peu, mais ne vous fiez pas aux apparences. Sur notre test personnalisé viSer, le modèle Pro a tenu 13 heures et 24 minutes alors que le modèle classique avait tenu 11 heures et 22 minutes',
                'ref' => 'H20P',
            ],
            [
                'name' => 'Samsung Galaxy A70',
                'content' => 'Samsung a remis à plat sa gamme A en 2019 avec notamment le Galaxy A70. Un smartphone au grand écran de 6,67 pouces qui jouit d’une autonomie en adéquation avec sa diagonale : le smartphone a presque tenu 13h sur viSer. 12 heures et 58 minutes très exactement.',
                'ref' => 'A70',
            ],
            [
                'name' => 'Xiaomi Mi 9T Pro',
                'content' => 'Esthétiquement, le Xiaomi Mi 9T Pro est une copie conforme du modèle de base sorti un peu plus tôt. Il conserve par ailleurs la très bonne batterie de 4 000 mAh du Mi 9T original, ce qui lui permet de tenir lui aussi pendant minimum deux jours malgré un processeur plus énergivore. On note toutefois qu’il est compatible avec la charge rapide jusqu’à 27 W, mais n’est livré qu’avec un chargeur de 18 W. Sur notre test personnalisé viSer, il a réussi à tenir 12 heures et 51 minutes.',
                'ref' => 'Mi9Tp',
            ],
            [
                'name' => 'Redmi Note 7',
                'content' => 'Si la famille Redmi Note est connue pour son autonomie impressionnante, le Xiaomi Redmi Note 7 ne déroge pas à la règle. Avec sa batterie de 4 000 mAh il a atteint 12 heures et 37 minutes sur notre test viSer. Le meilleur smartphone d’entrée de gamme de 2019 pour le moment. Toujours aussi efficace, malgré des composants plus gourmands qu’auparavant (notamment avec la présence du Snapdragon 660 au lieu du 636).',
                'ref' => 'RN7',
            ],
            [
                'name' => 'Oppo Reno 2',
                'content' => 'Avec son Reno 2, Oppo est arrivé à maturité. La firme chinoise réussit à proposer un smartphone bien équilibré avec un petit supplément d’âme grâce au fameux aileron que l’on retrouvait sur le Reno premier du nom. C’est un peu particulier au 1er abord, mais c’est un élément distinctif sympathique au second abord.',
                'ref' => 'OR2',
            ],
            [
                'name' => 'Samsung Galaxy A50',
                'content' => 'Dévoilé lors du Mobile World Congress 2019 à Barcelone, le Samsung Galaxy A50 fait partie des nouveaux smartphones de milieu de gamme du constructeur coréen. Cette nouvelle itération a le mérite de se rapprocher d’un aspect résolument premium, notamment en intégrant des éléments habituellement réservés aux smartphones les plus haut de gamme. De ce fait, ce n’est pas étonnant de retrouver un capteur d’empreintes sous son bel écran Super AMOLED de 6,4 pouces, ou encore un triple capteur photo de 25 + 5 + 8 mégapixels en tant qu’appareil photo principal.',
                'ref' => 'A50',
            ],
            [
                'name' => 'Xiaomi Redmi Note 8 Pro',
                'content' => 'À défaut d’avoir un Xiaomi Redmi Note 8 classique dans nos contrées, nous avons droit à sa version « Pro » et ce n’est pas pour nous déplaire. Ils partagent par ailleurs sensiblement le même design. On retrouve évidemment l’encoche en forme de goutte d’eau, mais son écran IPS LCD se veut légèrement plus grand (6,53 contre 6,3 pouces). L’un comme l’autre affiche toutefois une définition Full HD+ de 2 340 x 1 080 pixels. La différence vient surtout de son module photo au dos. Sur le modèle classique, il est placé sur la partie supérieure gauche alors qu’on le retrouve au centre sur le Note 8 Pro.',
                'ref' => 'N8P',
            ],
            [
                'name' => 'Samsung Galaxy A40',
                'content' => 'Si vous avez suivi l’actualité sur FrAndroid, vous êtes censés savoir que Samsung a totalement remanié sa gamme Galaxy A avec de nombreuses nouvelles références, dont le Samsung Galaxy A40. D’ailleurs, c’est à ce jour le seul smartphone coréen (de 2019) à s’afficher entre 200 et 300 euros. Si cela représente forcément une des raisons de sa présence dans ce guide, il a surtout gagné sa place grâce à sa fiche technique bien équilibrée et son interface One UI très plaisante.',
                'ref' => 'A40',
            ],
            [
                'name' => 'Xiaomi Mi A3',
                'content' => 'Le Xiaomi Mi A3 est le dernier smartphone en date du célèbre constructeur chinois à appartenir au label Android One. Cette interface a la particularité de proposer une expérience utilisateur épurée et simplifiée, comme Google l’a conçu initialement, tout en garantissant 2 ans de mises à jour majeures et 3 ans de mises à jour de sécurité. Un argument qui fait la différence, surtout pour celles et ceux qui ne sont pas attirés par MIUI et qui aimeraient tout de même bénéficier de l’excellent rapport qualité/prix de Xiaomi.',
                'ref' => 'MiA3',
            ],
            [
                'name' => 'Huawei P Smart Z',
                'content' => 'La gamme P Smart de Huawei continue son chemin avec une nouvelle itération : le Huawei P Smart Z. Si ses prédécesseurs se ressemblaient tous entre eux, force est de constater que le constructeur chinois a fait de gros efforts au niveau du design pour enfin proposer quelque chose de différent sur ce segment. En effet, il a la particularité de proposer un écran totalement borderless. Il contourne l’encoche (ou la bulle/trou/poinçon) en intégrant une caméra pop-up qui s’ouvre automatiquement en sélectionnant l’appareil photo.',
                'ref' => 'PSZ',
            ],
        ];
}
