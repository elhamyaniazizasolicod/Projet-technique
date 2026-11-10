<?php
require_once __DIR__ . '/../../services/MatiereService.php';

class ControllerMatiere
{
    private MatiereService $matiereService;

    public function __construct(?MatiereService $matiereService = null)
    {
        $this->matiereService = $matiereService ?? new MatiereService();
    }

    public function handle(string $method): void
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if ($method === 'GET') {
                $matieres = array_map(
                    [self::class, 'toArray'],
                    $this->matiereService->listerMatieres()
                );
                $this->respond($matieres);
                return;
            }

            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
                if (!is_array($data) || !is_string($data['nom'] ?? null) || !is_string($data['description'] ?? null)) {
                    $this->respond(['error' => 'Le nom et la description sont obligatoires.'], 400);
                    return;
                }

                $matiere = $this->matiereService->ajouterMatiere($data['nom'], $data['description']);
                $this->respond(self::toArray($matiere), 201);
                return;
            }

            header('Allow: GET, POST');
            $this->respond(['error' => 'Méthode non autorisée.'], 405);
        } catch (JsonException $exception) {
            $this->respond(['error' => 'Le corps de la requête doit être un JSON valide.'], 400);
        } catch (InvalidArgumentException $exception) {
            $this->respond(['error' => $exception->getMessage()], 422);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $this->respond(['error' => 'Une erreur est survenue lors du traitement de la demande.'], 500);
        }
    }

    private static function toArray(Matiere $matiere): array
    {
        return [
            'id' => $matiere->getId(),
            'nom' => $matiere->getNom(),
            'description' => $matiere->getDescription(),
        ];
    }

    private function respond(array $payload, int $status = 200): void
    {
        http_response_code($status);
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}

$controller = new ControllerMatiere();
$controller->handle($_SERVER['REQUEST_METHOD'] ?? 'GET');