<?php

namespace Goteo\Controller\Admin {

    use Goteo\Core\View,
        Goteo\Core\Redirection,
        Goteo\Core\Error,
		Goteo\Library\Feed,
		Goteo\Library\Message,
        Goteo\Model;

    class Nodes {

        public static function process ($action = 'list', $id = null, $filters = array()) {

            $errors = array();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // objeto
                $node = new Model\Node(array(
                    'id' => $_POST['id'],
                    'name' => $_POST['name'],
                    'admin' => $_POST['admin'],
                    'active' => $_POST['active']
                ));

				if ($node->create($errors)) {

                    if ($_POST['action'] == 'add') {
                        Message::Info('Nodo creado');
                        $txt_log = 'creado';
                    } else {
                        Message::Info('Nodo actualizado');
                        $txt_log = 'actualizado';
					}

                    // Evento feed
                    $log = new Feed();
                    $log->populate('Nodo gestionado desde admin', 'admin/nodes',
                        \vsprintf('El admin %s ha %s el Nodo %s', array(
                            Feed::item('user', $_SESSION['user']->name, $_SESSION['user']->id),
                            Feed::item('relevant', $txt_log),
                            Feed::item('project', $_POST['name']))
                        ));
                    $log->doAdmin('admin');
                    unset($log);

                    if ($_POST['action'] == 'add') {
                        Message::Info('Puedes asignar ahora sus administradores');
                        throw new Redirection('/admin/nodes/admins/'.$node->id);
                    }

				}
				else {
                    switch ($_POST['action']) {
                        case 'add':
                            Message::Error('Fallo al crear, revisar los campos');

                            return new View(
                                'view/admin/index.html.php',
                                array(
                                    'folder' => 'nodes',
                                    'file' => 'add',
                                    'action' => 'add'
                                )
                            );
                            break;
                        case 'edit':
                            Message::Error('Fallo al actualizar, revisar los campos');

                            return new View(
                                'view/admin/index.html.php',
                                array(
                                    'folder' => 'nodes',
                                    'file' => 'edit',
                                    'action' => 'edit',
                                    'node' => $node
                                )
                            );
                            break;
                    }
				}
			}

            switch ($action) {
                case 'add':
                    return new View(
                        'view/admin/index.html.php',
                        array(
                            'folder' => 'nodes',
                            'file' => 'add',
                            'action' => 'add',
                            'node' => null
                        )
                    );
                    break;
                case 'edit':
                    $node = Model\Node::get($id);

                    return new View(
                        'view/admin/index.html.php',
                        array(
                            'folder' => 'nodes',
                            'file' => 'edit',
                            'action' => 'edit',
                            'node' => $node
                        )
                    );
                    break;
                case 'admins':
                    $node = Model\Node::get($id);

                    if (isset($_GET['op']) && isset($_GET['user']) && in_array($_GET['op'], array('assign', 'unassign'))) {
                        if ($node->$_GET['op']($_GET['user'])) {
                            // ok
                        } else {
                            Message::Error(implode('<br />', $errors));
                        }
                    }

                    $node->admins = Model\Node::getAdmins($node->id);
                    $admins = Model\User::getAdmins(true);

                    return new View(
                        'view/admin/index.html.php',
                        array(
                            'folder' => 'nodes',
                            'file' => 'admins',
                            'action' => 'admins',
                            'node' => $node,
                            'admins' => $admins
                        )
                    );
                    break;
            }


            $nodes = Model\Node::getAll($filters);
            $status = array(
                        'active' => 'Activo',
                        'inactive' => 'Inactivo'
                    );
            $admins = Model\Node::getAdmins();

            return new View(
                'view/admin/index.html.php',
                array(
                    'folder' => 'nodes',
                    'file' => 'list',
                    'filters' => $filters,
                    'nodes' => $nodes,
                    'status' => $status,
                    'admins' => $admins
                )
            );
            
        }

    }

}
