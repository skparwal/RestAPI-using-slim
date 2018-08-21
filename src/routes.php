<?php

//Recipients
$app->get('/recipients', 'RecipientController:index');
$app->post('/recipients', 'RecipientController:add');
$app->delete('/recipients/[{id:[0-9]+}]', 'RecipientController:delete');

//Special Offers
$app->get('/specialoffers', 'SpecialofferController:index');
$app->post('/specialoffers', 'SpecialofferController:add');
$app->delete('/specialoffers/[{id:[0-9]+}]', 'SpecialofferController:delete');

//Vouchers
$app->get('/', 'VoucherController:listing');
$app->get('/vouchers', 'VoucherController:index');
$app->post('/vouchers', 'VoucherController:add');
$app->post('/vouchers/reedim', 'VoucherController:reedim');
$app->delete('/vouchers/[{id:[0-9]+}]', 'VoucherController:delete');