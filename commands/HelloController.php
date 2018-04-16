<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use Faker;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Shop;
use app\models\BusinessHours;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }


    /**
 * This command generates n-number of shops records in DB.
 * @param string $message the message to be echoed.
 * @return int Exit code
 */
    public function actionFake($n = 50)
    {

        $faker = Faker\Factory::create();

        for ($i=1;$i<=$n;$i++)
        {
            echo $i." | ";
            $shop = new Shop();

            $shop->shop_name = $faker->company." ".array_rand(["Store","Shop", "Market", "Boutique"],1);
            $shop->shop_address = $faker->address;
            $shop->shop_description = $faker->realText(180);

            if ($shop->save())
            {
                // randomly choose weather shop will work 5-7 days a week
                $working_days = rand(5, 7);
                $start_hour = (string)$faker->numberBetween(7,11).":00";
                $close_hour = (string)$faker->numberBetween(19,23).":00";
                for ($j=1;$j<=$working_days;$j++){


                    $businessHours = new BusinessHours();
                    $businessHours->shop_id = $shop->id;
                    $businessHours->weekday = $j;
                    $businessHours->start_hour = $start_hour;
                    $businessHours->close_hour = $close_hour;
                    $businessHours->save();
                }
            }
        }



        return ExitCode::OK;
    }
}
