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
            case 'edit':
                $this->edit();
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

    private function edit()
    {
        $noteId = $_POST['noteId'] ?? null;
        $content = $_POST['noteInput'] ?? '';
        $priority = $_POST['priority'] ?? 1;
        $color = $_POST['color'] ?? '#FFF9C4';

        if (empty($noteId)) {
            header("Location:" . ROOT_PATH . "/?alert=Geen notitie opgegeven");
            exit();
        }

        if (empty($content)) {
            header("Location:" . ROOT_PATH . "/?alert=Notitie mag niet leeg zijn");
            exit();
        }

        $priority = max(1, min(3, (int)$priority));

        if (!preg_match('/^#[a-f0-9]{6}$/i', $color)) {
            $color = '#FFF9C4';
        }

        Database::update('notes', [
            'content' => htmlspecialchars($content, ENT_QUOTES),
            'priority' => $priority,
            'color' => $color,
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $noteId]);

        header("Location:" . ROOT_PATH . "/?alert=Notitie bijgewerkt");
        exit();
    }
}

$note = new NoteController();
$note->handleRequest();
