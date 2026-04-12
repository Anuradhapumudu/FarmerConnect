<?php

    // Complaint routes
    $routes->get('/complaint', 'Complaint::index');
    $routes->post('/complaint/submit', 'Complaint::submit');
    $routes->post('/complaint/updateReport', 'Complaint::updateReport');
    $routes->get('/complaint/success/(:any)', 'Complaint::success/$1');
    $routes->get('/complaint/myComplaints', 'Complaint::myComplaints');
    $routes->post('/complaint/myComplaints', 'Complaint::myComplaints');
    $routes->get('/complaint/viewReports', 'Complaint::viewReports');
    $routes->post('/complaint/viewReports', 'Complaint::viewReports');
    $routes->get('/complaint/viewComplaint/(:any)', 'Complaint::viewComplaint/$1');
    $routes->get('/complaint/viewReport/(:any)', 'Complaint::viewReport/$1');
    $routes->get('/complaint/editReport/(:any)', 'Complaint::editReport/$1');
    $routes->post('/complaint/deleteReport/(:any)', 'Complaint::deleteReport/$1');
    $routes->get('/complaint/deleteReport/(:any)', 'Complaint::deleteReport/$1');
    $routes->post('/complaint/updateReportStatus', 'Complaint::updateReportStatus');
    $routes->post('/complaint/submitRecommendation', 'Complaint::submitRecommendation');
    $routes->post('/complaint/updateRecommendation', 'Complaint::updateRecommendation');
    $routes->get('/complaint/deleteRecommendation/(:any)', 'Complaint::deleteRecommendation/$1');
    $routes->get('/complaint/viewMedia/(:any)/(:any)', 'Complaint::viewMedia/$1/$2');
    $routes->get('/complaint/viewResponseMedia/(:any)/(:any)', 'Complaint::viewResponseMedia/$1/$2');

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