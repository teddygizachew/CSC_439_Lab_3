<?php
require_once 'Main.php';
use PHPUnit\Framework\TestCase;

class AdventureControllerTest extends TestCase
{

    // write setup and teardowns
    // add different versions of suts for different tests
    // update the submitted assignment

    public function setUp() : void {
        $this->blank_challenge = new ChallengeModel("id", "intro", "trait", "level", "succeed_id", "fail_id",
            array(
                array("A"=> "equal_1_a","B"=> "equal_1_b"),
                array("A"=> "equal_2_a","B" => "equal_2_b"),
                array("A"=> "equal_3_a","B" => "equal_3_b")
            ),
            array(
                array("A"=> "advantage_1_a", "B"=> "advantage_1_b"),
                array("A"=> "advantage_2_a", "B" => "advantage_2_b"),
            ),
            array(
                array("A"=> "disadvantage_1_a", "B"=> "disadvantage_1_b"),
                array("A"=> "disadvantage_2_a", "B" => "disadvantage_2_b")
            )
        );
        $this->bus_challenge = new ChallengeModel(
            "bus_challenge",
            "You are attempting to catch the bus, but you are late, and it is pulling away from the stop.",
            "Speed",
            "HIGH",
            "seat_challenge",
            "_done",
            array(
                array("A"=> "You run as fast as you can, and you almost catch up to the bus.",
                    "B"=> "You run as fast as you can, but you can't seem to gain any ground catching up to the bus."
                ),
                array("A"=> "You run with all of your might, and the driver sees you in the mirror waving, and lets you on.",
                    "B" => "You step in a puddle and it slows you down.",
                ),
                array("A"=> "The bus pulls over out of pity and lets you on.",
                    "B" => "You couldn't catch up, the bus drives away."
                )
            ),
            array(
                array("A"=> "The bus is pulling away, but you are pretty fast and easily catch it.",
                    "B"=> "The bus is pulling away, and even though you are pretty fast, you can't seem to catch up."
                ),
                array("A"=> "Although harder than you expected, you put your head down and eventually catch up to the bus, getting on.",
                    "B"=>"You are surprised to find you are not as fast as you once were."
                )
            ),
            array(
                array("B"=> "The bus is pulling away, and you are far to slow to really catch it, and it drives out of sight.",
                    "A"=> "The bus is pulling away, and even though you are pretty slow, you seem to gain ground."
                ),
                array("B"=> "But try as you might, it eventually gets away.",
                    "A"=>"By some miracle, you actually flag down the driver to stop, and get on."
                )
            )
        );
        $this->bus_challenge2 = new ChallengeModel(
            "bus_challenge",
            "You are attempting to catch the bus, but you are late, and it is pulling away from the stop.",
            "Speed",
            "HIGH",
            "seat_challenge",
            "_done",
            array(
                array("A"=> "You run as fast as you can, and you almost catch up to the bus.",
                    "B"=> "You run as fast as you can, but you can't seem to gain any ground catching up to the bus."
                ),
                array("A"=> "You run with all of your might, and the driver sees you in the mirror waving, and lets you on.",
                    "B" => "You step in a puddle and it slows you down.",
                ),
                array("A"=> "The bus pulls over out of pity and lets you on.",
                    "B" => "You couldn't catch up, the bus drives away."
                )
            ),
            array(
                array("A"=> "The bus is pulling away, but you are pretty fast and easily catch it.",
                    "B"=> "The bus is pulling away, and even though you are pretty fast, you can't seem to catch up."
                ),
                array("A"=> "Although harder than you expected, you put your head down and eventually catch up to the bus, getting on.",
                    "B"=>"You are surprised to find you are not as fast as you once were."
                )
            ),
            array(
                array("B"=> "The bus is pulling away, and you are far to slow to really catch it, and it drives out of sight.",
                    "A"=> "The bus is pulling away, and even though you are pretty slow, you seem to gain ground."
                ),
                array("B"=> "But try as you might, it eventually gets away.",
                    "A"=>"By some miracle, you actually flag down the driver to stop, and get on."
                )
            )
        );
    }

    public function test_class_attributes(){

        $bro = new BinaryRandomOracle(new RNG());
        $character = new CharacterModel($bro, "teddy", 0);
        $database = array();
        // create sut
        $sut = new AdventureController($character, $database);

        // verify the results
        // $this->assertClassHasAttribute("character", AdventureController::class);
        // $this->assertClassHasAttribute("challenge_database", AdventureController::class);

        $this->assertEquals("teddy", $sut->get_character()->get_name());
        $this->assertEquals($database, $sut->get_challenge_database());

    }

    public function test_add_challenge_unique_id() {

        $this->expectException(InvalidArgumentException::class);

        $bro = new BinaryRandomOracle(new RNG());
        $character = new CharacterModel($bro, "teddy", 0);
        $database = array();
        $sut = new AdventureController($character, $database);

        $sut->add_challenge($this->bus_challenge);
        $sut->add_challenge($this->bus_challenge);


    }

    public function test_add_challenge_id_check() {

        $this->expectException(InvalidArgumentException::class);

        $bro = new BinaryRandomOracle(new RNG());
        $character = new CharacterModel($bro, "teddy", 0);
        $database = array();
        $sut = new AdventureController($character, $database);

        $bad_challenge = new ChallengeModel("_end", "", "", "", "", "", array(), array(), array());
        $sut->add_challenge($bad_challenge);
    }

    public function test_add_challenge_morethan_5() {
        $bro = new BinaryRandomOracle(new RNG());
        $character = new CharacterModel($bro, "teddy", 0);
        $database = array();
        $sut = new AdventureController($character, $database);

        $bad_challenge = new ChallengeModel("0", "", "", "", "", "", array(), array(), array());
        $bad_challenge1 = new ChallengeModel("1", "", "", "", "", "", array(), array(), array());
        $bad_challenge2 = new ChallengeModel("2", "", "", "", "", "", array(), array(), array());
        $bad_challenge3 = new ChallengeModel("3", "", "", "", "", "", array(), array(), array());
        $bad_challenge4 = new ChallengeModel("4", "", "", "", "", "", array(), array(), array());
        $bad_challenge5 = new ChallengeModel("5", "", "", "", "", "", array(), array(), array());

        $sut->add_challenge($bad_challenge);
        $sut->add_challenge($bad_challenge1);
        $sut->add_challenge($bad_challenge2);
        $sut->add_challenge($bad_challenge3);
        $sut->add_challenge($bad_challenge4);
        $sut->add_challenge($bad_challenge5);


        $this->assertCount(5, $sut->get_challenge_database());
    }

    public function test_validate_adventure_no_start() {
        // setup the sut
        $bro = new BinaryRandomOracle(new RNG());
        $character = new CharacterModel($bro, "teddy", 0);
        $database = array();
        $sut = new AdventureController($character, $database);
        $sut->add_challenge($this->blank_challenge);

        // call the method
        $result = $sut->validate_adventure();

        // verify the result
        $this->assertFalse($result);

        // making this a stateful test
        // add something else
        $sut->add_challenge(new ChallengeModel("_start", "intro", "trait", "level", "succeed_id", "fail_id",
            array(
                array("A"=> "equal_1_a","B"=> "equal_1_b"),
                array("A"=> "equal_2_a","B" => "equal_2_b"),
                array("A"=> "equal_3_a","B" => "equal_3_b")
            ),
            array(
                array("A"=> "advantage_1_a", "B"=> "advantage_1_b"),
                array("A"=> "advantage_2_a", "B" => "advantage_2_b"),
            ),
            array(
                array("A"=> "disadvantage_1_a", "B"=> "disadvantage_1_b"),
                array("A"=> "disadvantage_2_a", "B" => "disadvantage_2_b")
            )
        ));

        // call the method
        $result = $sut->validate_adventure();

        // verify the result
        $this->assertTrue($result);

        // if this was java, this wouldn't compile
        // php - dynamically typed language .. would give compile error
        // implied requirement that it must return true if there is "_start"
    }

    public function test_validate_adventure_no_end_state() {
        // setup the sut
        $bro = new BinaryRandomOracle(new RNG());
        $character = new CharacterModel($bro, "teddy", 0);
        $database = array();
        $sut = new AdventureController($character, $database);

        // making this a stateful test
        // add something else
        $sut->add_challenge(new ChallengeModel("_start", "intro", "trait", "level", "succeed_id", "fail_id",
            array(
                array("A"=> "equal_1_a","B"=> "equal_1_b"),
                array("A"=> "equal_2_a","B" => "equal_2_b"),
                array("A"=> "equal_3_a","B" => "equal_3_b")
            ),
            array(
                array("A"=> "advantage_1_a", "B"=> "advantage_1_b"),
                array("A"=> "advantage_2_a", "B" => "advantage_2_b"),
            ),
            array(
                array("A"=> "disadvantage_1_a", "B"=> "disadvantage_1_b"),
                array("A"=> "disadvantage_2_a", "B" => "disadvantage_2_b")
            )
        ));

        // call the method
        $result = $sut->validate_adventure();

        // verify the result
        $this->assertTrue($result);

    }

}


?>