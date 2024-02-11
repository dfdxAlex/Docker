<?php

/**
 * Z treści zadania zrozumiałem, że metoda szczotkowania 
 * zwierzęcia powinna istnieć tylko u tych zwierząt, 
 * które posiadają futro, dlatego została umieszczona w osobnej 
 * klasie. W mojej opinii, byłoby optymalnym rozwiązaniem 
 * umieszczenie tej metody w klasie abstrakcyjnej.
 */
/**
 * Klasa do czesania zwierzęcia
 */
class Groom
{
    public function __construct(private string $name)
    {
    }
    public function groomAnimal(): string {
            return "$this->name combed.\n<br>";
    }
}

abstract class Animal {
    /**
     * Zmienna zawiera odwołanie do obiektu, który potrafi czesać zwierzęta z futrem 
     * lub niczego, jeśli zwierzę nie ma futra.
     */
    protected $groom = null;
    /**
     * Konstruktor przyjmuje nazwę i typ zwierzęcia, 
     * trzeci parametr określa, czy do klasy należy umieścić obiekt poprzez kompozycję, 
     * który potrafi czesać zwierzęta z futrem.
     */
    public function __construct(protected string $type,
                                protected string $name,
                                protected bool $hasFur) 
    {
        if ($hasFur) $this->groom = new Groom($this->name);
    }

    public function groom(): void {
        /**
         * Próba wywołania metody groomAnimal() następuje w przypadku istnienia obiektu. 
         * Dzięki operatorowi ?-> nie zostanie nic wyświetlone, 
         * jeśli obiekt nie został utworzony.
         */
        echo $this->groom?->groomAnimal();
        /**
         * Próba czesania zwierzęcia bez futra spowoduje wyświetlenie
         * odpowiedniego komunikatu.
         */
        if (!$this->hasFur) {
            echo "$this->name has no fur\n<br>";
        }
    }

    /**
     * Metoda magiczna __toString() umożliwia wyświetlenie ciągu znaków podczas 
     * próby wydrukowania wartości za pomocą polecenia echo
     */
    public function __toString(): string {
        return "$this->type $this->name\n<br>";
    }
    
    abstract public function feed(string $food): void;
}

/**
 * Klasa do tworzenia drapieżników i ich karmienia.
 */
class Carnivore extends Animal {
    public function feed(string $food): void {
        if ($food === 'meat dish') {
            echo "$this->name ate a $food.\n<br>";
        } else {
            echo "$this->name doesn't eat $food.\n<br>";
        }
    }
}

/**
 * Klasa do tworzenia roślinożerców i ich karmienia.
 */
class Herbivore extends Animal {
    public function feed(string $food): void {
        if ($food === 'herbal dish') {
            echo "$this->name ate a $food.\n<br>";
        } else {
            echo "$this->name doesn't eat $food.\n<br>";
        }
    }
}

/**
 * Klasa do tworzenia wszystkożerców i ich karmienia.
 */
class Omnivore extends Animal {
    public function feed(string $food): void {
        if ($food === 'meat dish' || $food === 'herbal dish') {
            echo "$this->name ate a $food.\n<br>";
        } else {
            echo "$this->name doesn't eat $food.\n<br>";
        }
    }
}

/**
 * Z warunków zrozumiałem, że potrzebne są klasy do tworzenia 
 * konkretnych zwierząt. Dlatego tworzę fabrykę obiektów.
 */
class FactoryAnimal
{
    static public function createAnimal($type, $name)
    {
        return match($type) {
            "tiger" | "Tiger"                   => new Carnivore('Tiger',$name, true),
            "elephant" | "Elephant"             => new Herbivore('Elephant',$name, false),
            "rhinoceros" | "Rhinoceros"         => new Herbivore('Rhinoceros',$name, false),
            "fox" | "Fox"                       => new Omnivore('Fox',$name, true),
            "gentle leopard" | "Gentle leopard" => new Carnivore('Gentle leopard',$name, true),
            "rabbit" | "Rabbit"                 => new Herbivore('Rabbit',$name, true),
        };
    }
}

/**
 * W zadaniu nie ma wzmianki o konieczności posiadania metod do usuwania 
 * zwierząt oraz do wyświetlania listy wszystkich zwierząt w zoo, 
 * ale uznałem, że klasa byłaby niekompletna bez tych metod, 
 * dlatego je dodałem.
 */
class ZOO
{
    private $listZoo = [];

    public function addAnimalToZoo($animal)
    {
        $this->listZoo[] = $animal;
    }

    public function removeAnimalFromZoo($animal)
    {
        foreach($this->listZoo as $key=>$val) {
            if ($val == $animal) {
                unset ($this->listZoo[$key]);
                break;
            }
        }
    }
    public function listAnimals()
    {
        echo '<br><br>Lista zwierząt w zoo:<br>';
        foreach($this->listZoo as $val) {
            echo "$val";
        }
    }
}


$elephant = FactoryAnimal::createAnimal('elephant', 'Jack');
$tiger = FactoryAnimal::createAnimal('tiger', 'Ommo');
$rabbit = FactoryAnimal::createAnimal('rabbit', 'Ci');

echo $elephant; 
$elephant->feed('herbal dish'); 
$elephant->groom();

$zoo = new ZOO;
$zoo->addAnimalToZoo($elephant);
$zoo->addAnimalToZoo($tiger);
$zoo->addAnimalToZoo($rabbit);
// $zoo->removeAnimalFromZoo($elephant);
$zoo->listAnimals();



