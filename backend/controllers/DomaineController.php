<?php

require_once dirname(__DIR__) . '/services/DomaineService.php';

class DomaineController
{
    private DomaineService $service;

    public function __construct()
    {
        $this->service = new DomaineService();
    }

    public function handleRequest(): void
    {
        header('Content-Type: application/json');

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                echo json_encode($this->service->listerDomaines());
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $input = json_decode(file_get_contents('php://input'), true) ?? [];
                echo json_encode($this->service->ajouterDomaine($input));
                return;
            }

            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
        } catch (InvalidArgumentException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur MySQL : ' . $e->getMessage()]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
