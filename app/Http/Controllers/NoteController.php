<?php

namespace App\Http\Controllers;

use App\Database\Database;

class NoteController
{
    public function handleRequest()
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';
        require_once __DIR__ . '/../../Config/config.php';
        $action = $_POST['action'] ?? '';
        session_start();

        switch ($action) {
            case 'add':
                $this->add();
                break;
            case 'done':
                $this->done();
                break;
            default:
                header("Location:" . ROOT_PATH . "/?alert=Invalid note action");
                exit();
        }
    }

    private function add()
    {
        $message = $_POST['noteInput'] ?? '';

        if (empty($message)) {
            header("Location:" . ROOT_PATH . "/?alert=Vul alle velden in");
            exit();
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (empty($userId)) {
            header("Location:" . ROOT_PATH . "/?alert=Je moet ingelogd zijn om een notitie toe te voegen");
            exit();
        }

        if (strlen($message) > 100) {
            header("Location:" . ROOT_PATH . "/?alert=Notitie mag maximaal 100 karakters zijn");
            exit();
        }

        Database::add('notes', [
            'user_id' => $userId,
            'content' => $message
        ]);

        header("Location:" . ROOT_PATH . "/?alert=Notitie toegevoegd");
    }

    private function done()
    {
        $noteId = $_POST['noteId'] ?? null;

        if (empty($noteId)) {
            header("Location:" . ROOT_PATH . "/?alert=Geen notitie opgegeven");
            exit();
        }

        Database::delete('notes', ['id' => $noteId]);

        header("Location:" . ROOT_PATH . "/?alert=Notitie verwijderd");
        exit();
    }
}

$note = new NoteController();
$note->handleRequest();
