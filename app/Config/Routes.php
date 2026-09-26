<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('admin', 'Home::admin');
$routes->post('admin', 'Home::admin');


$routes->post('task-manager', 'TaskManager::index');
$routes->get('task-manager', 'TaskManager::index');
$routes->get('task-manager/data', 'TaskManager::data');

// -----------------------------------------------------------------------------
// Projects
// -----------------------------------------------------------------------------

$routes->post('task-manager/projects', 'TaskManager::createProject');
$routes->put('task-manager/projects/(:num)', 'TaskManager::updateProject/$1');
$routes->delete('task-manager/projects/(:num)', 'TaskManager::deleteProject/$1');


// -----------------------------------------------------------------------------
// Task Categories
// -----------------------------------------------------------------------------

$routes->post(
    'task-manager/categories',
    'TaskManager::createCategory'
);

$routes->put(
    'task-manager/categories/(:num)',
    'TaskManager::updateCategory/$1'
);

$routes->delete(
    'task-manager/categories/(:num)',
    'TaskManager::deleteCategory/$1'
);


// -----------------------------------------------------------------------------
// Tasks
// -----------------------------------------------------------------------------

$routes->post(
    'task-manager/tasks',
    'TaskManager::createTask'
);

$routes->put(
    'task-manager/tasks/(:num)',
    'TaskManager::updateTask/$1'
);

$routes->delete(
    'task-manager/tasks/(:num)',
    'TaskManager::deleteTask/$1'
);


// -----------------------------------------------------------------------------
// Markdown TASKS.md Import
// -----------------------------------------------------------------------------

$routes->post(
    'task-manager/tasks/import',
    'TaskManager::importTasks'
);


// Team directory
// Phase 3: People / Teams
$routes->get('task-manager/team', 'Team::index');
$routes->post('task-manager/team', 'Team::create');
$routes->post('task-manager/team/(:num)', 'Team::update/$1');
$routes->delete('task-manager/team/(:num)', 'Team::delete/$1');

$routes->get('task-manager/team','Team::index');
$routes->post('task-manager/team','Team::create');
$routes->post('task-manager/team/(:num)','Team::update/$1');
$routes->delete('task-manager/team/(:num)','Team::delete/$1');


// Project membership
$routes->get(
    'task-manager/projects/(:num)/members',
    'Team::projectMembers/$1'
);

$routes->post(
    'task-manager/projects/(:num)/members',
    'Team::addProjectMember/$1'
);

$routes->delete(
    'task-manager/projects/(:num)/members/(:num)',
    'Team::removeProjectMember/$1/$2'
);

// Task assignments / avatar stacks
$routes->get(
    'task-manager/projects/(:num)/assignments',
    'Team::projectAssignments/$1'
);

$routes->put(
    'task-manager/tasks/(:num)/assignees',
    'Team::assignTask/$1'
);

// Phase 3: People / Teams

$routes->get('task-manager/projects/(:num)/members','Team::projectMembers/$1');
$routes->post('task-manager/projects/(:num)/members','Team::addProjectMember/$1');
$routes->delete('task-manager/projects/(:num)/members/(:num)','Team::removeProjectMember/$1/$2');

$routes->get('task-manager/projects/(:num)/assignments','Team::projectAssignments/$1');
$routes->put('task-manager/tasks/(:num)/assignees','Team::assignTask/$1');

// Phase 3: Schedule
$routes->get('task-manager/schedule','Schedule::index');
$routes->post('task-manager/schedule','Schedule::create');
$routes->put('task-manager/schedule/(:num)','Schedule::update/$1');
$routes->delete('task-manager/schedule/(:num)','Schedule::delete/$1');

$routes->get('task-manager/activity', 'Activity::index');

$routes->put('task-manager/team/(:num)/projects', 'Team::syncMemberProjects/$1');

// Merge into app/Config/Routes.php.

$routes->group('task-manager/ai', static function ($routes) {
    $routes->post('projects/(:num)/ask', 'ProjectIntelligence::ask/$1');
    $routes->post('projects/(:num)/brief', 'ProjectIntelligence::brief/$1');
    $routes->post('projects/(:num)/recommend-assignee', 'ProjectIntelligence::recommendAssignee/$1');

    $routes->post('tasks/(:num)/breakdown', 'ProjectIntelligence::breakdownTask/$1');
    $routes->post('tasks/(:num)/accept-subtasks', 'ProjectIntelligence::acceptSubtasks/$1');

    $routes->put('suggestions/(:num)/review', 'ProjectIntelligence::reviewSuggestion/$1');
});


// Merge these routes into app/Config/Routes.php.
$routes->get('task-manager/meetings', 'Meetings::index');
$routes->get('task-manager/meetings/(:num)', 'Meetings::show/$1');
$routes->post('task-manager/meetings', 'Meetings::create');
$routes->put('task-manager/meetings/(:num)', 'Meetings::update/$1');
$routes->delete('task-manager/meetings/(:num)', 'Meetings::delete/$1');
$routes->post('task-manager/meetings/(:num)/transcripts', 'Meetings::saveTranscript/$1');
$routes->post('task-manager/meetings/(:num)/analyze', 'Meetings::analyze/$1');
$routes->put('task-manager/meetings/(:num)/actions/(:num)', 'Meetings::reviewAction/$1/$2');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
