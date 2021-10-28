<?php


require_once 'vendor/autoload.php';

use App\Datasource;
use App\Model\AgencyModel;


$faker = Faker\Factory::create();

$datasource = new Datasource();
$agency = new AgencyModel($datasource);

for ($i = 0; $i < 1000; $i++) {
    $sqlShow = "INSERT into tbshow (cep, thumbnail, title, description, address, start_date, end_date, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sqlTicket = "INSERT into tbticket (description, price, qtd_ticket, show_id)  VALUES (?, ?, ?, ?)";
    $show = [
        'cep' => '89160075',
        'thumbnail' => 'gROwKSUqZW.png',
        'title' => $faker->text(50),
        'description' => $faker->text(),
        'address' => $faker->text(10),
        'start_date' => '2021-10-25 00:00:00',
        'end_date' => '2021-10-26 00:00:00', 
        'user_id' => 5
    ];
    $ticket = [
        [
            'description' => $faker->text(),
            'price' => $faker->randomNumber(5, false),
            'qtd_ticket' => $faker->randomNumber(5, false)
        ]
    ];
    $agency->createShow($show, $ticket);
}






