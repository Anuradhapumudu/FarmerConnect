<?php

    // Disease reporting routes
    $routes->get('/disease', 'Disease::index');
    $routes->post('/disease/submit', 'Disease::submit');
    $routes->post('/disease/updateReport', 'Disease::updateReport');
    $routes->get('/disease/success/(:any)', 'Disease::success/$1');
    $routes->get('/disease/viewReports', 'Disease::viewReports');
    $routes->post('/disease/viewReports', 'Disease::viewReports');
    $routes->get('/disease/viewReport/(:any)', 'Disease::viewReport/$1');
    $routes->get('/disease/editReport/(:any)', 'Disease::editReport/$1');
    $routes->get('/disease/confirmDelete/(:any)', 'Disease::confirmDelete/$1');
    $routes->post('/disease/deleteReport/(:any)', 'Disease::deleteReport/$1');
    $routes->get('/disease/viewMedia/(:any)/(:any)', 'Disease::viewMedia/$1/$2');
?>